<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Course;
use App\Models\Faculte;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;
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
         * Seeding Facultes.
         *
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
         * Seeding user DB admin.
         *
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
         * Seeding Filiere Dependending on Faculty.
         *
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
         * Seeding Teachers.
         *
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
}
