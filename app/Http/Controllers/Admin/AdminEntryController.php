<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entry;
use Validator;
use URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;

class AdminEntryController extends Controller
{
    
    /**
     * Index entries for admins.
     * @param array $pages.
     * @return View
     */
    public function index($order = '', $desc = false, $entries = null){

        // Order By Options For Filtering
        $orderByOptions = ['id', 'title'];

        $defaultOrder = 'id';

        if(!$entries){
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $entries = Entry::whereNotNull('verified_at')->orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $entries = Entry::whereNotNull('verified_at')->orderBy($defaultOrder, 'asc');
            }

        }

        $entries = $entries->paginate(20);

        return view('admin.entries.index',
            [
                'entries' => $entries, 
                'order' => $order, 
                'desc' => $desc
            ]);
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
     * Show a entry for admins.
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $entry = Entry::findOrFail($id);
        return view('admin.entries.show', ['entry' => $entry]);
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



    public function exportTxt(){

        $entries = Entry::whereNotNull('verified_at')->get();
        $text = '';
        foreach($entries as $entry){
            $email = $entry->email;
            $entryTeams = $entry->teams;
            $text .= '"' . $email . '",' . $entry->created_at . ', ';
            $all = 0;
            foreach($entryTeams as $entryTeam){
                $team = $entryTeam->team;
                if(!$team){
                    continue;
                }
                $city = $team->city;
                $state = $team->state;
                $conference = $entryTeam->conference;
                $teamText = "$team->name-$team->city-$team->state";
                switch($conference){
                    case 'all':
                        $all++;
                        if($all > 1){
                            $text .= "$all- $teamText, ";
                        } else {
                            $text .= "All: $all- $teamText, ";
                        }
                        break;
                    case 'winner':
                        $text .= "Winner: $teamText.";
                        break;
                    default:
                        $text .= "$conference: $teamText, ";
                        break;
                }
            }
            $text .= PHP_EOL;
        }

        // file name: YYYYMMDD
        $fileName = date('Ymd') . '.txt';

        // make a response, with the text, a 200 response code and the headers
        return Response::make($text, 200, [
            'Content-type' => 'text/plain', 
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
            'Content-Length' => strlen($text)
        ]);
    }

}
