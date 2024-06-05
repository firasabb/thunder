<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Page;
use App\Models\SupportMessage;
use App\Models\Entry;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{

    /**
     * 
     * View the admin dashboard.
     * @return View
     * 
     */
    public function dashboard(){

        $fromDate = Carbon::now()->subWeek();

        $totalUserCount = User::count();
        $totalPageCount = Page::count();
        $totalMessageCount = SupportMessage::count();
        $totalEntryCount = Entry::count();

        $lastMessages = SupportMessage::orderBy('id', 'desc')->take(10)->get();

        return view('admin.dashboard', [
            'totalUserCount'        =>  $totalUserCount,
            'totalMessageCount'     =>  $totalMessageCount,
            'totalPageCount'        =>  $totalPageCount,
            'lastMessages'          =>  $lastMessages,
            'totalEntryCount'       =>  $totalEntryCount
        ]);
    }

}