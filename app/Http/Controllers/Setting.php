<?php

namespace App\Http\Controllers;

use App\Models\Pv;
use App\Models\Note;
use App\Models\Doyen;
use App\Models\Course;
use App\Models\Examen;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Session;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Controle;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Builder;

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

    // /** view for academic year edit */
    // public function academicYearEdit($id)
    // {
    //     $academicYears = AcademicYear::all();
    //     $academicYear = academicYear::where('id',$id)->first();
    //     return view('setting.edit-academicYear',compact('academicYears','academicYear'));
    // }

    /** update record */
    public function academicYearEdit(Request $request)
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
            Toastr::error('Academic Year deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /**
     * ? Doyen Show Set Change and Unset
     */

    public  function doyen(){
        $doyens = Doyen::all();
        $teachers = Teacher::all();
        return view('setting.doyen',compact('doyens','teachers'));
    }

    public function doyenSet(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->new_id;
            if (!empty($request->new_id)) {

                $doyen = Doyen::create([
                    'created_at' => now(),
                    ]);
                    $teacher = Teacher::find($id);
                    $teacher->teacherable()->associate($doyen)->save();
                DB::commit();
                Toastr::success('Doyen Set successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Doyen Set fail :)','Error');
            return redirect()->back();
        }
    }

    public function doyenUnset(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            if (!empty($request->id)) {

                $doyen = Doyen::find($id);
                $teacher = $doyen->teacher;
                $teacher->teacherable()->dissociate($doyen)->save();
                Doyen::destroy($id);

                DB::commit();
                Toastr::success('Doyen Unset successfully :)','Success');
                return redirect()->back();
            }

        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Doyen Unset fail :)','Error');
            return redirect()->back();
        }
    }

    public function doyenChange(Request $request){
        // dd($request);
        DB::beginTransaction();
        try {
            $old_id = $request->id;
            $new_id = $request->new_id;
            if (!empty($request->new_id)) {
                $doyen = Doyen::find(Teacher::find($old_id)->teacherable_id);

                // ? dissociate Last Teacher to Doyen
                $teacher = Teacher::find($old_id);
                $teacher->teacherable()->dissociate($doyen)->save();

                // ? Associate New Teacher to Doyen
                $teacher = Teacher::find($new_id);
                $teacher->teacherable()->associate($doyen)->save();
                
                // Update the Doyen Record
                $updateRecord = [
                    'updated_at' => now(),
                ];
                $doyen->update($updateRecord);

                DB::commit();
                Toastr::success('Doyen Change successfully :)','Success');
                return redirect()->back();
            }
        
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Doyen Change fail :)','Error');
            return redirect()->back();
        }
    }


    /**
     * ! Just for test My Seeding Queries - going to be deleted
     */
    public function testQueries()
    {

        if ($noteRecord = Note::where('notes.student_id',1)->get())
            {
                dd($noteRecord);
            }
        $i  = 3;
        switch ($i) {
            case $i > 2 && $i < 4:
                dd('interval');
                break;
            
            default:
                # code...
                break;
        }

        die();
        Note::find(1)->update(['value'=> 0]);

        dd('dd');
        $id = 1;
        $courseId = Pv::find(1)->course->id;
        $session = 'Normale';

        $query = "select r1.year , r1.effectif, r1.capitalisation, r1.session, r1.code, r1.title, r1.value, r1.tp, r2.student_id, r2.first_name, r2.last_name
        from (select ay.id as ay_id, ay.year,p.id as p_id ,p.academic_year_id as aca_year, p.effectif,p.capitalisation, p.session, p.course_id , c.code, c.id as c_id ,c.title, c.filiere_id, ce.id as ce_id, ce.course_id as cours_examen_course_id, 
               ce.examen_id as course_examen_examen_id, ex.id as ex_id , ex.academic_Year_id, ex.date, ex.status, ex.examable_id, ex.examable_type, se.id as se_id , se.type, n.id as n_id, n.value, n.tp , n.examen_id, n.student_id
            
        from academic_years as ay , pvs as p , courses as c, course_examen as ce, examens as ex , sessions as se, notes as n
        where ay.id = p.academic_year_id and p.course_id = c.id and c.id = ce.course_id and ce.examen_id = ex.id and ex.examable_id = se.id 
              and n.course_id = c.id and n.examen_id = ex.id and se.type= '".$session."' and p.session = '".$session."' and c.id = ".$courseId." ) as r1 right join 
        
        (select st.* , us.id as us_id, us.first_name, us.last_name from students as st, filieres as fil, courses as c , users as us where st.filiere_id = fil.id and c.filiere_id = fil.id and c.id = 1 and st.id = us.userable_id and us.userable_type=".DB::getPdo()->quote(Student::class)." ) as r2 
        
        on r1.student_id = r2.id";

        $res = DB::select($query);
        dd($res[0]);
        
            //   select r1.year , r1.effectif, r1.capitalisation, r1.session, r1.code, r1.title, r1.value, r1.tp, r1.student_id, r2.first_name, r2.last_name
            //   from 
        //       as r1 right join 
        
        // (select st.* , us.id as us_id, us.first_name, us.last_name from students as st, filieres as fil, courses as c , users as us where st.filiere_id = fil.id and c.filiere_id = fil.id and c.id = 1 and st.id = us.userable_id and us.userable_type=".DB::raw("'App\Models\Student'")." ) as r2 
        
        // $students = Student::join('users','users.userable_id','students.id')
        // ->where('users.userable_type',Student::class)
        // ->join('filieres','students.filiere_id','=','filieres.id')
        // ->join('courses','courses.filiere_id','=','filieres.id')
        // ->get();
        // dd($students);
        // // on r1.student_id = r2.id";
        
        // $res = DB::select($query);
        // $notes = DB::table('notes')
        //         ->joinSub($query, 'courses', function ($join) {
        //          $join->on('notes.course_id', '=', 'courses.c_id');
        //          $join->on('notes.course_id', '=', 'courses.ex_id');
        //          ->joinSub($students, 'students', function($join){
        //           $join->on('students.id','=','courses.student_id');
        //          })
        // })->get();

        // $res = 

        $query = DB::select(DB::raw("select * from users where users.`userable_type` =".DB::getPdo()->quote(Student::class).""));
        dd($query);
        
        // dd($notes);

        $courses = DB::table('academic_years')
        ->join('pvs','academic_years.id','=','pvs.academic_year_id')
        ->join('courses','courses.id','=','pvs.course_id')
        ->join('course_examen','course_examen.course_id','=','courses.id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->join('sessions','examens.examable_id','=','sessions.id')
        ->where('pvs.session','Normale')
        ->where('sessions.type','Normale')
        ->where('courses.id',1)
        ->join('notes','examens.id','=','notes.examen_id')
        ->join('notes as n','courses.id','=','notes.course_id')
        ->join('filieres','courses.filiere_id','=','filieres.id')
        ->join('students','students.id','=','notes.student_id')
        ->get();
        dd($courses);
        $users = DB::table('users')
        ->join('contacts', 'users.id', '=', 'contacts.user_id')
        ->join('orders', 'users.id', '=', 'orders.user_id')// you may add more joins
        ->select('users.*', 'contacts.phone', 'orders.price')
        ->get();

        // ->select('pvs.*','courses.*','notes.*')
        // ->select('pvs.*','courses.*','notes.*','students.*')
        // ->get();

        // dd($pvListNormale);
        // $pvListNormale = AcademicYear::join('pvs','academic_years.id','=','pvs.academic_year_id')
        // ->join('courses','courses.id','=','pvs.course_id')
        // ->join('course_examen','course_examen.course_id','=','courses.id')
        // ->join('examens','course_examen.examen_id','=','examens.id')
        // ->join('sessions','examens.examable_id','=','sessions.id')
        // ->get();

        // // ->join('filieres','courses.filiere_id','=','filieres.id')
        // ->join('notes','examens.id','=','notes.examen_id')
        // // ->join('students','students.id','=','notes.student_id')
        // ->where('pvs.session','Normale')
        // ->where('sessions.type','Normale')
        // ->where('courses.id',1)
        // ->select('pvs.*','courses.*','notes.*')
        // // ->select('pvs.*','courses.*','notes.*','students.*')
        // ->get();

        // dd($pvListNormale);


        $latestPosts = DB::table('posts')
                   ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
                   ->where('is_published', true)
                   ->groupBy('user_id');
 
        $users = DB::table('users')
                ->joinSub($latestPosts, 'latest_posts', function ($join) {
                 $join->on('users.id', '=', 'latest_posts.user_id');
        })->get();


        $studentInfo = Student::join('filieres','students.filiere_id','=','students.id')
        ->join('courses','courses.filiere_id','=','filieres.id')
        ->join('users','students.id','=','users.userable_id')
        ->where('users.userable_type',Student::class);

        $q = DB::raw($query);
        $s = DB::select($q);
        dd($s);
        /* $query = "select *
        from (select ay.id as ay_id, ay.year,p.id as p_id ,p.academic_year_id as aca_year, p.effectif,p.capitalisation, p.session, p.course_id , c.code, c.id as c_id ,c.title, c.filiere_id, ce.id as ce_id, ce.course_id as cours_examen_course_id, 
               ce.examen_id as course_examen_examen_id, ex.id as ex_id , ex.academic_Year_id, ex.date, ex.status, ex.examable_id, ex.examable_type, se.id as se_id , se.type, n.id as n_id, n.value, n.tp , n.examen_id, n.student_id
            
        from academic_years as ay , pvs as p , courses as c, course_examen as ce, examens as ex , sessions as se, notes as n
        where ay.id = p.academic_year_id and p.course_id = c.id and c.id = ce.course_id and ce.examen_id = ex.id and ex.examable_id = se.id 
              and n.course_id = c.id and n.examen_id = ex.id and se.type= 'Normale' and p.session = 'Normale' and c.id = 1) as r1 right join 
        
        (select st.* from students as st, filieres as fil, courses as c where st.filiere_id = fil.id and c.filiere_id = fil.id and c.id = 1) as r2 
        
        on r1.student_id = r2.id";
        $q = DB::select($query);
        dd($q[0]->student_id); */


        // $pvListNormale = Pv::find(1)
        // ->join('courses','courses.id','=','pvs.course_id')
        // ->join('filieres','courses.filiere_id','=','filieres.id')
        // ->join('students','filieres.id','=','students.filiere_id')
        // ->join('notes','students.id','=','notes.student_id')
        // ->select('pvs.*','courses.*','notes.*','students.*')
        // ->get();
        $pvListNormale = Pv::find(1)
        ->join('courses','courses.id','=','pvs.course_id')
        ->join('course_examen','course_examen.course_id','=','courses.id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->join('sessions','examens.examable_id','=','sessions.id')
        ->where('sessions.type','Normale')
        ->join('filieres','courses.filiere_id','=','filieres.id')
        ->join('notes','courses.id','=','notes.course_id')
        ->join('students','students.id','=','notes.student_id')
        ->select('pvs.*','courses.*','notes.*','students.*')
        ->get();

        dd($pvListNormale);

        $pvListRattrapage = Pv::where('session','Rattrapage');
        dd($pvListRattrapage);
        
        $session = 'Rattrapage';
        $students = Student::join('notes','students.id','=','notes.student_id')
            ->join('examens','notes.examen_id','=','examens.id')
            ->where('examens.examable_type',Session::class)
            ->join('course_examen','examens.id','=','course_examen.course_id')
            ->where('course_examen.course_id',6)
            ->join('sessions','examens.examable_id','=','sessions.id')
            ->where('sessions.type',$session)
            ->select('notes.*')
            ->get();

        foreach($students as $student)
        {
            echo $student->value;
        }
        dd($students);

        $courses = Course::all();
        $course = Course::find(1);
        dd(count($course->filiere->students));

        $noteF = Examen::whereHasMorph('examable',Controle::class)
        ->join('course_examen','examens.id','=','course_examen.examen_id')
        ->where('examens.id',1)
        ->join('notes','course_examen.course_id','=','notes.course_id')
        ->get();
        

        dd($noteF);

        $notes = Examen::join('notes','examens.id','=','notes.examen_id')
        ->where('examens.id',1)
        // ->where('examens.examable_id',1)
        ->where('examens.examable_type',Controle::class)
        ->where('notes.course_id',1)
        ->get();

        $notesExamen = Note::join('course_examen','course_examen.course_id','=','notes.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Controle::class)
        ->where('course_examen.course_id',1)
        ->get();

        // $courses = Course::join('notes')

        $courses = Course::join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->join('notes','course_examen.course_id','=','notes.course_id')
        ->where('examens.examable_type',Controle::class)
        ->where('course_examen.examen_id',1)
        // ->select('')
        ->get();

        // dd($courses);
        // dd($notesExamen);
        $course = Course::find(1);
        $student = Student::find(1);

        $student = Student::join('notes','notes.student_id','=','students.id')
        ->where('students.id',1)
        ->join('examens','examens.id','=','notes.examen_id')
        ->where('examable_type',Session::class)
        ->join('courses','courses.id','=','notes.course_id')
        ->where('courses.id',1)
        ->join('sessions','sessions.id','=','examens.examable_id')
        ->where('sessions.type','Rattrapage')
        ->select('notes.value')
        ->get()[0]->value;

        dd($student);
     
        $noteControle = Examen::whereHasMorph('examable',Controle::class)->join('academic_years','examens.academic_Year_id','=','academic_years.id')
        ->where('academic_years.state','Active')
        ->join('course_examen','examens.id','=','course_examen.examen_id')
        ->join('courses','course_examen.course_id','=','courses.id')
        ->join('notes','notes.course_id','=','courses.id')
        ->join('students','notes.student_id','=','students.id')
        ->where('courses.id',$course->id)
        ->where('students.id',$student->id)
        ->select('notes.*')
        ->get();

        dd($noteControle);

        $noteControle = Examen::whereHasMorph('examable',Controle::class)->join('academic_years','examens.academic_Year_id','=','academic_years.id')
        ->where('academic_years.state','Active')
        ->join('course_examen','examens.id','=','course_examen.examen_id')
        ->join('courses','course_examen.course_id','=','courses.id')
        ->join('notes','notes.course_id','=','courses.id')
        ->join('students','notes.student_id','=','students.id')
        ->where('courses.id',$course->id)
        ->where('students.id',$student->id)
        ->select('notes.*')
        ->get();

        dd($noteControle);

        $examType = Controle::all();
        dd(count($examType));


        $courseList = Course::join('filieres','courses.filiere_id','=','filieres.id')
        ->select('courses.*')
        ->where('filieres.id','1')
        ->get();
        dd($courseList);
        // $filieres = array();
        foreach($courseList as $key=>$filiere)
        {
            // $filieres[$key] = [
            //     'id' => $filiere->id,
            //     'title' => $filiere->title,
            // ];
            dd($filiere);
        };

        $idFiliere = 1;
        $FacultyListSession = Course::join('filieres','filieres.id','=','courses.filiere_id')
        ->join('course_examen','courses.id','=','course_examen.course_id')
        ->join('examens','course_examen.examen_id','=','examens.id')
        ->where('examens.examable_type',Session::class)
        ->where('filieres.id',$idFiliere)
        ->select('courses.*')
        ->distinct()
        ->get();

        dd($FacultyListSession);
        // $course = Course::find(1);

        // $studentCourseType = Student::join('filieres','students.filiere_id','=', 'filieres.id')
        // ->join('courses','courses.filiere_id','=', 'filieres.id')
        // ->where('courses.id',$course->id)
        // ->select('students.*')->get();

        // dd($studentCourseType);

        // $idFacType = Faculte::where('title','Faculty Of Sciences')->first()->id;
        //     $coursesFacType = Course::join('filieres','courses.filiere_id','=','filieres.id')
        //     ->where('filieres.faculte_id',$idFacType)
        //     ->select('courses.*')
        //     ->get();
        //     // dd($coursesFacType);
            
        //     $studentFacType = Student::join('filieres','students.filiere_id','=', 'filieres.id')
        //     ->join('facultes','filieres.faculte_id','=', 'facultes.id')
        //     ->where('facultes.title','Faculty Of Sciences')
        //     ->select('students.*')->get();

        //     dd($studentFacType);
            

        $noteControleList = Note::join('examens','notes.examen_id','=','examens.id')
        ->where('examable_type',Session::class)
        ->get();

        dd($noteControleList);

        $noteControle = Note::join('examens','notes.examen_id','=','examens.id')
        // ->join('course_examen','examens.id','=', 'course_examen.examen_id')
        // ->join('courses','course_examen.course_id','=','courses.id')
        ->where('examable_type',Session::class)
        ->get();
        
        dd($noteControle);
        foreach($noteControle as $note)
        {
            dd($note->title);
        }
        // $noteControleList = Examen::whereHasMorph(
        //     'examable',
        //     Controle::class,
        // )
        // ->get();
        // dd($noteControleList);

        // foreach($noteControleList as $note){
        //     dd($note->etudiant);
        // }

        $studentFacsc = Student::join('filieres','filiere_id','=', 'filieres.id')->join('facultes','faculte_id','=', 'facultes.id')
        ->where('facultes.title','Faculty Of Sciences')
        ->select('students.*')->get();

        dd($studentFacsc);

        // // dd($controleList);

        // foreach ($studentList as $student)
        // {
        //     dd($student->filiere);
        //     foreach($student->examens as $examen)
        //     {
        //         foreach($examen->courses as $course){
        //             dd($course);
        //         }
        //     }
        // }

        // $controleList = Controle::find(1);
        // $examens = $controleList->examens;
        // foreach($examens as $examen){
        //     // dd($examen);
        //     foreach($examen->courses as $course){
        //         dd($course);
        //     }
        // }
    }
}
