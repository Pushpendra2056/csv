<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FromController;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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
Route::get('/',function(){
	return view('welcome');
});
Route::get('main',[FromController::class,'mainFunction']);
Route::get('movie-import',[FromController::class,'csvFileImportForMovieTable']);
Route::get('ratings-import',[FromController::class,'csvFileImportForRatingsTable']);
Route::get('/genre-movies-with-subtotals', function () {
    $movies = DB::table('movies')
        ->join('ratings', 'movies.tconst', '=', 'ratings.tconst')
        ->select('movies.genres', 'movies.primaryTitle', DB::raw('SUM(ratings.numVotes) as numVotes'))
        ->groupBy('movies.genres', 'movies.primaryTitle')
        ->orderBy('movies.genres', 'asc')
        ->orderByDesc('numVotes')
        ->get();

    return view('genre-movies-with-subtotals', ['movies' => $movies]);
});
Route::get('form',[FromController::class,'index']);
Route::post('form-submit',[FromController::class,'data']);
Route::get('view-student',[FromController::class,'viewStudent']);
Route::get('delete/{id}',[FromController::class,'delete']);
Route::get('edit/{id}',[FromController::class,'edit']);
Route::post('edit-submit',[FromController::class,'editSubmit']);


