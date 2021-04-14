<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class GenresController extends Controller
{
  private function createJsonResult($response){
    $result = response()->json($response, 200);
      return $result
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  }
  public function GenresTest(){
    $response = DB::statement("select * from Movies  where match (Description,`Title`,`Actors`,`Director`,`GenreName`) against ('Crime' IN NATURAL LANGUAGE MODE)");
    return $this->createJsonResult($response);
  }
  function array_get($array, $key, $default = null)
  {
    return Arr::get($array, $key, $default);
  }
  private function reformatRequest($request)
  {
    return [
      'page' => $this->array_get($request, 'page', null),
      'movienumber' => $this->array_get($request, 'movienumber', null),
      'sort' => $this->array_get($request, 'sort', null),

    ];
  }
  private function select_group_genres($slug, $show_product, $skip_product_in_page, $sort)
  {
    if ($sort == "Default") {
      $movie = DB::table('Movies')
        ->where('GenreName', 'like', '%' . $slug . '%')
        ->select("*")
        ->skip($skip_product_in_page)
        ->take($show_product)
        ->orderBy('Movies.created_at',"ASC")
        ->get();
    } else {
      // dd($skip_product_in_page);
      $movie = DB::table('Movies')
        ->where('GenreName', 'like', '%' . $slug . '%')
        ->select("*")
        ->skip($skip_product_in_page)
        ->take($show_product)
        ->orderBy('Movies.Title', $sort)
        ->get();
    }
    return $movie;
  }
  private function genres_sort($slug, $sort, $current_page, $show_product)
  {
    $skip_product_in_page = ($current_page - 1) * $show_product;
    if ($sort == "Default") {
      $result =  $this->select_group_genres($slug, $show_product, $skip_product_in_page, 'Default');
      return $result;
    } elseif ($sort == "A-to-Z") {
      $result =  $this->select_group_genres($slug, $show_product, $skip_product_in_page, 'ASC');
      return $result;
    } elseif ($sort == "Z-to-A") {
      $result = $this->select_group_genres($slug, $show_product, $skip_product_in_page, 'DESC');
      return $result;
    }
  }
  public function ShowGenres($slug1, $slug2 = null, $slug3 = null, Request $request)
  {
    $this->slug = $slug3 ?? $slug2 ?? $slug1;
    if (isset($this->slug)) {
      $this->request = $this->reformatRequest(Request::capture()->all());
      if ($request['page']) {
        $current_page = $request['page'];
        // dd($current_page);
      } else {
        $current_page = 1;
      }
      if ($request['movienumber']) {
        $show_product = $request['movienumber'];
        // dd($show_product);
      } else {
        $show_product = 20;
      }

      /*Get option sort*/
      if ($request['sort']) {
        $sort = $request['sort'];
      } else {
        $sort = 'Default';
      }
      $response = $this->genres_sort($this->slug, $sort, $current_page, $show_product);
      return $this->createJsonResult($response);
    }
  }
}
