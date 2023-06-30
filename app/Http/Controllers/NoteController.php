<?php

namespace App\Http\Controllers;

use App\Models\Pv;
use App\Models\Note;
use App\Models\Examen;
use App\Models\Session;
use App\Models\Controle;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{

    protected $guarded = [];

    public function noteControle()
    {
        // $noteControleList =  Note::join('examens','examen_id','=','examens.id')
        // ->where('examable_type',Controle::class)
        // ->get();
        $noteControleList = Note::join('examens','notes.examen_id','=','examens.id')
        ->where('examable_type',Controle::class)
        ->get();
        return view('note.note-controle',compact('noteControleList'));
    }

    public function noteSession()
    {
        $noteSessionList = Note::join('examens','notes.examen_id','=','examens.id')
        ->where('examable_type',Session::class)
        ->get();
        return view('note.note-session',compact('noteSessionList'));
    }

    public function noteAdd()
    {
        $faculteList = [];
        $filiereList = [];
        $courseList = [];
        return view('note.add-note', compact('faculteList','filiereList','courseList'));
    }

    public function pvList()
    {
        $pvList = Pv::all();

        return view('note.pv-list',compact('pvList'));
    }

    public function pvSessionNormale()
    {
        $pvListNormale = Pv::where('session','Normale')->get();
        return view('note.pv-normale', compact('pvListNormale'));
    }
    public function pvSessionRattrapage()
    {
        $pvListRattrapage = Pv::where('session','Rattrapage')->get();
        return view('note.pv-rattrapage', compact('pvListRattrapage'));
    }
    public function pvSessionNormaleCourse($idPv)
    {
        $id = $idPv;
        $courseId = Pv::find($id)->course->id;
        $session = 'Normale';
        
        $query = "select r1.year , r1.effectif, r1.capitalisation, r1.session, r1.code, r1.title, r1.cc, r1.tp, r1.ex, r1.total, r1.totalShort, r1.mention,r1.mentionShort,r1.dec, r2.student_id, r2.first_name, r2.last_name
        from (select ay.id as ay_id, ay.year,p.id as p_id ,p.academic_year_id as aca_year, p.effectif,p.capitalisation, p.session, p.course_id , c.code, c.id as c_id ,c.title, c.filiere_id, ce.id as ce_id, ce.course_id as cours_examen_course_id, 
               ce.examen_id as course_examen_examen_id, ex.id as ex_id , ex.academic_Year_id, ex.date, ex.status, ex.examable_id, ex.examable_type, se.id as se_id , se.type, n.id as n_id, n.cc, n.tp , n.ex ,
              n.ex as n_ex, n.total, n.totalShort, n.mention,n.mentionShort,n.dec, n.examen_id, n.student_id
            
        from academic_years as ay , pvs as p , courses as c, course_examen as ce, examens as ex , sessions as se, notes as n
        where ay.id = p.academic_year_id and p.course_id = c.id and c.id = ce.course_id and ce.examen_id = ex.id and ex.examable_id = se.id 
              and n.course_id = c.id and n.examen_id = ex.id and se.type= '".$session."' and p.session = '".$session."' and ex.examable_type = ".DB::getPdo()->quote(Session::class)." and c.id = ".$courseId." ) as r1 right join 
        
        (select st.* , us.id as us_id, us.first_name, us.last_name from students as st, filieres as fil, courses as c , users as us where st.filiere_id = fil.id and c.filiere_id = fil.id and c.id = ".$courseId." and st.id = us.userable_id and us.userable_type=".DB::getPdo()->quote(Student::class)." ) as r2 
        
        on r1.student_id = r2.id";
        $pvListNormaleCourse = DB::select($query);
        
        return view('note.pv-normale-course', compact('pvListNormaleCourse'));
    }
    public function pvSessionRattrapageCourse($idPv)
    {
        $id = $idPv;
        $courseId = Pv::find($id)->course->id;
        $session = 'Rattrapage';
        
        $query = "select r1.year , r1.effectif, r1.capitalisation, r1.session, r1.code, r1.title, r1.cc, r1.tp, r1.ex, r1.total, r1.totalShort, r1.mention,r1.mentionShort,r1.dec, r2.student_id, r2.first_name, r2.last_name
        from (select ay.id as ay_id, ay.year,p.id as p_id ,p.academic_year_id as aca_year, p.effectif,p.capitalisation, p.session, p.course_id , c.code, c.id as c_id ,c.title, c.filiere_id, ce.id as ce_id, ce.course_id as cours_examen_course_id, 
               ce.examen_id as course_examen_examen_id, ex.id as ex_id , ex.academic_Year_id, ex.date, ex.status, ex.examable_id, ex.examable_type, se.id as se_id , se.type, n.id as n_id, n.cc, n.tp , n.ex ,
              n.ex as n_ex, n.total, n.totalShort, n.mention,n.mentionShort,n.dec, n.examen_id, n.student_id
            
        from academic_years as ay , pvs as p , courses as c, course_examen as ce, examens as ex , sessions as se, notes as n
        where ay.id = p.academic_year_id and p.course_id = c.id and c.id = ce.course_id and ce.examen_id = ex.id and ex.examable_id = se.id 
              and n.course_id = c.id and n.examen_id = ex.id and se.type= '".$session."' and p.session = '".$session."' and ex.examable_type = ".DB::getPdo()->quote(Session::class)." and c.id = ".$courseId." ) as r1 right join 
        
        (select st.* , us.id as us_id, us.first_name, us.last_name from students as st, filieres as fil, courses as c , users as us where st.filiere_id = fil.id and c.filiere_id = fil.id and c.id = ".$courseId." and st.id = us.userable_id and us.userable_type=".DB::getPdo()->quote(Student::class)." ) as r2 
        
        on r1.student_id = r2.id";
        $pvListRattrapageCourse = DB::select($query);
        return view('note.pv-rattrapage-course', compact('pvListRattrapageCourse'));
    }

    public function pvSessionRattrapageStudent($id)
    {
        $session = 'Rattrapage';
        $query = "select r1.year , r1.effectif, r1.capitalisation, r1.session, r1.code, r1.title, r1.cc, r1.tp, r1.ex, r1.total, r1.totalShort, r1.mention,r1.mentionShort,r1.dec, r2.student_id, r2.first_name, r2.last_name
        from (select ay.id as ay_id, ay.year,p.id as p_id ,p.academic_year_id as aca_year, p.effectif,p.capitalisation, p.session, p.course_id , c.code, c.id as c_id ,c.title, c.filiere_id, ce.id as ce_id, ce.course_id as cours_examen_course_id, 
               ce.examen_id as course_examen_examen_id, ex.id as ex_id , ex.academic_Year_id, ex.date, ex.status, ex.examable_id, ex.examable_type, se.id as se_id , se.type, n.id as n_id, n.cc, n.tp , n.ex ,
              n.ex as n_ex, n.total, n.totalShort, n.mention,n.mentionShort,n.dec, n.examen_id, n.student_id
            
        from academic_years as ay , pvs as p , courses as c, course_examen as ce, examens as ex , sessions as se, notes as n
        where ay.id = p.academic_year_id and p.course_id = c.id and c.id = ce.course_id and ce.examen_id = ex.id and ex.examable_id = se.id 
              and n.course_id = c.id and n.examen_id = ex.id and se.type= '".$session."' and p.session = '".$session."' and ex.examable_type = ".DB::getPdo()->quote(Session::class)." ) as r1 right join 
        
        (select st.* , us.id as us_id, us.first_name, us.last_name from students as st, filieres as fil, courses as c , users as us where st.filiere_id = fil.id and c.filiere_id = fil.id and st.id = us.userable_id and us.userable_type=".DB::getPdo()->quote(Student::class)." and st.id = ".$id.") as r2 
        
        on r1.student_id = r2.id ";
        // "group by c.code";
        $pvStudent = DB::select($query);

        return view('note.pv-rattrapage-student', compact('pvStudent'));
    }

}
