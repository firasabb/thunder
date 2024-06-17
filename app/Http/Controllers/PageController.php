<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools;
use App\Models\SupportMessage;
use App\Models\Setting;
use App\Models\Subscriber;

class PageController extends Controller
{
    
    public function show(String $url){

        if($url == 'contact-us'){
            return view('pages.contactus');
        } 
        
        $page = Page::where('url', $url)->firstOrFail();
        return view('pages.show', ['page' => $page]);

    }


    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $message = new SupportMessage();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->body = $request->message;
        $message->subject = $request->subject;
        $message->phone = $request->phone;
        $message->save();

        return redirect()->route('landing')->with('success', 'Message sent successfully');
    }


    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['message' => 'Subscribed successfully']);
    }

}

/***
 * 
 * 
 * You accurately pick the 12 teams that will enter this year's playoffs, and the eventual National Championship, and you win $1M!
 * Submit your entry:
 * In order to submit your entry you will pick 5 conference champions and 7 other teams that you think will have the best chance to get and enter the 12-team playoffs.
 * 
 * 
 * Choose ACC conference champion
 * 
 * Choose a Team from All Other Conferences Who You Think Will Have The Best Record
 * 
 * Choose a Champion from All Other Conferences
 * 
 * Choose 7 Other Teams You Think Will Have the Best Chance to Be Selected for the 12-Team Playoff
 */