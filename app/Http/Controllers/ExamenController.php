<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Examen;
use App\Models\Faculte;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class ExamenController extends Controller
{
    public function examen()
    {
        $examenList = Examen::all();
        return view('examen.examen',compact('examenList'));
    }

    public function examenAdd()
    {
        $faculteList = Faculte::all();
        $filiereList = Filiere::all();
        $courseList = Course::all();
        return view('examen.add-examen', compact('faculteList','filiereList','courseList'));
    }

    /** examen save record */
    public function examenSave(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'gender'        => 'required|not_in:0',
            'date_of_birth' => 'required|string',
            'roll'          => 'required|string',
            'blood_group'   => 'required|string',
            'religion'      => 'required|string',
            'email'         => 'required|email',
            'class'         => 'required|string',
            'section'       => 'required|string',
            'admission_id'  => 'required|string',
            'phone_number'  => 'required',
            'upload'        => 'required|image',
        ]);
        
        DB::beginTransaction();
        try {
           
            $upload_file = rand() . '.' . $request->upload->extension();
            $request->upload->move(storage_path('app/public/examen-photos/'), $upload_file);
            if(!empty($request->upload)) {
                $examen = new Examen;
                $examen->first_name   = $request->first_name;
                $examen->last_name    = $request->last_name;
                $examen->gender       = $request->gender;
                $examen->date_of_birth= $request->date_of_birth;
                $examen->roll         = $request->roll;
                $examen->blood_group  = $request->blood_group;
                $examen->religion     = $request->religion;
                $examen->email        = $request->email;
                $examen->class        = $request->class;
                $examen->section      = $request->section;
                $examen->admission_id = $request->admission_id;
                $examen->phone_number = $request->phone_number;
                $examen->upload = $upload_file;
                $examen->save();

                Toastr::success('Has been add successfully :)','Success');
                DB::commit();
            }

            return redirect()->back();
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, Add new examen  :)','Error');
            return redirect()->back();
        }
    }

    /** view for edit examen */
    public function studentEdit($id)
    {
        $studentEdit = examen::where('id',$id)->first();
        return view('examen.edit-examen',compact('studentEdit'));
    }

    /** update record */
    public function studentUpdate(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->upload)) {
                unlink(storage_path('app/public/examen-photos/'.$request->image_hidden));
                $upload_file = rand() . '.' . $request->upload->extension();
                $request->upload->move(storage_path('app/public/examen-photos/'), $upload_file);
            } else {
                $upload_file = $request->image_hidden;
            }
           
            $updateRecord = [
                'upload' => $upload_file,
                'first_name'   => $request->first_name,
                'last_name'    => $request->last_name,
                'gender'       => $request->gender,
                'date_of_birth'=> $request->date_of_birth,
                'roll'         => $request->roll,
                'blood_group'  => $request->blood_group,
                'religion'     => $request->religion,
                'email'        => $request->email,
                'class'        => $request->class,
                'section'      => $request->section,
                'admission_id' => $request->admission_id,
                'phone_number' => $request->phone_number,
            ];
            examen::where('id',$request->id)->update($updateRecord);
            
            Toastr::success('Has been update successfully :)','Success');
            DB::commit();
            return redirect()->back();
           
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('fail, update examen  :)','Error');
            return redirect()->back();
        }
    }

    /** examen delete */
    public function studentDelete(Request $request)
    {
        DB::beginTransaction();
        try {
           
            if (!empty($request->id)) {
                examen::destroy($request->id);
                unlink(storage_path('app/public/examen-photos/'.$request->avatar));
                DB::commit();
                Toastr::success('examen deleted successfully :)','Success');
                return redirect()->back();
            }
    
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('examen deleted fail :)','Error');
            return redirect()->back();
        }
    }
}
