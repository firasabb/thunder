<?php

namespace Quetab\QuetabPanel\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Quetab\QuetabPanel\Models\MediaObject;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;
use URL;

class AdminMediaController extends Controller
{
    
    /**
     * Index media files for admins.
     * @param string $order
     * @param boolean $desc
     * @param array $medias.
     * @return View
     */
    public function index($order = '', $desc = false, $medias = null){

        // Order By Options For Filtering
        $orderByOptions = ['id', 'title'];

        $defaultOrder = 'id';

        if(!$medias){
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $medias = MediaObject::orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $medias = MediaObject::orderBy($defaultOrder, 'asc');
            }
        }

        $medias = $medias->paginate(20);

        return view('admin.media.index',
            [
                'medias' => $medias, 
                'order' => $order,
                'desc' => $desc
            ]
        );
    }


    
    /**
     * 
     * Show the create or update page
     * @param Request
     * @return View
     * 
     */
    public function create(Request $request){
        $page = null;
        if($request->id){
            $page = Page::findOrFail($request->id);
        }

        $availableStatuses = Page::STATUSES;

        return view('admin.pages.create', [
            'page'                  => $page,
            'availableStatuses'     => $availableStatuses,
        ]);
    }


    /**
     * Add a category for admins.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request, $id = null)
    {

        $request->validate([
            'title'     => 'required|string|max:255',
            'mediaFile' => 'required|file',
        ]);

        $media = new MediaObject();
        $media->title = $request->title;
        $media->save();

        $uuid = $media->uuid;
        $extension = '';
        $mimeType = '';
        $size = '';

        // Process the uploaded file
        if($request->hasFile('mediaFile')) {
            if($request->file('mediaFile')->isValid()) {
                $extension = $request->file('mediaFile')->getClientOriginalExtension();
                $filename = $uuid . '.' . $extension;
                $mimeType = $request->file('mediaFile')->getMimeType();
                $size = $request->file('mediaFile')->getSize();
                $uploadedMedia = $media->addMediaFromRequest('mediaFile')
                     ->usingFileName($filename)
                     ->usingName($uuid)
                     ->toMediaCollection('medias', 'public');
            }
        }

        // Update the media object with the file details
        $media->size = $size;
        $media->mime_type = $mimeType;
        $media->filename = $filename;
        $media->url = isset($uploadedMedia) ? $uploadedMedia->getUrl() : '';
        $media->save();

        return back()->with('message', trans('admin.media added'));

    }


    /**
     * 
     * Get the page info
     * @param Request
     * @return JSON
     * 
     */
    public function get(Request $request){
        $page = Page::where('id', $request->id)->firstOrFail();
        return response()->json($page);
    }


    /**
     * Show a page for admins.
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.show', ['page' => $page]);
    }


    /**
     * Edit the page for admins.
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'     => 'string|max:255',
            'body'      => 'nullable|string',
            'url'       => 'string|nullable',
            'featured'  => 'nullable|image|max:3000'
        ]);

        if($validator->fails()){
            return redirect()->route('admin.show.page', ['id' => $id])->withErrors($validator)->withInput();
        } 

        $page->title = $request->title;
        $request->url = Str::slug($request->url, '-');
        if($request->url != $page->url){
            $check = Page::where(['url' => $request->url])->first();
            if(!empty($check)){
                return redirect()->route('admin.show.page', ['id' => $id])->withErrors('The url has already been taken.')->withInput();
            }
            $page->url = $request->url;
        }
        $page->body = $request->body;
        $page->save();

        if($request->hasFile('featured')) {
            if($request->file('featured')->isValid()) {

                $media = $page->getMedia('featured');
                if($media && isset($media[0])){
                    $media[0]->delete();
                }

                $unique = uniqid();
                $filename = $unique . '.' . $request->file('featured')->getClientOriginalExtension();
                $page->addMediaFromRequest('featured')
                     ->usingFileName($filename)
                     ->usingName($unique)
                     ->withResponsiveImages()
                     ->toMediaCollection('featured', 's3_media');
            }
        }
        
        return redirect()->route('admin.show.page', ['id' => $id])->with('status', 'This page has been edited');
    }

    /**
     * Delete a media file for admins
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $media = MediaObject::findOrFail($id);
        $media->delete();
        return redirect()->route('admin.media.list')->with('status', trans('admin.media deleted'));
    }



    /**
     * Search pages for admins.
     * @param  Request
     * @return adminIndex()
     */

    public function search(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'title' => 'string|max:300|nullable'
        ]);

        if($validator->fails() || empty($request->all())){
            return redirect()->route('admin.index.pages')->withErrors($validator)->withInput();
        }

        $title = $request->title;
        $id = $request->id;
        
        $whereArr = array();

        if($title){

            $titleWhere = ['title', 'LIKE', '%' . $title . '%'];
            array_push($whereArr, $titleWhere);

        } if ($id){

            $idWhere = ['id', '=', $id];
            array_push($whereArr, $idWhere);

        }

        $pages = Page::where($whereArr);

        if(empty($pages)){
            return $this->adminIndex();
        }
        return $this->adminIndex('', false, $pages);
    }

}
