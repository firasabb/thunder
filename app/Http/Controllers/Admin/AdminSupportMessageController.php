<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportMessage;
use Validator;
use URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminSupportMessageController extends Controller
{
    
    /**
     * Index message for admins.
     * @param array $messages.
     * @return View
     */
    public function index($order = '', $desc = true, $messages = null){

        // Order By Options For Filtering
        $orderByOptions = ['id', 'email'];

        $defaultOrder = 'id';

        if(!$messages){
            if($order){
                if(in_array($order, $orderByOptions) === TRUE){
                    $defaultOrder = $order;
                }
            }
            if($desc){
                $messages = SupportMessage::orderBy($defaultOrder, 'desc');
            }
            if(!$desc){
                $messages = SupportMessage::orderBy($defaultOrder, 'asc');
            }

        }

        $messages = $messages->paginate(20);

        return view('admin.messages.index', ['messages' => $messages, 'order' => $order, 'desc' => $desc]);
    }


    /**
     * Show a message for admins.
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $message = SupportMessage::findOrFail($id);
        return view('admin.messages.show', ['message' => $message]);
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
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully');
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
