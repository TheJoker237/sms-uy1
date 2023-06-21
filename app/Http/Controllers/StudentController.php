<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $studentList = Student::all();
        return view('student.student',compact('studentList'));
    }

    /** index page student grid */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid',compact('studentList'));
    }

    /** student add page */
    public function studentAdd()
    {
        return view('student.add-student');
    }
    
    /** student save record */
    public function studentSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'username'      => 'required|string',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|string',
            'religion'      => 'required|string',
            'email'         => 'required|email',
            'admission_id'  => 'required|string',
            'phone_number'  => 'required',
            'avatar'        => 'required|image',
        ]);
        
        DB::beginTransaction();
        try {
            $roleName = 'Student';
            $defaultAvatar = 'images/default_avatar.png';
            $firstName    = $request->first_name;
            $lastName     = $request->last_name;
            $userName     = $request->username;
            $gender       = $request->gender;
            $email        = $request->email;
            $dob          = $request->date_of_birth;
            $phone        = $request->phone_number;
            $religion     = $request->religion;
            $studentId    = $request->admission_id;
            $password     = $request->password;
            $id           = $request->id;
            if($request->avatar)
            {
                $image_name = time() . '.' . $request->avatar->extension();
                $image_name = $request->file('avatar')->storeAs('images',$image_name,'public');
            }
            else{
                $image_name = $defaultAvatar;
            }

            $student = Student::create([
                'religion'   => $religion,
                'student_id' => $studentId,
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
                'join_date' => now(),
                'role_name' => $roleName,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'created_at' => now(),
            ]);
            $student->user()->save($user);

            Toastr::success('Has been add successfully :)','Success');
            DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new student  :)','Error');
            return redirect()->back();
        }
    }

    /** view for edit student */
    public function studentEdit($id)
    {
        $studentEdit = Student::where('id',$id)->first();
        return view('student.edit-student',compact('studentEdit'));
    }

    /** update record */
    public function studentUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $firstName    = $request->first_name;
            $lastName     = $request->last_name;
            $userName     = $request->username;
            $gender       = $request->gender;
            $email        = $request->email;
            $dob          = $request->date_of_birth;
            $phone        = $request->phone_number;
            $religion     = $request->religion;
            $studentId    = $request->admission_id;
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
                'religion'   => $religion,
                'student_id' => $studentId,
                'updated_at' => now(),
            ];
            $student = Student::where('id',$id);
            $student->update($updateRecord);

            $userRecord = [
                'first_name'   => $firstName,
                'last_name'    => $lastName,
                'username'    => $userName,
                'gender'       => $gender,
                'avatar'       => $image_name,
                'email'        => $email,
                'date_of_birth'=> $dob,
                'phone_number' => $phone,
                'updated_at' => now(),
            ];
            User::where('userable_id',$id)->where('userable_type',Student::class)->update($userRecord);

            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update student  :)','Error');
            return redirect()->back();
        }
    }

    /** student delete */
    public function studentDelete(Request $request)
    {
        DB::beginTransaction();
        try {
           
            if (! $request->avatar =='images/photo_defaults.jpg')
            {
                Storage::disk('public')->delete($request->avatar);
            }
            Student::destroy($request->id);
            //Delete the User related to this student
            User::destroy($request->id);
            DB::commit();
            Toastr::success('Student deleted successfully :)','Success');
            return redirect()->back();
    
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Student deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** student profile page */
    public function studentProfile($id)
    {
        $studentProfile = Student::where('id',$id)->first();
        return view('student.student-profile',compact('studentProfile'));
    }
}
