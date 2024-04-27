<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
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
     * Add a category for admins.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'     => 'required|string|max:255',
            'url'       => 'nullable|string|max:255',
            'body'      => 'nullable|string',
            'featured'  => 'nullable|image|max:3000'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        } 

        $page = new Page();
        $page->title = $request->title;
        $pageUrl = $request->url ?? strtolower($request->title);
        $pageUrl = Str::slug($pageUrl, '-');
        $check = Page::where(['url' => $pageUrl])->first();
        if(!empty($check)){
            return redirect()->route('admin.index.categories')->withErrors('The url has already been taken.')->withInput();
        }

        $page->url = $pageUrl;
        $page->body = $request->body;
        $page->save();

        if($request->hasFile('featured')) {
            if($request->file('featured')->isValid()) {
                $unique = uniqid();
                $filename = $unique . '.' . $request->file('featured')->getClientOriginalExtension();
                $page->addMediaFromRequest('featured')
                     ->usingFileName($filename)
                     ->usingName($unique)
                     ->withResponsiveImages()
                     ->toMediaCollection('featured', 's3_media');
            }
        }

        return back()->with('status', 'A new page has been created!');

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
