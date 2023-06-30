<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Examen;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Session;
use App\Models\Controle;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Response;

class ExamenController extends Controller
{
    public function examenControle()
    {
        $controleList = Controle::all();
        return view('examen.examen-controle', compact('controleList'));
    }

    public function examenSession()
    {
        $sessionList = Session::all();   
        return view('examen.examen-session', compact('sessionList'));
    }
    public function examenControleList()
    {
        $controleList = Controle::all();
        return view('examen.examen-controle-list', compact('controleList'));
    }

    public function examenSessionList()
    {
        $sessionList = Session::all();   
        return view('examen.examen-session-list', compact('sessionList'));
    }
    public function controleGroupByFaculty()
    {
        $facultyListControle = Faculte::join('filieres','facultes.id','=','filieres.faculte_id')
        ->join('courses','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Controle::class)
        ->select('facultes.*')
        ->groupby('facultes.title')
        ->get();
        return view('examen.controle-faculty',compact('facultyListControle'));
    }
    public function controleGroupByFiliere($idFaculty)
    {
        $idFac = $idFaculty; 
        $filiereListControle = Filiere::join('facultes','facultes.id','=','filieres.faculte_id')
        ->join('courses','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Controle::class)
        ->where('facultes.id',$idFaculty)
        ->select('filieres.*')
        ->groupby('filieres.title')
        ->get();
        return view('examen.controle-filiere',compact('filiereListControle','idFac'));
    }
    public function controleShowForFiliere($idFaculty, $idFiliere)
    {
        $idFac = $idFaculty;
        $idFil = $idFiliere;
        $courseListControle = Course::join('filieres','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Session::class)
        ->where('filieres.id',$idFiliere)
        ->select('courses.*')
        ->distinct()
        ->get();
        return view('examen.controle-filiere-list',compact('courseListControle','idFaculty','idFiliere'));
    }
    public function sessionGroupByFaculty()
    {
        $facultyListSession = Faculte::join('filieres','facultes.id','=','filieres.faculte_id')
        ->join('courses','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Session::class)
        ->select('facultes.*')
        ->groupby('facultes.title')
        ->get();
        return view('examen.session-faculty',compact('facultyListSession'));
    }
    public function sessionGroupByFiliere($idFaculty)
    {
        $idFac = $idFaculty; 
        $filiereListSession = Filiere::join('facultes','facultes.id','=','filieres.faculte_id')
        ->join('courses','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Session::class)
        ->where('facultes.id',$idFaculty)
        ->select('filieres.*')
        ->groupby('filieres.title')
        ->get();
        return view('examen.session-filiere',compact('filiereListSession','idFac'));
    }
    public function sessionShowForFiliere($idFaculty, $idFiliere)
    {
        $idFac = $idFaculty;
        $id = $idFiliere;
        $courseListSession = Course::join('filieres','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Session::class)
        ->where('filieres.id',$idFiliere)
        ->select('courses.*')
        ->distinct()
        ->get();
        return view('examen.session-filiere-list',compact('courseListSession','idFaculty','idFiliere'));
    }
    public function examen()
    {
        $examenList = Examen::all();
        return view('examen.examen',compact('examenList'));
    }

    public function examenFiliere($id)
    {
        $examenFiliere = Filiere::has('examens')->get();
        return view('examen.examen-filiere',compact('examenFiliere'));
    }

    public function examenManageFiliere(Request $request)
    {
        $i = 0;
        foreach($request->facultes as $faculte){
            $filiereList = Filiere::join('facultes','filieres.faculte_id','=','facultes.id')
            ->select('filieres.*')
            ->where('facultes.title',$faculte)
            ->get();
            foreach($filiereList as $filiere)
            {
                $filieres[$i++] = [
                    'id' => $filiere->id,
                    'title' => $filiere->title,
                ];
            };
        }
  
        return Response::json($filieres);
    }
    public function examenManageCourse(Request $request)
    {
        $i = 0;
        foreach($request->Idfilieres as $id){
            $courseList = Course::join('filieres','courses.filiere_id','=','filieres.id')
            ->select('courses.*')
            ->where('filieres.id',$id)
            ->get();
            foreach($courseList as $course)
            {
                $courses[$i++] = [
                    'id' => $course->id,
                    'title' => $course->title,
                ];
            };
        }
  
        return Response::json($courses);
    }

    public function examenAdd()
    {
        $faculteList = Faculte::all();
        return view('examen.add-examen', compact('faculteList'));
    }

    /** examen save record */
    public function examenSave(Request $request)
    {
        $request->validate([
            'faculte'    => 'required',
            'filiere'     => 'required',
            'course'     => 'required',
            'type'     => 'required',
            // 'session'     => 'required',
            'date_of_exam'     => 'required',
        ]);
        
        DB::beginTransaction();
        try {
            // $facultes = $request->faculte;
            // $filieresId = $request->filiere;
            $coursesId = $request->course;            
            $type = $request->type;
            $date = date('Y-m-d', strtotime($request->date_of_exam));
            if($request->session)           
                $session = $request->session;            

            // dd($request);
            $examen = new Examen([
                'date' => $date,
                'status' => 'Pending',
                'created_at' => now(),
            ]);
            
            $academicYear = AcademicYear::where('state','Active')->first();
            $academicYear->examens()->save($examen);
            $examType = null;

            if($type == 'Controle Continue')
            {
                $examType = Controle::create([
                    'created_at' => now(),
                ]);
            }
            else
            {
                $examType = Session::create([
                    'type' => $session,
                    'created_at' => now(),
                ]);

            }

            $examen->examable()->associate($examType)->save();
            foreach($coursesId as $courseId)
            {
                $examen->courses()->attach($courseId);
            }
            
            Toastr::success('Examen Has been add successfully :)','Success');
            DB::commit();
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
