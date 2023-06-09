<?php

use App\Http\Controllers\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\RequeteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TypeFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active( $route ) {
    if( is_array( $route ) ){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('home');
    });
    Route::get('home',function()
    {
        return view('home');
    });
});

Auth::routes();

// ----------------------------login ------------------------------//
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('change/password', 'changePassword')->name('change/password');
});

// ----------------------------- register -------------------------//
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register','storeUser')->name('register');    
});

// -------------------------- main dashboard ----------------------//
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->middleware('auth')->name('home');
    Route::get('user/profile/page', 'userProfile')->middleware('auth')->name('user/profile/page');
    Route::get('teacher/dashboard', 'teacherDashboardIndex')->middleware('auth')->name('teacher/dashboard');
    Route::get('student/dashboard', 'studentDashboardIndex')->middleware('auth')->name('student/dashboard');
});

// ----------------------------- user controller -------------------------//
Route::controller(UserManagementController::class)->group(function () {
    Route::get('list/users', 'index')->middleware('auth')->name('list/users');
    Route::post('change/password', 'changePassword')->name('change/password');
    Route::get('user/edit/{id}', 'userView')->middleware('auth');
    Route::post('user/update', 'userUpdate')->name('user/update');
    Route::post('user/delete', 'userDelete')->name('user/delete');
});

/**
 *  ? Setting Routes 
 */
Route::controller(Setting::class)->group(function () {
    Route::get('setting/page', 'index')->middleware('auth')->name('setting/page');
    Route::get('setting/page/academicYear', 'academicYear')->middleware('auth')->name('setting/page/academicYear');
    Route::post('setting/page/academicYear/save', 'academicYearSave')->name('setting/page/academicYear/save'); // save record academic year
    Route::post('setting/page/academicYear/edit', 'academicYearEdit')->name('setting/page/academicYear/edit'); // edit view academic year
    // Route::post('setting/page/academicYear/update', 'academicYearUpdate')->name('setting/page/academicYear/update'); // update record academic year
    Route::post('setting/page/academicYear/delete', 'academicYearDelete')->name('setting/page/academicYear/delete'); // delete record academic year
    /** Doyen **/
    Route::get('setting/doyen', 'doyen')->middleware('auth')->name('setting/doyen');
    Route::post('setting/doyen/set', 'doyenSet')->name('setting/doyen/set');
    Route::post('setting/doyen/unset', 'doyenUnset')->name('setting/doyen/unset');
    Route::post('setting/doyen/change', 'doyenChange')->name('setting/doyen/change');
});
// ------------------------ Course -------------------------------//
Route::controller(CourseController::class)->group(function () {
    Route::get('course/list', 'course')->middleware('auth')->name('course/list');
    Route::post('course/save', 'courseSave')->name('course/save'); // save record course
    Route::post('course/edit', 'courseEdit')->name('course/edit'); // edit view course
    // Route::post('course/update', 'courseUpdate')->name('course/update'); // update record course
    Route::post('course/delete', 'courseDelete')->name('course/delete'); // delete record course
});

// ------------------------ Filiere -------------------------------//
Route::controller(FiliereController::class)->group(function () {
    Route::get('filiere/list', 'filiere')->middleware('auth')->name('filiere/list');
    Route::post('filiere/save', 'filiereSave')->name('filiere/save'); // save record filiere
    Route::post('filiere/edit', 'filiereEdit')->name('filiere/edit'); // edit view filiere
    Route::post('filiere/delete', 'filiereDelete')->name('filiere/delete'); // delete record filiere
    // Route::get('filiere/edit/{id}', 'filiereEdit')->name('filiere/edit'); // edit view filiere
    // Route::post('filiere/update', 'filiereUpdate')->name('filiere/update'); // update record filiere
});

// ------------------------ Examen -------------------------------//
Route::controller(ExamenController::class)->group(function () {
    Route::get('examen/list', 'examen')->middleware('auth')->name('examen/list');
    Route::get('examen/add/{id?}', 'examenAdd')->middleware('auth')->name('examen/add');
    Route::post('examen/save', 'examenSave')->name('examen/save'); // save record examen
    Route::get('examen/edit/{id}', 'examenEdit')->name('examen/edit'); // edit view examen
    Route::post('examen/update', 'examenUpdate')->name('examen/update'); // update record examen
    // Route::post('examen/edit', 'filiereEdit')->name('filiere/edit'); // edit view examen
    
    /**
     * ? Exam Delete
     */
    Route::post('examen/delete', 'examenDelete')->name('examen/delete'); // delete record examen
    /**
     * ? Exam Delete Courses
     */
    Route::post('examen/delete-course', 'examenDeleteCourse')->name('examen/delete-course'); // delete record examen

    /**
     * ? Examen Filiere Show Controle
     */
    Route::get('examen/controle', 'examenControle')->name('examen/controle');
    /**
     * ? Examen Filiere Show Session
     */
    Route::get('examen/session', 'examenSession')->name('examen/session');
    /**
     * ? Examen Filiere Show Controle List
     */
    Route::get('examen/controle-list', 'examenControleList')->name('examen/controle-list');
    /**
     * ? Examen Filiere Show Session List
     */
    Route::get('examen/session-list', 'examenSessionList')->name('examen/session-list');

    /**
     * ? Show Controle Group By Faculty
     * % Controle
     */
    Route::get('examen/controle/faculty','controleGroupByFaculty')->name('examen/controle/faculty');
    /**
     * ? Show Controle Group By Filiere
     * % Controle
     */
    Route::get('examen/controle/faculty/show/{idFaculty}','controleGroupByFiliere')->name('examen/controle/faculty/show/{idFaculty}');
    /**
     * ? Show Controle Concerning a Filiere
     * % Controle
     */
    Route::get('examen/controle/filiere/show/{idFaculty}/{idFiliere}','controleShowForFiliere')->name('examen/controle/filiere/show');
    /**
     * ? Show Session Group By Faculty
     * ! Session
     */
    Route::get('examen/session/faculty','sessionGroupByFaculty')->name('examen/session/faculty');
    /**
     * ? Show Session Group By Filiere
     * ! Session
     */
    Route::get('examen/session/faculty/show/{idFaculty}','sessionGroupByFiliere')->name('examen/session/faculty/show');
    /**
     * ? Show Session Concerning a Filiere
     * ! Session
     */
    Route::get('examen/session/filiere/show/{idFaculty}/{idFiliere}','sessionShowForFiliere')->name('examen/session/filiere/show');

    /**
     * ? Manage Exam Add Form
     */
    Route::post('examen/manage-filiere','examenManageFiliere')->name('examen/manage-filiere');
    Route::post('examen/manage-course','examenManageCourse')->name('examen/manage-course');
});

