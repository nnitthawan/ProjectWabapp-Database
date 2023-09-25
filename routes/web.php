<?php

use App\Http\Controllers\{
    HomeController,
    ProfileController,
    postcRUDController,
    enrollController,adminController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('jobinfo', postcRUDController::class);
    //Test route check how create job
    Route::get('createjob', [postcRUDController::class, 'create'])->name('create'); //fetch and input worktype
    Route::post('createjob2', [postcRUDController::class, 'create2'])->name('create2'); // fetch and create question
    Route::post('store', [postcRUDController::class, 'store'])->name('store'); // insert on to DB

    Route::get('enroll', [enrollController::class, 'enroll']);
    Route::post('ansQuestion',[enrollController::class, 'ansQuestion'])->name('ansQuestion'); //this route is for answer question and store data like email tel. resume
    Route::post('summarizeData',[enrollController::class, 'sumarizeData'])->name('summarize');
    Route::post('submit-response', [enrollController::class, 'submitResponse'])->name('submit_summary');//this route is for answer question and store data like email tel. resume

});
Route::middleware(['auth', 'user-access:poser'])->group(function () {
    Route::get('/poser', [HomeController::class, 'poserHome'])->name('poser.home');
});
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'adminHome'])->name('admin.home');
    Route::get('admin/{text}', [HomeController::class, 'admint'])->name('admin.user');

// Go to tag page
Route::get('/admin/category/edit/{id}',[HomeController::class, 'editTag'])->name('admin.editTag');

// Edit Tag Form
Route::get('/admin/category/editTag/{idTag}', [HomeController::class, 'editTagForm'])->name('admin.category.editTagForm');
Route::post('/admin/category/updateTag/{idTag}', [HomeController::class, 'updateTag'])->name('admin.category.updateTag');

// Delete Tag
Route::delete('/admin/category/deleteTag/{idTag}', [HomeController::class, 'deleteTag'])->name('admin.category.deleteTag');

// Add Tag Form
Route::get('/admin/category/addTag', [HomeController::class, 'addTagForm'])->name('admin.category.addTagForm');
Route::post('/admin/category/storeTag', [HomeController::class, 'storeTag'])->name('admin.category.storeTag');

});

require __DIR__.'/auth.php';
