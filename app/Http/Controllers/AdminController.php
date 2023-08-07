<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
class AdminController extends Controller
{
    public function list(){
        $data['getRecord'] = User::getAdmin();
        $data ['header_title'] = 'Admin List';
        return view('admin.admin.list',$data);
    }

    public function add(){
        $data ['header_title'] = 'Add new Admin';
        return view('admin.admin.add',$data);
    }

    public function insert(Request $request){
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type=1;
        $user->save();

        return redirect('admin/admin/list')->with('success',"Admin successfully created");
    }

    public function edit($id){
        $data['getRecord'] = User::getSingle($id);
        if(!empty($data['getRecord'])){
            $data ['header_title'] = 'Edit Admin';
            return view('admin.admin.edit',$data);
        } else{
            abort(404);
        }
    }

    public function update($id,Request $request){
        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success',"Admin successfully updated");
    }

    public function delete($id){

        //it will delete in action but still have in database
        $user = User::getSingle($id);
        $user->is_delete == 1;
        $user->save();

        return redirect('admin/admin/list')->with('success',"Admin successfully deleted");
    }

        // $user = User::getSingle($id);
        // // Check if the user exists
        // if ($user) {
        //     // Delete the user
        //     $user->delete();

        //     // Optionally, you can redirect or return a response
        //     return redirect('admin/admin/list')->with('success', 'User deleted successfully.');
        // }

        // // User not found, handle the error
        // return redirect('admin/admin/list')->with('error', 'User not found.');
    //}
}
