<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
}