// ------------------------ Note -------------------------------//
Route::controller(NoteController::class)->group(function () {
    Route::get('note/list', 'note')->middleware('auth')->name('note/list');
    Route::get('note/add', 'noteAdd')->middleware('auth')->name('note/add');
    Route::post('note/save', 'noteSave')->name('note/save'); // save record note
    Route::get('note/edit/{id}', 'noteEdit')->name('note/edit'); // edit view note
    Route::post('note/update', 'noteUpdate')->name('note/update'); // update record note
    Route::post('note/delete', 'noteDelete')->name('note/delete'); // delete record note
    // Route::post('note/edit', 'filiereEdit')->name('filiere/edit'); // edit view note

    /**
     * ? Note Show Controle
     */
    Route::get('note/controle', 'noteControle')->name('note/controle');
    /**
     * ? Note Show Session
     */
    Route::get('note/session', 'noteSession')->name('note/session');
});
// ------------------------ PV -------------------------------//
Route::controller(NoteController::class)->group(function () {
    Route::get('pv/list', 'pvList')->middleware('auth')->name('pv/list');

    /**
     * ? PV Show Faculty
     */
    Route::get('pv/faculty', 'pvFaculty')->name('pv/faculty');
    /**
     * ? PV Show Session Normale
     */
    Route::get('pv/session/normale', 'pvSessionNormale')->name('pv/session/normale');
    /**
     * ? PV Show Session Rattrapage
     */
    Route::get('pv/session/rattrapage', 'pvSessionRattrapage')->name('pv/session/rattrapage');
    /**
     * ? PV Show Session Normale List
     */
    Route::get('pv/session/normale/list/{idPv}', 'pvSessionNormaleCourse')->name('pv/session/normale/list');
    /**
     * ? PV Show Session Rattrapage List
     */
    Route::get('pv/session/rattrapage/list/{idPv}', 'pvSessionRattrapageCourse')->name('pv/session/rattrapage/list');
    /**
     * % PV Student Show 
     */
    Route::get('pv/session/rattrapage/student/{idPv}', 'pvSessionRattrapageStudent')->name('pv/session/rattrapage/student');
});



// ------------------------ Requete -------------------------------//
Route::controller(RequeteController::class)->group(function () {
    Route::get('requete/list', 'requete')->middleware('auth')->name('requete/list');
    Route::get('requete/add', 'requeteAdd')->middleware('auth')->name('requete/add');
    Route::post('requete/save', 'requeteSave')->name('requete/save'); // save record requete
    Route::get('requete/edit/{id}', 'requeteEdit')->name('requete/edit'); // edit view requete
    Route::post('requete/update', 'requeteUpdate')->name('requete/update'); // update record requete
    Route::post('requete/delete', 'requeteDelete')->name('requete/delete'); // delete record requete
    // Route::post('note/edit', 'filiereEdit')->name('filiere/edit'); // edit view requete
});

// ------------------------ student -------------------------------//
Route::controller(StudentController::class)->group(function () {
    Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
    Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
    Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
    Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
    Route::get('student/edit/{id}', 'studentEdit'); // view for edit
    Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
    Route::post('student/delete', 'studentDelete')->name('student/delete'); // delete record student
    Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
});

// ------------------------ teacher -------------------------------//
Route::controller(TeacherController::class)->group(function () {
    Route::get('teacher/add', 'teacherAdd')->middleware('auth')->name('teacher/add'); // page teacher
    Route::get('teacher/list', 'teacherList')->middleware('auth')->name('teacher/list'); // page teacher
    Route::get('teacher/grid', 'teacherGrid')->middleware('auth')->name('teacher/grid'); // page grid teacher
    Route::post('teacher/save', 'saveRecord')->middleware('auth')->name('teacher/save'); // save record
    Route::get('teacher/edit/{id}', 'editRecord'); // view teacher record
    Route::post('teacher/update', 'updateRecordTeacher')->middleware('auth')->name('teacher/update'); // update record
    Route::post('teacher/delete', 'teacherDelete')->name('teacher/delete'); // delete record teacher
});

// ----------------------- department -----------------------------//
Route::controller(DepartmentController::class)->group(function () {
    Route::get('department/add/page', 'indexDepartment')->middleware('auth')->name('department/add/page'); // page add department
    Route::get('department/edit/page', 'editDepartment')->middleware('auth')->name('department/edit/page'); // page add department
});

/**
 * ! Test Queries View
 */
Route::controller(Setting::class)->group(function(){
    Route::get('/test', 'testQueries');
});