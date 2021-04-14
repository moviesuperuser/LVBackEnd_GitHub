<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Collection;
use App\Search\MultiMovies;


class CollectionController extends Controller
{

  private function createJsonResult($response)
  {
    $result = response()->json($response, 200);
    return $result
      ->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  }
  public function ShowCollectionList(){
    $movie = DB::table('Collections')
    ->select('*')
    ->get();
    return $this->createJsonResult($movie);
  }
  public function Test(){
    // $query = 'crime'; // <--  Change the query for testing.
    // $articles = MultiMovies::search($query)->get();
    // return $articles;

    // $newmulti = new MultiMovies();

    // $newmulti->CollectionName= 'June fav';
    // $newmulti->Slug ='June-fav';
    // $newmulti->save();
    $newc= new Collection();
    $newc->CollectionName= 'July fav';
    $newc->Slug ='July-fav';
    $newc->save();
  //   $query = 'crime'; // <--  Change the query for testing.
  // $articles = Collection::save($query)->get();
  // return $articles;
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
  private function select_group_movies_collection($collection_id, $show_product, $skip_product_in_page, $sort)
  {
    if ($sort == "Default") {
      $movie = DB::table('CollectionAndMovies')
        ->join('Movies','Movies.Id','CollectionAndMovies.IdMovie')
        ->where('CollectionAndMovies.IdCollection','=',  $collection_id)
        ->select("*")
        ->skip($skip_product_in_page)
        ->take($show_product)
        ->orderBy('Movies.created_at', "ASC")
        ->get();
    } else {
      // dd($skip_product_in_page);
      $movie = DB::table('CollectionAndMovies')
        ->join('Movies','Movies.Id','CollectionAndMovies.IdMovie')
        ->where('CollectionAndMovies.IdCollection','=',  $collection_id)
        ->select("*")
        ->skip($skip_product_in_page)
        ->take($show_product)
        ->orderBy('Movies.Title', $sort)
        ->get();
    }
    return $movie;
  }
  private function collection_sort($slug, $sort, $current_page, $show_product)
  {
    $collection_id = (array)DB::table("Collections")
      ->where('Slug', 'like', '%' . $slug . '%')
      ->select('id')
      ->first();
    $collection_id = Arr::get($collection_id, 'id',null);
    $skip_product_in_page = ($current_page - 1) * $show_product;
    if ($sort == "Default") {
      $result =  $this->select_group_movies_collection($collection_id, $show_product, $skip_product_in_page, 'Default');
      return $result;
    } elseif ($sort == "A-to-Z") {
      $result =  $this->select_group_movies_collection($collection_id, $show_product, $skip_product_in_page, 'ASC');
      return $result;
    } elseif ($sort == "Z-to-A") {
      $result = $this->select_group_movies_collection($collection_id, $show_product, $skip_product_in_page, 'DESC');
      return $result;
    }
  }
  public function ShowCollection($slug1, $slug2 = null, $slug3 = null, Request $request)
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
      $response = $this->collection_sort($this->slug, $sort, $current_page, $show_product);
      $result = response()->json($response, 200);
      return $result
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
  }
}
