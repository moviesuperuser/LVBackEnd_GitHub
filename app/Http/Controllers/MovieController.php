<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WatchLater;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
  public function ShowMovie($slug1, $slug2 = null, $slug3 = null)
  {
    $this->slug = $slug3 ?? $slug2 ?? $slug1;
    if (isset($this->slug)) {
      $movie = (array)DB::table('Movies')
        ->where('Slug', $this->slug)
        ->select()
        ->first();
      if (isset($movie['id'])) {
        $review = array(DB::table('Watches')
          ->join('users', 'users.id', 'Watches.IdUser')
          ->where('Watches.IdMovie', $movie['id'])
          ->where('Watches.Review', '!=', null)
          ->select('users.name', 'Watches.Review')
          ->get());
        $review_json = array('Reviews' => $review[0]);
        $movie_json = array_merge($movie, $review_json);
        $result = response()->json($movie_json, 200);
      } else {
        $movie_json = array();
      }
      $result = response()->json($movie_json, 200);
      return $result
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
  }
  public function addWatchLater(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'IdMovie'     => 'required|numeric',
        'IdUser'     => 'required|numeric',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $checkExist = DB::table('WatchLater')
      ->where('idUser', $request->IdUser)
      ->where('idMovie', $request->IdMovie)
      ->select('idUser')
      ->first();
    if ($checkExist != null) {
      return response()->json(
        "Movies have been added to WatchLater!",
        422
      );
    } else {
      $addWatchLater = new WatchLater();
      $addWatchLater->idUser = $request->IdUser;
      $addWatchLater->idMovie = $request->IdMovie;
      $addWatchLater->save();
      return "Successful";
    }
  }
  public function deleteWatchLater(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'IdMovie'     => 'required|numeric',
        'IdUser'     => 'required|numeric',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $checkExist = DB::table('WatchLater')
      ->where('idUser', $request->IdUser)
      ->where('idMovie', $request->IdMovie)
      ->select('idUser')
      ->first();
    if ($checkExist == null) {
      return response()->json(
        "Movie does not exist in WatchLater!",
        422
      );
    } else {
      DB::table('WatchLater')
        ->where('idUser', $request->IdUser)
        ->where('idMovie', $request->IdMovie)
        ->delete();
      return "Successful";
    }
  }
  public function showWatchLaterList(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'IdUser'     => 'required|numeric',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }

    $WatchLaterList = DB::table('WatchLater')
      ->rightJoin("Movies", "Movies.id", "WatchLater.idMovie")
      ->where('WatchLater.idUser', $request->IdUser)
      ->select('Movies.*')
      ->get();
    $result = response()->json($WatchLaterList, 200);
    return $result
      ->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  }
}
