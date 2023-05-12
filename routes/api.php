<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('myapi',function(){
   return "hello world";
});

Route::get('/longest-duration-movies', function () {
    $movies = DB::table('movies')
        ->orderByDesc('runtimeMinutes')
        ->limit(10)
        ->select('tconst', 'primaryTitle', 'runtimeMinutes', 'genres')
        ->get();

    return response()->json($movies);
});

Route::post('/new-movie', function (Request $request) {
    $data = $request->validate([
        'tconst' => 'required|unique:movies,tconst',
        'titleType' => 'required',
        'primaryTitle' => 'required',
        'runtimeMinutes' => 'required|integer',
        'genres' => 'required',
    ]);

    DB::table('movies')->insert($data);

    return response('success', 200);
});

Route::get('/top-rated-movies', function () {
   $movies = DB::table('movies')
      ->join('ratings', 'movies.tconst', '=', 'ratings.tconst')
      ->where('ratings.averageRating', '>', 6.0)
      ->orderByDesc('ratings.averageRating')
      ->select('movies.tconst', 'movies.primaryTitle', 'movies.genres', 'ratings.averageRating')
      ->get();

   return response()->json($movies);
});