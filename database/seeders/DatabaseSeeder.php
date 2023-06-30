<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pv;
use App\Models\Note;
use App\Models\User;
use App\Models\Doyen;
use App\Models\Course;
use App\Models\Examen;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Session;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Controle;
use Illuminate\Support\Str;
use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        //
        $defaultAvatar = 'images/default_avatar.png';

        /**
         * ! Seeding Academic Year
         */
        AcademicYear::create([
            'year' => now(),
            'state' => 'Active',
            'created_at' => now(),
        ]);

        /**
         * ! Seeding Facultes.
         * ? Start
         */
        $FS = Faculte::create([
            'title' => 'Faculty Of Sciences',
            'created_at' => now(),
        ]);
        $FL = Faculte::create([
            'title' => 'Faculty Of Letters',
            'created_at' => now(),
        ]);
        /**
         * ! Seeding Facultes.
         * ? End
         */

        /**
         * ! Seeding user DB admin.
         * ? Start
         */
        $roleName = 'Super Admin';
        DB::table('users')->insert([
            'username' => 'Joker',
            'email' => 'admin@mail.com',
            'avatar' => $defaultAvatar,
            'role_name' => $roleName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'created_at' => now(),
        ]);

        /**
         * ! Seeding user DB admin.
         * ? End
         */

        /**
         * ! Seeding Filiere Dependending on Faculty.
         * ? Start
         */
        ///** Faculty Of Sciences
        $facultyOfSciencesFiliere = [
            'inf' => [
                'title' => 'Informatique',
                'codePrefixe' => 'INF ',
                'codeStart' => 200,
                'courses' => [
                    'Programmation C',
                    'Programmation Assembleur'
                ]
            ],
            'mat' => [
                'title' => 'Mathématiques',
                'codePrefixe' => 'MAT ',
                'codeStart' => 300,
                'courses' => [
                    'Algebre I',
                    'Analyse I'
                ]
            ]
        ];
        ///** Faculty Of letters
        $facultyOfLettersFiliere = [
            'geo' => [
                'title' => 'Géographie',
                'codePrefixe' => 'GEO ',
                'codeStart' => 300,
                'courses' => [
                    'Géographie des Sols',
                    'Cartographie I'
                ]
            ],
            'phylo' => [
                'title' => 'Phylosophie',
                'codePrefixe' => 'PHYL ',
                'codeStart' => 400,
                'courses' => [
                    'Introduction A La Phylosophie',
                    'Sciences Sociales I'
                ]
            ]
        ];

        foreach($facultyOfSciencesFiliere as $filiere)
        {
            $currentFiliere = $FS->filieres()->create([
                'title' => $filiere['title'],
                'created_at' => now(),
            ]);

            //Seeding Courses
            foreach($filiere['courses'] as $course)
            {
                $currentFiliere->courses()->create([
                    'title' => $course,
                    'code' => $filiere['codePrefixe'] . $filiere['codeStart']++ ,
                ]);
            }
            //Create Student
            $this->createStudent($currentFiliere);
        }
    
        foreach($facultyOfLettersFiliere as $filiere)
        {
            $currentFiliere = $FL->filieres()->create([
                'title' => $filiere['title'],
                'created_at' => now(),
            ]);

            // Seeding Course Dependending on Faculty
            foreach($filiere['courses'] as $course)
            {
                $currentFiliere->courses()->create([
                    'title' => $course,
                    'code' => $filiere['codePrefixe'] . $filiere['codeStart']++ ,
                ]);
            }
            //Create Student
            $this->createStudent($currentFiliere);
        }

        /**
         * ! Seeding Filiere Dependending on Faculty.
         * ? End
         */

        /**
         * ! Seeding Teachers.
         * ? Start
         */
        for($i = 0 ; $i < 4 ; $i++)
        {
            $roleName = 'Teachers';
            $title = ['Dr.','Pr.'];
            $grade = ['Assistant','Charge de cours','Maitre de Conferences','Professeur'];

            $lastTeacher = Teacher::create([
                'experience' => fake()->numberBetween($min = 0, $max = 10),
                'title' => fake()->randomElements($title)[0],
                'grade' => fake()->randomElements($grade)[0],
                'created_at' => now(),
            ]);
            
            $status = 'Active';
            $user = new User([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'date_of_birth' => date($format = 'Y-m-d', $max = 30),
                'username' => fake()->userName(),
                'gender' => fake()->randomElements(['Male','Female'])[0],
                'address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'city' => fake()->city(),
                'country' => fake()->country(),
                'join_date' => now(),
                'status' => $status,
                'role_name' => $roleName,
                'avatar' => $defaultAvatar,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'created_at' => now(),

            ]);
            $lastTeacher->user()->save($user);

        }
        /**
         * ! Seeding Teachers.
         * ? End
         */

        /**
         * ! seeding Doyen with the Last Teacher
         * ? Start
         */

         $doyen = Doyen::create([
            'created_at' => now(),
         ]);

         $lastTeacher = Teacher::orderBy("id", "DESC")->first();
         $lastTeacher->teacherable()->associate($doyen)->save();
        //  $lastTeacher->teacherable()->dissociate($doyen)->save();  // ? For dissociate Model from given parent

        /**
         * ! seeding Doyen with the Last Teacher
         * ? End
         */

        /**
         * ! Seeding Exams for each Course
         * ? Start
         * % Every Course has one Controle , sessionNormale and Rattrapage
         */
        
        $academicYear = AcademicYear::find(1);
        
        // Create Examens
        $date = [
            '2021-05-11',
            '2022-06-03',
            '2023-04-12',
            '2023-01-23',
        ];
        
        $facultyTitle = [
            'Faculty Of Sciences',
            'Faculty Of Letters',
        ];

        for($i = 0 ; $i < 2 ; $i++){
            /* $courseFac = Course::join('filieres','filiere_id','=','id')
            ->join('facultes','faculte_id','=', 'id')
            ->where('facultes.title',$facultyTitle[$i])
            ->select('courses.*')->get(); */    
            $idFacType = Faculte::where('title',$facultyTitle[$i])->first()->id;
            $coursesFacType = Course::join('filieres','courses.filiere_id','=','filieres.id')
            ->where('filieres.faculte_id',$idFacType)
            ->select('courses.*')
            ->get();

            /**
             * ? Controle Continu
             */
            $examen = new Examen([
                'date' => fake()->date($format = 'Y-m-d', $max = 'now'),
                'status' => 'Pending',
                'created_at' => now(),
            ]);
            $academicYear->examens()->save($examen);
            $controle = Controle::create([
                'created_at' => now(),
            ]);
            $examen->examable()->associate($controle)->save();
            /**
             * ! Link Polymorphyc Type Of Exam to Course
            */
            foreach($coursesFacType as $course){
                $examen->courses()->attach($course->id);
                /**
                 * % Set CC Notes For Students of That Course
                 */
                $studentCourseType = Student::join('filieres','students.filiere_id','=', 'filieres.id')
                ->join('courses','courses.filiere_id','=', 'filieres.id')
                ->where('courses.id',$course->id)
                ->select('students.*')->get();
                foreach($studentCourseType as $student){
                        $note = fake()->numberBetween($min = 5, $max = 20);
                        $noteTp = fake()->numberBetween($min = 5, $max = 20);
                        $note = Note::create([
                            'cc' => $note,
                            'tp'    => $noteTp,
                            'examen_id' => $examen->id,
                            'student_id' => $student->id,
                            'course_id'  => $course->id,
                            'updated_at' => now(),
                        ]);
                }
            }

            /**
             * ? Session Normale
             */
            $examen = new Examen([
                'date' => fake()->date($format = 'Y-m-d', $max = 'now'),
                'status' => 'Pending',
                'created_at' => now(),
            ]);
            $academicYear->examens()->save($examen);
            $sessionNormale = Session::create([
                'type'       => 'Normale',
                'created_at' => now(),
            ]);
            $examen->examable()->associate($sessionNormale)->save();
            /**
             * ! Link Polymorphyc Type Of Exam to Course
            */
            foreach($coursesFacType as $course){
                $examen->courses()->attach($course->id);
                /**
                 * % Set Normale Notes For Students of That Course
                 */
                $studentCourseType = Student::join('filieres','students.filiere_id','=', 'filieres.id')
                ->join('courses','courses.filiere_id','=', 'filieres.id')
                ->where('courses.id',$course->id)
                ->select('students.*')->get();
                foreach($studentCourseType as $student){
                    $note = fake()->numberBetween($min = 5, $max = 20);
                    $cc = $this->getNoteControle($course,$student,null);
                    $tp = $this->getNoteControle($course,$student,'tp');
                    $total = $this->getTotal($cc, $tp, $note);
                    $mentions = $this->getMention($total);
                    $note = Note::create([
                        'cc' => $cc,
                        'tp' => $tp,
                        'ex' => $note,
                        'total' => $total,
                        'totalShort' => $mentions['totalShort'],
                        'mention' => $mentions['mention'],
                        'mentionShort' => $mentions['mentionShort'],
                        'dec' => $mentions['dec'],                        
                        'examen_id' => $examen->id,
                        'student_id' => $student->id,
                        'course_id'  => $course->id,
                        'updated_at' => now(),
                    ]);
                }

            }

            /**
             * ? Session Rattrapage
             */
            $examen = new Examen([
                'date' => fake()->date($format = 'Y-m-d', $max = 'now'),
                'status' => 'Pending',
                'created_at' => now(),
            ]);
            $academicYear->examens()->save($examen);
            $sessionRattrapage = Session::create([
                'type'       => 'Rattrapage',
                'created_at' => now(),
            ]);
            $examen->examable()->associate($sessionRattrapage)->save();
            /**
             * ! Link Polymorphyc Type Of Exam to Course
            */
            foreach($coursesFacType as $course){
                $examen->courses()->attach($course->id);
                /**
                 * % Set Rattrapages Notes For Students of That Course
                 */
                $studentCourseType = Student::join('filieres','students.filiere_id','=', 'filieres.id')
                ->join('courses','courses.filiere_id','=', 'filieres.id')
                ->where('courses.id',$course->id)
                ->select('students.*')->get();
                foreach($studentCourseType as $student){
                    /** 
                     * % Check if The Student have validate At Normal Session
                     */
                    {
                        // if($this->IsRattrapable($course, $student))
                        // {
                            $note = fake()->numberBetween($min = 5, $max = 20);
                            $cc = $this->getNoteControle($course,$student,null);
                            $tp = $this->getNoteControle($course,$student,'tp');
                            $total = $this->getTotal($cc, $tp, $note);
                            $mentions = $this->getMention($total);
                            $note = Note::create([
                                'cc' => $cc,
                                'tp' => $tp,
                                'ex' => $note,
                                'total' => $total,
                                'totalShort' => $mentions['totalShort'],
                                'mention' => $mentions['mention'],
                                'mentionShort' => $mentions['mentionShort'],
                                'dec' => $mentions['dec'],                        
                                'examen_id' => $examen->id,
                                'student_id' => $student->id,
                                'course_id'  => $course->id,
                                'updated_at' => now(),
                            ]);
                        // }
                    }
                }
            }    
        }
        /**
         * ! Seeding Exams for each Course
         * ? End
         */
        
        /**
         * ! Seding PV Normale
         * ? Start
         * % We Suppose that all Courses have an CC, SN , RATTR
         * % So we can create PV records for each Course
         */
        $courses = Course::all();
        $session = 'Normale';

        foreach($courses as $course)
        {
            Pv::create([
                'effectif' => count($course->filiere->students),
                'capitalisation' => $this->capitalisation($course , $session),
                'session'    => $session,
                'course_id' => $course->id,
                'academic_year_id' => $academicYear->id,
                'created_at' => now(),
            ]);
        }
        /**
         * ! Seding PV Normale
         * ? End
         */
        /**
         * ! Seding PV Rattrapage
         * ? Start
         * % We Suppose that all Courses have an CC, SN , RATTR
         * % So we can create PV records for each Course
         */
        $courses = Course::all();
        $session = 'Rattrapage';

        foreach($courses as $course)
        {
            Pv::create([
                'effectif' => count($course->filiere->students),
                'capitalisation' => $this->capitalisation($course , $session),
                'session'    => $session,
                'course_id' => $course->id,
                'academic_year_id' => $academicYear->id,
                'created_at' => now(),
            ]);
        }
        /**
         * ! Seding PV Rattrapage
         * ? End
         */
        
    }

    public function createStudent($filiere)
    {
        /**
         * Seeding Students.
         *
         */
        $defaultAvatar = 'images/default_avatar.png';
        for($i = 0 ; $i < 10 ; $i++)
        {
            $roleName = 'Student';
            $religion = ['Christian','Musulman','Others'];
            $student = new Student([
                'religion' => fake()->randomElements($religion)[0],
                'student_id' => fake()->regexify('23[A-Z][0-9]{4}'), //Matricule
                'created_at' => now(),
            ]);
            $filiere->students()->save($student);
            
            $lastStudent = Student::orderBy("id", "DESC")->first();
            $user = new User([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'date_of_birth' => date($format = 'Y-m-d', $max = 30),
                'username' => fake()->userName(),
                'gender' => fake()->randomElements(['Male','Female'])[0],
                'address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'city' => fake()->city(),
                'country' => fake()->country(),
                'join_date' => now(),
                'status' => 'Active',
                'role_name' => $roleName,
                'avatar' => $defaultAvatar,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'created_at' => now(),
            ]);
            $lastStudent->user()->save($user);

        }
    }

    public function capitalisation($course , $session){
        $sum = 0;
        foreach($course->filiere->students as $student)
        {
            if($this->moyenneCourse($course, $student, $session) >= 10)
                $sum++;
        }
        return ($sum / count($course->filiere->students)*100);
    }

    public function moyenneCourse($course, $student, $session)
    {
        $noteControle = $this->getNoteControle($course, $student, null);
        $noteTp = $this->getNoteControle($course, $student, 'tp');
        $noteSession = $this->getNoteSession($course, $student, $session);

        return (20 * $noteControle + $noteTp * 10 + 70 * $noteSession) / 100 ;
    }

    public function getNoteControle($course, $student , $type)
    {
        if(! $type)
        {
            $note = Student::join('notes','notes.student_id','=','students.id')
            ->where('students.id',$student->id)
            ->join('examens','examens.id','=','notes.examen_id')
            ->where('examable_type',Controle::class)
            ->join('courses','courses.id','=','notes.course_id')
            ->where('courses.id',$course->id)
            ->select('notes.cc')
            ->first()->cc;
        }
        else{
            $note = Student::join('notes','notes.student_id','=','students.id')
            ->where('students.id',$student->id)
            ->join('examens','examens.id','=','notes.examen_id')
            ->where('examable_type',Controle::class)
            ->join('courses','courses.id','=','notes.course_id')
            ->where('courses.id',$course->id)
            ->select('notes.tp')
            ->first()->tp;
        }
        return $note;
    }

    public function getNoteSession($course, $student, $type)
    {
        /**
         * ! if there is no Rattrapage Value, we take the Normale Note Session
         */
        if($type == 'Rattrapage')
        {
            $note = Student::join('notes','notes.student_id','=','students.id')
            ->where('students.id',$student->id)
            ->join('examens','examens.id','=','notes.examen_id')
            ->where('examable_type',Session::class)
            ->join('courses','courses.id','=','notes.course_id')
            ->where('courses.id',$course->id)
            ->join('sessions','sessions.id','=','examens.examable_id')
            ->where('sessions.type',$type)
            ->select('notes.ex')
            ->first();
            if($note)
                return $note->ex;
        }

        $note = Student::join('notes','notes.student_id','=','students.id')
            ->where('students.id',$student->id)
            ->join('examens','examens.id','=','notes.examen_id')
            ->where('examable_type',Session::class)
            ->join('courses','courses.id','=','notes.course_id')
            ->where('courses.id',$course->id)
            ->join('sessions','sessions.id','=','examens.examable_id')
            ->where('sessions.type','Normale')
            ->select('notes.ex')
            ->first()->ex;
        return $note;

    }

    public function IsRattrapable($course, $student)
    {
        return $this->getNoteSession($course, $student, 'Normale') < 10 ;
    }

    public function haveDoneRattrapage($course, $student){

    }

    public function getTotal($cc, $tp, $ex)
    {
        return  (($cc * 2 + $tp) / 2) + (($ex * 70) / 20);
    }

    public function getMention($total)
    {
        
        switch ($total) {
            case $total >= 0 && $total < 30:
                $res = [
                    'mentionShort' => 'F',
                    'mention' => 'Echec',
                    'totalShort'   => 0.00,
                    'dec'   => 'Echec',
                ];
                break;
            case $total >= 30 && $total < 35:
                $res = [
                    'mentionShort' => 'E',
                    'mention' => 'Echec',
                    'totalShort'   => 0.00,
                    'dec'   => 'Echec',
                ];
                break;
            case $total >= 35 && $total < 40:
                $res = [
                    'mentionShort' => 'D',
                    'mention' => 'Echec',
                    'totalShort'   => 1.00,
                    'dec'   => 'CANT',
                ];
                break;
            case $total >= 40 && $total < 45:
                $res = [
                    'mentionShort' => 'D+',
                    'mention' => 'Echec',
                    'totalShort'   => 1.30,
                    'dec'   => 'CANT',
                ];
                break;
            case $total >= 45 && $total < 50:
                $res = [
                    'mentionShort' => 'C-',
                    'mention' => 'Echec',
                    'totalShort'   => 1.70,
                    'dec'   => 'CANT',
                ];
                break;
            case $total >= 50 && $total < 55:
                $res = [
                    'mentionShort' => 'C',
                    'mention' => 'Passable',
                    'totalShort'   => 2.00,
                    'dec'   => 'CA',
                ];
                break;
            case $total >= 55 && $total < 60:
                $res = [
                    'mentionShort' => 'C+',
                    'mention' => 'Passable',
                    'totalShort'   => 2.30,
                    'dec'   => 'CA',
                ];
                break;
            case $total >= 60 && $total < 65:
                $res = [
                    'mentionShort' => 'B-',
                    'mention' => 'Assez bien',
                    'totalShort'   => 2.70,
                    'dec'   => 'CA',
                ];
                break;
            case $total >= 65 && $total < 70:
                $res = [
                    'mentionShort' => 'B',
                    'mention' => 'Assez bien',
                    'totalShort'   => 3.00,
                    'dec'   => 'CA',
                ];
                break;
            case $total >= 70 && $total < 75:
                $res = [
                    'mentionShort' => 'B+',
                    'mention' => 'Bien',
                    'totalShort'   => 3.30,
                    'dec'   => 'CA',
                ];
                break;
            case $total >= 75 && $total < 80:
                $res = [
                    'mentionShort' => 'A-',
                    'mention' => 'Bien',
                    'totalShort'   => 3.70,
                    'dec'   => 'CA',
                ];
                break;
            case $total >= 80 && $total <= 100:
                $res = [
                    'mentionShort' => 'A',
                    'mention' => 'Tres Bien',
                    'totalShort'   => 4.00,
                    'dec'   => 'CA',
                ];
                break;
            
            default:
                $res = [
                    'mentionShort' => '--',
                    'mention' => '--',
                    'totalShort'   => 0,
                    'dec'   => '--',
                ];
                break;
        }

        return $res;
    }
}
