<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
  public function editUser(Request $request){
    
    $user = User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->dateOfBirth = $request->dateOfBirth;
    $user->gender = $request->gender;
    $user->urlAvatar = $request->urlAvatar;
    $user->save();
    return "An";
  }
  private function createJsonResult($response)
  {
    $result = response()->json($response, 200);
    return $result
      ->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  }
  public function showReviews($IdMovie)
  {
      if (isset($IdMovie)) {

        $review = array(DB::table('Watches')
          ->join('users', 'users.id', 'Watches.IdUser')
          ->where('Watches.IdMovie', $IdMovie)
          ->where('Watches.Review', '!=', null)
          ->select('users.name', 'Watches.Review')
          ->get());
        $review_json = array('Reviews' => $review[0]);
      } else {
        $review_json = array();
      }
      $result = $this->createJsonResult($review_json);
      return $result;
  }
  public function addReview(Request $request){

  }
}
