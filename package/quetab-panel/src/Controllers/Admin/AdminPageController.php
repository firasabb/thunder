<?php

namespace Quetab\QuetabPanel\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Quetab\QuetabPanel\Models\Page;
use Validator;
use URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminPageController extends Controller
{
    
    /**
     * Index pages for admins.
     * @param array $pages.
     * @return View
     */
    public function index($order = '', $desc = false, $pages = null){

        // Order By Options For Filtering
        $orderByOptions = ['id', 'title'];

        $defaultOrder = 'id';

        if(!$pages){
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $pages = Page::orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $pages = Page::orderBy($defaultOrder, 'asc');
            }

        }

        $pages = $pages->paginate(20);

        return view('admin.pages.index', ['pages' => $pages, 'order' => $order, 'desc' => $desc]);
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
            'url'       => 'nullable|string|max:255',
            'body'      => 'nullable|string',
            'status'    => ['required', Rule::in(Page::STATUSES)],
            'featured'  => 'nullable|image|max:3000',
        ]);

        if($id){
            $page = Page::findOrFail($request->id);
        } else {
            $page = new Page();
        }

        $page->title = $request->title;

        // Check the url
        $pageUrl = $request->url ?? strtolower($request->title);
        $pageUrl = Str::limit($pageUrl, 100, '');
        $pageUrl = Str::slug($pageUrl, '-');
        $check = Page::where([['url', $pageUrl]])->first();
        if(!empty($check)){
            // Check if the url is the same as the current page
            if($check->id != $page->id){
                return back()->withErrors('The url has already been taken.')->withInput();
            }
        }

        $page->url = $pageUrl;
        $page->body = $request->body;
        $page->status = $request->status;
        $page->save();

        if($request->hasFile('featured')) {
            if($request->file('featured')->isValid()) {

                // Delete the old featured image if it exists
                if($page->featured){
                    $page->featured->delete();
                }

                $unique = uniqid();
                $filename = $unique . '.' . $request->file('featured')->getClientOriginalExtension();
                $page->addMediaFromRequest('featured')
                     ->usingFileName($filename)
                     ->usingName($unique)
                     ->toMediaCollection('featured', 'public');
            }
        }

        return back()->with('message', 'A new page has been created!');

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
     * Delete a page for admins
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.index.pages')->with('status', 'A page has been deleted!');
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
