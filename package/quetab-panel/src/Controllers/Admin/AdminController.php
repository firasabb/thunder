<?php

namespace Quetab\QuetabPanel\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Quetab\QuetabPanel\Models\User;
use Quetab\QuetabPanel\Models\Page;
use Quetab\QuetabPanel\Models\SupportMessage;
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
        $weeklyUserCount = User::selectRaw('DATE(created_at) as y, COUNT(*) as x')
            ->where('created_at', '>', Carbon::now()->subYears(2))
            ->groupBy('y')
            ->get();
        
        $totalPageCount = Page::count();
        $totalMessageCount = SupportMessage::count();

        $lastMessages = SupportMessage::orderBy('id', 'desc')->take(10)->get();

        return view('admin.dashboard', [
            'totalUserCount'        =>  $totalUserCount,
            'totalMessageCount'     =>  $totalMessageCount,
            'totalPageCount'        =>  $totalPageCount,
            'weeklyUserCount'       =>  $weeklyUserCount,
            'lastMessages'          =>  $lastMessages
        ]);
    }

}