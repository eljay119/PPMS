<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\BacSecController;
use App\Http\Controllers\BudgetOfficerController;
use App\Http\Controllers\CampusDirectorController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\OfficeTypeController;
use App\Http\Controllers\Admin\SourceOfFundController;
use App\Http\Controllers\Admin\PpmpStatusController;
use App\Http\Controllers\Admin\PpmpProjectStatusController;
use App\Http\Controllers\Admin\ProjectTypeController;
use App\Http\Controllers\Admin\PpmpProjectCategoryController;
use App\Http\Controllers\Admin\AppStatusController;
use App\Http\Controllers\Admin\ModeOfProcurementController;

use App\Http\Controllers\Head\PPMPController;
use App\Http\Controllers\Head\PpmpProjectController;
use App\Http\Controllers\Head\AppProjectController;

use App\Http\Controllers\BacSec\AppController;
use App\Http\Controllers\BacSec\AppProject2Controller;
use App\Http\Controllers\BacSec\AppProjectStatusController;

use App\Http\Controllers\BudgetOfficer\AppProject3Controller;

use App\Http\Controllers\CampusDirector\AppProject4Controller;

use App\Http\Middleware\CheckRole;


// Public Route
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
});

// Logout Route (Now Protected by `auth` Middleware)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard Routes for Different Roles
Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth', CheckRole::class . ':Admin'])->get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware(['auth', CheckRole::class . ':Head'])->get('/head', [HeadController::class, 'dashboard'])->name('head.dashboard');
    Route::middleware(['auth', CheckRole::class . ':Bac Sec'])->get('/bacsec', [BacSecController::class, 'dashboard'])->name('bacsec.dashboard');
    Route::middleware(['auth', CheckRole::class . ':Budget Officer'])->get('/budget_officer', [BudgetOfficerController::class, 'dashboard'])->name('budget_officer.dashboard');
    Route::middleware(['auth', CheckRole::class . ':Campus Director'])->get('/campus_director', [CampusDirectorController::class, 'dashboard'])->name('campus_director.dashboard');

});


// General User Dashboard Redirect
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect('/login'); // Ensure user is logged in
    }

    $userrole = Auth::user()?->role?->name ?? 'Guest';

    $redirectRoutes = [
        'Admin' => '/admin',
        'Head' => '/head',
        'Bac Sec' => '/bacsec',
        'Budget Officer' => '/budget_officer',
        'Campus Director' => '/campus_director',
    ];

    // Ensure Auth::user()->role exists before redirecting
    $role = Auth::user()->role ?? 'guest'; 
        return redirect($redirectRoutes[$userrole] ?? '/login'); 
    })->middleware(['auth', 'verified'])->name('dashboard');

// Admin Management Routes
Route::prefix('admin')->middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::resource('roles', RoleController::class)->names('admin.roles');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('offices', OfficeController::class)->names('admin.offices');
    Route::resource('ppmp_status', PpmpStatusController::class)->names('admin.ppmp_status');
    Route::resource('ppmp_project_statuses', PpmpProjectStatusController::class)->names('admin.ppmp_project_statuses');
    Route::resource('officeTypes', OfficeTypeController::class);
    Route::resource('source_of_funds', SourceOfFundController::class);
    Route::resource('apps', AppController::class);
    Route::resource('app_statuses', AppStatusController::class);
    Route::resource('mode_of_procurements', ModeOfProcurementController::class);

});

// Head Management Routes
Route::prefix('head')->name('head.')->middleware(['auth'])->group(function () {
    // PPMP Routes
    Route::resource('ppmps', PPMPController::class);
     // Handles index, show, store, update, destroy, etc.
    Route::put('/ppmps/{ppmp}/finalize', [PPMPController::class, 'finalize'])->name('ppmps.finalize');

    // Assigned APP Projects
    Route::get('/app-projects', [AppProjectController::class, 'index'])->name('app_projects.index');

    // PPMP Projects Routes
    // Show all projects under a specific PPMP
    Route::get('/ppmps/{ppmp}/projects', [PpmpProjectController::class, 'index'])->name('ppmp_projects.index');

    // Resource routes for storing/updating/deleting projects 
    Route::post('/ppmp_projects', [PpmpProjectController::class, 'store'])->name('ppmp_projects.store');
    Route::put('/ppmp_projects/{id}', [PpmpProjectController::class, 'update'])->name('ppmp_projects.update');
    Route::delete('/ppmp_projects/{id}', [PpmpProjectController::class, 'destroy'])->name('ppmp_projects.destroy');
});

    
// Bac Sec Management Routes
Route::prefix('bacsec')->name('bacsec.')->group(function () {
    Route::get('app', [AppController::class, 'index'])->name('app.index');

    // App Projects
    Route::get('app_projects', [AppProject2Controller::class, 'index'])->name('app_projects.index');

    // App Project Statuses
    Route::resource('app_project_statuses', AppProjectStatusController::class)->except(['show']);
    Route::get('app_project_statuses/{id}', [AppProjectStatusController::class, 'show'])
        ->name('app_project_statuses.show');
});


// Budget Officer Management Routes
Route::prefix('budget_officer')->name('budget_officer.')->group(function () {
    Route::get('submitted_projects', [AppProject3Controller::class, 'index'])->name('submitted_projects.index');
    Route::get('certified_projects', [AppProject3Controller::class, 'index'])->name('certified_projects.index');

});


// Campus Director Management Routes
Route::prefix('campus_director')->name('campus_director.')->group(function () {
    Route::get('certified_project', [AppProject4Controller::class, 'index'])->name('certified_project.index');
    Route::get('endorsed_projects', [AppProject4Controller::class, 'index'])->name('endorsed_projects.index');

});


// Profile Management Routes
Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
});



require __DIR__.'/auth.php';
