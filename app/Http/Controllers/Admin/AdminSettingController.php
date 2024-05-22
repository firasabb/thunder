<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;
use URL;

class AdminSettingController extends Controller
{
    
    /**
     * Index settings for admins.
     * @param array $settings.
     * @return View
     */
    public function index($order = '', $desc = false, $settings = null){

        // Order By Options For Filtering
        $orderByOptions = ['id', 'title'];

        $defaultOrder = 'id';

        if(!$settings){
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $settings = Setting::orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $settings = Setting::orderBy($defaultOrder, 'asc');
            }

        }

        $settings = $settings->paginate(20);

        return view('admin.settings.index', [
            'settings' => $settings, 
            'order' => $order, 
            'desc' => $desc
        ]);
    }


    
    /**
     * 
     * Show the create or update settings
     * @param Request
     * @return View
     * 
     */
    public function create(Request $request){
        $setting = null;
        if($request->id){
            $setting = Setting::findOrFail($request->id);
        }

        return view('admin.settings.create', [
            'setting'   => $setting,
        ]);
    }


    /**
     * Add settings for admins.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request, $id = null)
    {

        $request->validate([
            'name'          => 'required|string|max:255',
            'value'         => 'nullable|string|max:65535',
        ]);

        if($id){
            $setting = Setting::findOrFail($request->id);
        } else {
            $setting = new Setting();
        }

        $setting->name = $request->name;
        $setting->value = $request->value;
        $setting->save();

        return redirect()->route('admin.settings.index')->with('message', trans('admin.setting created'));

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
