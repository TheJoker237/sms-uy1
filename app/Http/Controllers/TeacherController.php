<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public $titleTeachers = [
        'Assistant' => 'Dr.',
        'Charge de Cours' => 'Dr.',
        'Maitre de Conferences' => 'Pr.',
        'Professeur' => 'Pr.',
    ];

    /** add teacher page */
    public function teacherAdd()
    {
        return view('teacher.add-teacher');
    }

    /** teacher list */
    public function teacherList()
    {
        $listTeacher = Teacher::all();
        return view('teacher.list-teachers',compact('listTeacher'));
    }

    /** teacher Grid */
    public function teacherGrid()
    {
        $teacherGrid = Teacher::all();
        return view('teacher.teachers-grid',compact('teacherGrid'));
    }

    /** save record */
    public function saveRecord(Request $request)
    {
        $defaultAvatar = 'images/default_avatar.png';
        $roleName = 'Teacher';
        $request->validate([
            'grade'           => 'required|string',
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'gender'          => 'required|string',
            'date_of_birth'   => 'required|string',
            'mobile'          => 'required|string',
            'experience'      => 'required|string',
            'username'        => 'required|string',
            'email'           => 'required|string',
            'password'        => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'address'         => 'required|string',
            'city'            => 'required|string',
            'country'         => 'required|string',
        ]);

        try {

            $firstName    = $request->first_name;
            $lastName     = $request->last_name;
            $userName     = $request->username;
            $grade        = $request->grade;
            $title        = $this->titleTeachers[$grade];
            $experience   = $request->experience;
            $gender       = $request->gender;
            $dob          = $request->date_of_birth;
            $phone        = $request->mobile;
            $email        = $request->email;
            $password     = Hash::make($request->password);
            $address      = $request->address;
            $city         = $request->city;
            $country      = $request->country;
            
            if($request->avatar)
            {
                $image_name = time() . '.' . $request->avatar->extension();
                $image_name = $request->file('avatar')->storeAs('images',$image_name,'public');
            }
            else{
                $image_name = $defaultAvatar;
            }
            
            $lastTeacher = Teacher::create([
                'title'      => $title,
                'grade'      => $grade,
                'experience' => $experience,
                'created_at' => now(),
            ]);
            
            $user = new User([
                'first_name'   => $firstName,
                'last_name'    => $lastName,
                'username'     => $userName,
                'gender'       => $gender,
                'avatar'       => $image_name,
                'email'        => $email,
                'date_of_birth'=> $dob,
                'phone_number' => $phone,
                'role_name'    => $roleName,
                'email_verified_at' => now(),
                'password'     => $password, // password
                'address'      => $address,
                'city'         => $city,
                'country'      => $country,
                'created_at'   => now(),
            ]);
            $lastTeacher->user()->save($user);

            Toastr::success('Has been add successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            // \Log::info($e);
            DB::rollback();
            Toastr::error('fail, Add new record  :)','Error');
            return redirect()->back();
        }
    }

    /** edit record */
    public function editRecord($id)
    {
        $teacher = Teacher::where('id',$id)->first();
        return view('teacher.edit-teacher',compact('teacher'));
    }

    /** update record teacher */
    public function updateRecordTeacher(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $firstName    = $request->first_name;
            $lastName     = $request->last_name;
            $grade        = $request->grade;
            $title        = $this->titleTeachers[$grade];
            $experience   = $request->experience;
            $gender       = $request->gender;
            $dob          = $request->date_of_birth;
            $phone        = $request->mobile;
            $address       = $request->address;
            $city         = $request->city;
            $country       = $request->country;
            $id           = $request->id;
            if($request->avatar)
            {
                $image_name = time() . '.' . $request->avatar->extension();
                $image_name = $request->file('avatar')->storeAs('images',$image_name,'public');
            }
            else{
                $image_name = User::find($id)->avatar;
            }

            $updateRecord = [
                'title'      => $title,
                'grade'      => $grade,
                'experience' => $experience,
                'updated_at' => now(),
            ];
            $teacher = Teacher::where('id',$id);
            $teacher->update($updateRecord);

            $userRecord = [
                'first_name'   => $firstName,
                'last_name'    => $lastName,
                'gender'       => $gender,
                'avatar'       => $image_name,
                'date_of_birth'=> $dob,
                'phone_number' => $phone,
                'address'       => $address,
                'city'         => $city,
                'country'      => $country,
                'updated_at' => now(),
            ];
            User::where('userable_id',$id)->where('userable_type',Teacher::class)->update($userRecord);
            
            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update record  :)','Error');
            return redirect()->back();
        }
    }

    /** delete record */
    public function teacherDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            Teacher::destroy($request->id);
            //Delete the User related to this teacher
            User::destroy($request->id);
            DB::commit();
            Toastr::success('Deleted record successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Deleted record fail :)','Error');
            return redirect()->back();
        }
    }
}
