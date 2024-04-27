<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;

class PageController extends Controller
{
    
    public function show(String $url){

        if($url == 'contact-us'){
            return view('pages.contactus');
        } 
        
        $page = Page::where('url', $url)->firstOrFail();
        return view('pages.show', ['page' => $page]);

    }

}
