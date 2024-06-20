<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Validator;
use URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminSubscriberController extends Controller
{
    
    /**
     * Index message for admins.
     * @param array $subscribers.
     * @return View
     */
    public function index($order = '', $desc = true, $subscribers = null){

        // Order By Options For Filtering
        $orderByOptions = ['id', 'email'];

        $defaultOrder = 'id';

        if(!$subscribers){
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $subscribers = Subscriber::orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $subscribers = Subscriber::orderBy($defaultOrder, 'asc');
            }

        }

        $subscribers = $subscribers->paginate(20);

        return view('admin.subscribers.index', ['subscribers' => $subscribers, 'order' => $order, 'desc' => $desc]);
    }


    /**
     * Show a subscriber for admins.
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        return view('admin.subscribers.show', ['status' => $subscriber]);
    }

    
    /**
     * Delete a message for admins
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $message = SupportMessage::findOrFail($id);
        $message->delete();
        return redirect()->route('admin.index.messages')->with('status', 'A message has been deleted!');
    }



    /**
     * Search messages for admins.
     * @param  Request
     * @return adminIndex()
     */

    public function search(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'title' => 'string|max:300|nullable'
        ]);

        if($validator->fails() || empty($request->all())){
            return redirect()->route('admin.index.messages')->withErrors($validator)->withInput();
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

        $messages = SupportMessage::where($whereArr);

        if(empty($messages)){
            return $this->adminIndex();
        }
        return $this->adminIndex('', false, $messages);
    }

}
