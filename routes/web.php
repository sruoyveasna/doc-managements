<?php
use App\Http\Controllers\FieldController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

//
// PUBLIC ROUTES
//

// Home page: list of published documents (outsiders, students, lecturers, admins)
Route::get('/', [DocumentController::class, 'publicIndex'])
    ->name('home');

// Show a single document's details
// - guests: only if document is published
// - logged-in: students see published only, lecturers/admins can see all
Route::get('/documents/{document}', [DocumentController::class, 'show'])
    ->name('documents.show');

//
// DOCUMENT ACTIONS (NEED AUTH + PERMISSIONS)
//

// Download document file
// - must be logged in
// - must pass "download-documents" gate (student/lecturer/admin)
Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
    ->middleware(['auth', 'can:download-documents'])
    ->name('documents.download');

// Post a comment (document evaluation)
// - must be logged in
// - must pass "comment-documents" gate (student/lecturer/admin)

Route::middleware('auth')->group(function () {
    Route::post('/documents/{document}/comments', [CommentController::class, 'store'])
        ->name('documents.comments.store');

    Route::patch('/documents/{document}/comments/{comment}', [CommentController::class, 'update'])
        ->name('documents.comments.update');

    Route::delete('/documents/{document}/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('documents.comments.destroy');
});


//
// AUTHENTICATED USER ROUTES (ANY LOGGED-IN ROLE)
//

Route::middleware('auth')->group(function () {
    // Dashboard for any logged-in user (student / lecturer / admin)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//
// DOCUMENT MANAGEMENT (LECTURER + ADMIN ONLY)
//

// Everything under /manage/documents:
// - must be logged in
// - must pass "manage-documents" gate (lecturer/admin)
Route::middleware(['auth', 'can:manage-documents'])
    ->prefix('manage')
    ->group(function () {

        // List all documents (draft/published/archived)
        Route::get('/documents', [DocumentController::class, 'index'])
            ->name('documents.index');

        // Show create form
        Route::get('/documents/create', [DocumentController::class, 'create'])
            ->name('documents.create');

        // Store new document
        Route::post('/documents', [DocumentController::class, 'store'])
            ->name('documents.store');

        // Show edit form
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])
            ->name('documents.edit');

        // Update document
        Route::put('/documents/{document}', [DocumentController::class, 'update'])
            ->name('documents.update');

        // Delete (soft delete if model uses SoftDeletes)
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
            ->name('documents.destroy');
    });




    Route::prefix('admin')
    ->middleware(['auth', 'can:manage-users'])
    ->group(function () {
        Route::get('/users',           [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create',    [UserController::class, 'create'])->name('users.create');
        Route::post('/users',          [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',    [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });


// ...

    Route::middleware(['auth', 'can:manage-documents'])
        ->prefix('admin')
        ->group(function () {
            // other admin routes...

            // FIELD MANAGEMENT
            Route::get('/fields', [FieldController::class, 'index'])->name('fields.index');
            Route::get('/fields/create', [FieldController::class, 'create'])->name('fields.create');
            Route::post('/fields', [FieldController::class, 'store'])->name('fields.store');
            Route::get('/fields/{field}/edit', [FieldController::class, 'edit'])->name('fields.edit');
            Route::put('/fields/{field}', [FieldController::class, 'update'])->name('fields.update');
            Route::delete('/fields/{field}', [FieldController::class, 'destroy'])->name('fields.destroy');
        });
    Route::middleware(['auth', 'can:manage-users'])
        ->prefix('admin')
        ->group(function () {
            Route::resource('genres', GenreController::class)->except(['show']);
        });


//
// AUTH SCAFFOLDING (Breeze)
//
require __DIR__.'/auth.php';
