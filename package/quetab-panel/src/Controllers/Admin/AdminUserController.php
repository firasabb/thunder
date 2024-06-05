<?php

namespace Quetab\QuetabPanel\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Quetab\QuetabPanel\Models\User;
use Auth;
use Validator;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{

    /**
     * 
     * Index The Users With Filters For Admins
     * @param string $order
     * @param bool $desc
     * @param array or null Users
     * @return View
     * 
     */
    public function index($order = '', $desc = false, $users = null){

        
        // Order By Options For Filtering
        // To show all table columns use the line below and comment the second line
        //$orderByOptions = DB::getSchemaBuilder()->getColumnListing($usersTable);
        $orderByOptions = ['id', 'username', 'status'];

        $defaultOrder = 'id';

        if(!$users){
            // Check if the filter is valid
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $users = User::orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $users = User::orderBy($defaultOrder, 'asc');
            }
        }

        $users = $users->paginate(20);

        $user = new User();
        $usersTable = $user->getTable();

        // Get all the user's statuses
        $statuses = DB::table($usersTable)->select('status')->distinct()->pluck('status');

        $roles = Role::all();
        return view('admin.users.index', ['users' => $users, 'statuses' => $statuses, 'roles' => $roles, 'order' => $order, 'desc' => $desc]);

    }

    
    /**
     * 
     * Show The User's Info For Admins 
     * @param int user id
     * @return View
     * 
     */
    public function show($id){

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.show', ['user' => $user, 'roles' => $roles]);

    }


    /**
     * 
     * Add a User Admins 
     * @param Request $request
     * @return RedirectResponse
     * 
     */
    public function add(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => 'min:3|max:30|required',
            'last_name' => 'min:3|max:30|required',
            'username' => 'required|unique:users',
            'email' => 'email|required',
            'roles' => 'array|required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.index.users')->withErrors($validator)->withInput(Input::except('password'));
        }

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();

        $roles = $request->roles;

        $user->assignRole($roles);

        return redirect()->route('admin.index.users')->with('status', 'User has been added successfully!');

    }


    /**
     * 
     * Edit The User's Info For Admins 
     * @param int user id
     * @param Request $request
     * @return RedirectResponse
     * 
     */
    public function edit($id, Request $request){

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'min:3|max:30',
            'last_name' => 'min:3|max:30',
            'email' => 'email',
            'roles' => 'array'
        ]);

        if($validator->fails()){
            return redirect()->route('admin.show.user', ['id' => $user->id])->withErrors($validator)->withInput(Input::except('password'));
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->save();

        $roles = $request->roles;

        $user->syncRoles($roles);


        return redirect()->route('admin.show.user', ['id' => $user->id])->with('status', 'User has been edited successfully!');

    }

    
    /**
     * 
     * Delete The User For Admins 
     * Please note that soft delete is activated
     * @param int user id
     * @return RedirectResponse
     * 
     */
    public function delete($id){

        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.index.users')->with('status', 'User has been deleted!');

    }


    /**
     * 
     * Generate a Password For The User For Admins 
     * @param int user id
     * @return RedirectResponse
     * 
     */
    public function generatePassword($id){
        
        $user = User::findOrFail($id);
        $generatedPassword = $this->generateString();
        $user->password = bcrypt($generatedPassword);
        $user->save();

        return redirect()->route('admin.show.user', ['id' => $user->id])->with('status', 'User password has been changed to:  ' . $generatedPassword);

    }



    /**
     * 
     * Search Users For Admins  
     * @param Request $request
     * @return indexusers($users)
     * 
     */
    public function search(Request $request){
        
        $users = array();

        $validator = Validator::make($request->all(), [
            'email' => 'nullable',
            'id' => 'integer|nullable',
            'first_name' => 'string|max:50|nullable',
            'last_name' => 'string|max:50|nullable',
            'username' => 'string|max:100|nullable'
        ]);
            if($validator->fails() || empty($request->all())){
                return redirect()->route('admin.index.users')->withErrors($validator)->withInput();
            }
        $email = $request->email;
        $id = $request->id;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $username = $request->username;

        $where_arr = array();

        if($email){

            $email_where = ['email', 'LIKE', '%' .  $email . '%'];
            array_push($where_arr, $email_where);

        } if ($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if($first_name){

            $name_where = ['first_name', 'LIKE', '%' . $first_name . '%'];
            array_push($where_arr, $name_where);

        } if($last_name){

            $name_where = ['last_name', 'LIKE', '%' . $last_name . '%'];
            array_push($where_arr, $name_where);

        } if($username){

            $username_where = ['username', 'LIKE', '%' . $username . '%'];
            array_push($where_arr, $username_where);

        }

        $users = User::where($where_arr);

        if(empty($users)){
            return $this->indexUsers();
        }
        return $this->indexUsers('', '', $users);
    }


    /**
     * 
     * Filter Users From Ajax Request
     * NOT USED
     * FOR FUTURE UPDATES
     * 
     */
    public function filter(Request $request){

        $request->validate([
            'email' => 'email|nullable',
            'first_name' => 'string|max:50|nullable',
            'last_name' => 'string|max:50|nullable',
            'username' => 'string|max:50|nullable',
            'status' => 'string|nullable',
            'order' => 'string|nullable',
            'id' => 'int|nullable'
        ]);

        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $username = $request->username;
        $id = $request->id;
        $status = $request->status;
        $order = $request->order;

        $users = new User();

        $whereArray = array();

        if($email){
            $whereArray[] = ['email', 'LIKE' ,$email];
        }
        if($first_name){
            $whereArray[] = ['first_name', 'LIKE' ,$first_name];
        }
        if($last_name){
            $whereArray[] = ['last_name', 'LIKE' ,$last_name];
        }
        if($username){
            $whereArray[] = ['username', 'LIKE' ,$username];
        }
        if($status){
            $whereArray[] = ['status', $status];
        }
        if($id){
            $whereArray[] = ['id' ,$id];
        }

        if(!empty($whereArray)){
            $users = $users->where($whereArray);
        }

        if($order){
            $users = $users->orderBy($order, 'DESC');
        }

        $this->adminIndex($order, true, $users);


    }


    /**
     * 
     * Generate a random password
     * @param int $ln password length
     * @return string
     * 
     */
    private function generateString($ln = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $generatedString = '';
        for($i = 0; $i < $ln; $i++){
            $generatedString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $generatedString;
    }


    /**
     * 
     * Force Log out all devices
     * @param int
     * 
     */
    public function loginAs(int $id){

        $user = User::findOrFail($id);
        Auth::login($user);

        return redirect()->route('user.dashboard');
    }


    /**
     * 
     * Block user
     * @param int
     * 
     */
    public function toggleBan(int $id){

        $user = User::findOrFail($id);

        if($user->status != 'banned'){
            $user->status = 'banned';
        } else {
            $user->status = 'active';
        }

        $user->save();

        return back();

    }

}
