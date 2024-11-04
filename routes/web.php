<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{HomeController,SectionController,ShelfController};
use App\Http\Controllers\Admin\{BookController,CopyController};
use App\Http\Controllers\Admin\{RoleController,UserController};


Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::middleware(['auth','role:librarian'])->prefix('admin/dashboard')->name('admin.')->group(function () {
  Route::get('/requested-books', [HomeController::class, 'requested_books'])->name("requested_books");
  Route::post('/approve-request/{id}', [HomeController::class, 'approveRequest'])->name("approve");
  Route::post('/reject-request/{id}', [HomeController::class, 'rejectRequest'])->name("reject");
  Route::post('/borrow-request/{id}', [HomeController::class, 'borrowRequest'])->name("borrow_request");
  Route::post('/return-request/{id}', [HomeController::class, 'returnRequest'])->name("return_request");

  Route::get('/approved-books', [HomeController::class, 'approved_books'])->name("approved_books");

  Route::get('/borrowed-books', [HomeController::class, 'borrowed_books'])->name("borrowed_books");


});
Route::middleware(['auth','role:librarian,admin'])->prefix('admin/dashboard')->name('admin.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name("dashboard");

    Route::resource('sections', SectionController::class)->only([
         'index','store', 'destroy','show'
    ]);
    Route::resource('shelves', ShelfController::class)->only([
         'index','store', 'destroy','show'
    ]);
    Route::resource('books', BookController::class)->only([
         'index','store', 'destroy'
    ]);
    Route::resource('readers', UserController::class)->only([
         'index','store', 'destroy'
    ]);
});
Route::middleware(['auth','role:admin'])->prefix('admin/dashboard')->name('admin.')->group(function () {
  Route::resource('librarians', UserController::class)->only([
       'index','store', 'destroy'
  ]);
  Route::resource('users', UserController::class)->only([
       'index','store', 'destroy'
  ]);
  Route::resource('roles', RoleController::class)->only([
       'index','store', 'destroy'
  ]);

});

Route::any('/register',function () {
  abort(404);
});
Route::middleware(['auth','can:access-profile'])->group(function () {
  Route::get('/user/profile',[ProfileController::class,'show'])->name('profile.show');
});




  Route::middleware(['auth','role:reader'])->group(function () {
  Route::post('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search')->middleware(['auth','role:reader,admin,librarian']);

  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  Route::get('request-book/{id}',[App\Http\Controllers\HomeController::class, 'makeRequest'])->name('request-book');
  Route::get('/user-books/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('user-books.show');
  Route::get('/requests', [App\Http\Controllers\HomeController::class, 'requestedBook'])->name('requests');
  Route::get('/borrowed-books', [App\Http\Controllers\HomeController::class, 'borrowed_book'])->name("borrowed_book");
  Route::get('/shelf-show/{id}', [App\Http\Controllers\HomeController::class, 'get_shelf'])->name("shelf_show");
  Route::get('/section-show/{id}', [App\Http\Controllers\HomeController::class, 'get_section'])->name("section_show");



});
