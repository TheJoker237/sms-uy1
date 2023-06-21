<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'migrate_in_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute the migrations in the order specified in the file app/Console/Comands/MigrateInOrder.php \n Drop all the table in db before execute the command.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** Specify the names of the migrations files in the order you want to 
        * loaded
        * $migrations =[ 
        *               'xxxx_xx_xx_000000_create_nameTable_table.php',
        *    ];
        */
        // $migrations = [ 
        //    
        // ];

        $migrations = [
            '2014_08_12_000000_create_users_table.php',
            '2022_08_03_061844_create_user_types_table.php',
            '2022_08_03_061918_create_role_type_users_table.php',
            '2023_04_17_223959_create_teachers_table.php',
            '2023_06_04_230017_create_academic_years_table.php',
            '2023_06_13_080432_create_facultes_table.php',
            '2023_06_05_093648_create_filieres_table.php',
            '2023_06_05_090235_create_courses_table.php',
            '2023_02_26_224452_create_students_table.php',
            '2023_06_18_085411_create_course_teacher.php',
            '2023_06_15_124900_create_examens_table.php',
            '2023_06_15_172714_create_course_examen.php',
            '2023_06_15_171448_create_examen_filiere.php',
            '2023_06_15_172201_create_examen_faculte.php',
            '2023_06_15_124910_create_notes_table.php',
            '2023_06_15_124919_create_requetes_table.php',
            '2023_06_15_125015_create_juries_table.php',
            '2023_06_21_084015_create_doyens_table.php',
        ];
        // Wipe all database before execute all migrations
        $this->call('db:wipe');
        foreach($migrations as $migration)
        {
            $basePath = 'database/migrations/';          
            $migrationName = trim($migration);
            $path = $basePath.$migrationName;
            $this->call('migrate', [
            '--path' => $path ,            
            ]);
        }

        //Seeding Database 
        // $this->call('migrate:fresh --seed --seeder=FaculteSeeder');

        $this->call('db:seed');
        return Command::SUCCESS;
    }
}
