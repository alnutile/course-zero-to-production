<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ChapterControler;
use App\Http\Controllers\ChapterMakerController;
use App\Http\Controllers\OpenAiGenerateImageController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/subscriptions', [SubscriptionController::class, 'index'])
    ->name('subscriptions.index');

Route::get('/product-checkout', function (Request $request) {
    return $request->user()
        ->newSubscription('default', 'price_1N18h3DtrQsiGw9vifKvdxi9')
        ->checkout();
})->name('product.checkout');

Route::post('/subscriptions', [SubscriptionController::class, 'subscribe'])
    ->name('subscriptions.create');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/billing-portal', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('books.index'));
    })->name('billing.portal');

    Route::get('/dashboard', function () {
        return to_route('books.index');
    })->name('dashboard');

    Route::get('/books', [BookController::class, 'index'])
        ->name('books.index');

    Route::get('/books/create', [BookController::class, 'create'])
        ->name('books.create');

    Route::post('/books/store', [BookController::class, 'store'])
        ->name('books.store');

    Route::get('/books/{book}', [BookController::class, 'show'])
        ->name('books.show');

    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->name('books.edit');

    Route::put('/books/{book}', [BookController::class, 'update'])
        ->name('books.update');

    Route::controller(ChapterControler::class)->group(
        function () {
            Route::post('/chapters/{book}/create', 'store')
                ->name('chapters.create');

            Route::post('/chapters/{chapter}/suggestions', 'getEditSuggestions')
                ->name('chapters.openai.suggestions');
        }
    );

    Route::controller(ChapterMakerController::class)->group(
        function () {
            Route::post('/chapters/{book}/generate', 'getChapterIdea')
                ->name('chapter.maker.generate.idea');
        }
    );

    Route::post('/openai/generate_image', OpenAiGenerateImageController::class)
        ->name('openai.images');

    Route::controller(ChapterControler::class)->group(
        function () {
            Route::get('/books/{book}/chapters/{chapter}', 'show')
                ->name('chapters.show');
        }
    );
});
