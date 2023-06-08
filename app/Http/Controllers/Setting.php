<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class Setting extends Controller
{
    // index page setting
    public function index()
    {
        return view('setting.settings');
    }

    public function academicYear()
    {
        $academicYears = AcademicYear::all();
        return view('setting.academicYear', compact('academicYears'));
    }

    /** academic save record */
    public function academicYearSave(Request $request)
    {
        $request->validate([
            'academic_year'    => 'required|string',
        ]);
        // dd($request->academic_year);
        
        DB::beginTransaction();
        try {
            if(!empty($request->academic_year)) {
                $academicYear = new academicYear;
                $academicYear->year= date('Y-m-d', strtotime($request->academic_year));
                // dd($academicYear->year);
                $academicYear->save();
                Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            }
            return redirect()->back(); 
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new year  :)','Error');
            return redirect()->back();
        }
    }

    /** view for academic year edit */
    public function academicYearEdit($id)
    {
        $academicYears = AcademicYear::all();
        $academicYear = academicYear::where('id',$id)->first();
        return view('setting.edit-academicYear',compact('academicYears','academicYear'));
    }

    /** update record */
    public function academicYearUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request);

            if (!empty($request->academic_year)) {
           
            $updateRecord = [
                'year' => date('Y-m-d', strtotime($request->academic_year)),
            ];
            academicYear::where('id',$request->id)->update($updateRecord);
            
            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
            }
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update academic year  :)','Error');
            return redirect()->back();
        }
    }

    /** academic delete */
    public function academicYearDelete(Request $request)
    {
        DB::beginTransaction();
        try {
           
            if (!empty($request->id)) {
                academicYear::destroy($request->id);
                DB::commit();
                Toastr::success('Academic Year deleted successfully :)','Success');
                return redirect()->back();
            }
    
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Student deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
