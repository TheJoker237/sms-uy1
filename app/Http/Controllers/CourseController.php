<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Filiere;
use Brian2694\Toastr\Facades\Toastr;

class CourseController extends Controller
{
    // index page setting
    public function course()
    {
        $courseList=Course::all();
        $filiereList=Filiere::all();
        return view('course.course', compact('courseList','filiereList'));
    }

    /** academic save record */
    public function CourseSave(Request $request)
    {
        $request->validate([
            'code'    => 'required|string',
            'title'    => 'required|string',
        ]);
        // dd($request->academic_year);
        
        DB::beginTransaction();
        try {
            if(!empty($request->code) && !empty($request->title) && !empty($request->filiere)) {
                $course = new Course;
                $course->code= $request->code;
                $course->title= $request->title;
                $course->filiere_id = Filiere::where('title',$request->filiere)->first()->id;
                // dd($course);
                $course->save();
                Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            }
            return redirect()->back(); 
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new course  :)','Error');
            return redirect()->back();
        }
    }

    /** view for academic year edit */
    // public function CourseEdit($id)
    // {
    //     $courseList = Course::all();
    //     $course = Course::where('id',$id)->first();
    //     return view('course.edit-course',compact('courseList','course'));
    // }

    /** Edit record */
    public function CourseEdit(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request);

            if (!empty($request->code) && !empty($request->title)) {
           
            $updateRecord = [
                'code' => $request->code,
                'title' => $request->title,
                'filiere_id' => Filiere::where('title',$request->filiere)->first()->id,

            ];
            Course::where('id',$request->id)->update($updateRecord);
            
            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
            }
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update course  :)','Error');
            return redirect()->back();
        }
    }

    /** academic delete */
    public function CourseDelete(Request $request)
    {
        DB::beginTransaction();
        try {
           
            if (!empty($request->id)) {
                Course::destroy($request->id);
                DB::commit();
                Toastr::success('Course deleted successfully :)','Success');
                return redirect()->back();
            }
    
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Course deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
