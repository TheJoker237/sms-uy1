<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class UserManagementController extends Controller
{
    // index page
    public function index()
    {
        $users = User::all();
        return view('usermanagement.list_users',compact('users'));
    }

    /** user view */
    public function userView($id)
    {
        $user = User::where('id',$id)->first();
        return view('usermanagement.user_update',compact('user'));
    }

    /** user Update */
    public function userUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if (Session::get('role_name') === 'Admin' || Session::get('role_name') === 'Super Admin')
            {
                $username     = $request->name;
                $firstName    = $request->first_name;
                $lastName     = $request->last_name;
                $email        = $request->email;
                $role_name    = $request->role_name;
                $phone        = $request->phone_number;
                $status       = $request->status;
                $id           = $request->user_id;
                if($request->avatar)
                {
                    $image_name = time() . '.' . $request->avatar->extension();
                    $image_name = $request->file('avatar')->storeAs('images',$image_name,'public');
                }
                else{
                    $image_name = User::find($id)->avatar;
                }
            
                $update = [
                    'username'     => $username,
                    'first_name'   => $firstName,
                    'last_name'    => $lastName,
                    'role_name'    => $role_name,
                    'email'        => $email,
                    'phone_number' => $phone,
                    'status'       => $status,
                    'avatar'       => $image_name,
                    'updated_at'   => now(),
                ];

                User::where('id',$id)->update($update);
            } else {
                Toastr::error('User update fail :)','Error');
            }
            DB::commit();
            Toastr::success('User updated successfully :)','Success');
            return redirect()->back();

        } catch(\Exception $e){
            DB::rollback();
            Toastr::error('User update fail :)','Error');
            return redirect()->back();
        }
    }

    /** user delete */
    public function userDelete(Request $request)
    {
        $id = $request->user_id;
        DB::beginTransaction();
        try {
            if (Session::get('role_name') === 'Super Admin')
            {
                if (! $request->avatar =='images/photo_defaults.jpg')
                {
                    Storage::disk('public')->delete($request->avatar);
                }
                //Need to destroy any polymorphic parent if exist
                if($type = User::find($id)->userable_type){
                    if($type == Teacher::class){
                        //Delete Teacher
                        Teacher::destroy($id);
                    }
                    elseif($type == Teacher::class){
                        // Delete Student
                        Student::destroy($id);
                    }
                }
                else{
                    User::destroy($id);
                }
            } else {
                Toastr::error('User deleted fail :)','Error');
            }

            DB::commit();
            Toastr::success('User deleted successfully :)','Success');
            return redirect()->back();
    
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('User deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** change password */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        DB::commit();
        Toastr::success('User change successfully :)','Success');
        return redirect()->intended('home');
    }
}
