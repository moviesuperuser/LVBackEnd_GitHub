<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Recombee\RecommApi\Client;
use Illuminate\Support\Facades\Hash;
use Recombee\RecommApi\Requests as Reqs;

class ReviewController extends Controller
{
  public function editUserImg(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'id'     => 'required|numeric',
        'urlAvatar' => 'required|string',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $user = User::find($request->id);
    $user->urlAvatar = $request->urlAvatar;
    $user->save();
    $client = new Client("movies202-dev", 'JPhrE3mFxojlFRbEaxzQNQFubp9h73V8h3JtRokprr5Kd3b7uE8O54ZpZOwHB0oT');
    $requestRecombee = new Reqs\SetUserValues($request->id, [
      'urlAvatar' => $request['urlAvatar'],
    ], [
      'cascadeCreate' => false
    ]);
    $requestRecombee->setTimeout(5000);
    $client->send($requestRecombee);
    return "Successful";
  }
  public function updateShareInfo(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'id'        => 'required|numeric',
        'ShareInfo' => 'required|numeric|min:0|max:1',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $user = User::find($request->id);
    $user->ShareInfo = $request->ShareInfo;
    $user->save();
    $client = new Client("movies202-dev", 'JPhrE3mFxojlFRbEaxzQNQFubp9h73V8h3JtRokprr5Kd3b7uE8O54ZpZOwHB0oT');
    $requestRecombee = new Reqs\SetUserValues($request->id, [
      'ShareInfo' => $request['ShareInfo'],
    ], [
      'cascadeCreate' => false
    ]);
    $requestRecombee->setTimeout(5000);
    $client->send($requestRecombee);
    return "Successful";
  }
  public function updateNewsletter(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [    
        'Newsletter' => 'required|numeric|min:0|max:1',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $user = User::find($request->id);
    $user->Newsletter = $request->Newsletter;
    $user->save();
    $client = new Client("movies202-dev", 'JPhrE3mFxojlFRbEaxzQNQFubp9h73V8h3JtRokprr5Kd3b7uE8O54ZpZOwHB0oT');
    $requestRecombee = new Reqs\SetUserValues($request->id, [
      'Newsletter' => $request['Newsletter'],
    ], [
      'cascadeCreate' => false
    ]);
    $requestRecombee->setTimeout(5000);
    $client->send($requestRecombee);
    return "Successful";
  }
  public function changePasswordUser(Request $request){
    $validator = Validator::make(
      $request->all(),
      [
        'id'  => 'required',
        'oldPassword'     => 'required|string|min:6',
        'newPassword' => 'required|string|min:6',
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $userDB = User::find($request['id']);
    if (Hash::check($request['oldPassword'], $userDB['password']) == true) {
      $userDB->password = bcrypt($request['newPassword']);
      $userDB->save();
      return response()->json(
        "Password was changed.",
        200
      );
    }else{
      return response()->json(
        "Password is incorrect",
        402
      );
    }
  }
  public function editUser(Request $request){
    
    $user = User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->dateOfBirth = $request->dateOfBirth;
    $user->gender = $request->gender;
    $user->save();
    $client = new Client("movies202-dev", 'JPhrE3mFxojlFRbEaxzQNQFubp9h73V8h3JtRokprr5Kd3b7uE8O54ZpZOwHB0oT');
    $requestRecombee = new Reqs\SetUserValues($request->id, [
      'name' => $request['name'],
      'email' => $request['email'],
      'dateOfBirth' => $request['dateOfBirth'],
      'gender' => $request['gender'],
    ], [
      'cascadeCreate' => false
    ]);
    $requestRecombee->setTimeout(5000);
    $client->send($requestRecombee);
    return "Successful";
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
          ->select('users.id','users.name', 'Watches.Rating','Watches.Review','Watches.created_at','Watches.updated_at','Watches.titleReview')
          ->get());
        $review_json = array('Reviews' => $review[0]);
      } else {
        $review_json = array();
      }
      $result = $this->createJsonResult($review_json);
      return $result;
  }
  public function createReview(Request $request){
    $validator = Validator::make(
      $request->all(),
      [
        'IdMovie'     => 'required|numeric',
        'IdUser'     => 'required|numeric',
        'Rating'    => 'required|numeric|min:0|max:10',
        'Review' => 'required|string',
        'titleReview' => 'sometimes|string',
        'dateCreate' => 'required|date'

      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $chechReview = DB::table('Watches')
    ->select('*')
    ->where('IdMovie',$request['IdMovie'])
    ->where('IdUser',$request['IdUser'])
    ->get();
    if(count($chechReview)==0){
      $createReview = DB::table('Watches')
    ->insert([
        'IdMovie' => $request['IdMovie'],
        'IdUser' => $request['IdUser'],
        'Rating' => $request['Rating'],
        'Review' => $request['Review'],
        'titleReview' =>  $request['titleReview'],
        'created_at' =>  $request['dateCreate'],
        'updated_at' =>  $request['dateCreate'],
      ]);
      return "Successful";
    }
    else{
      $updateReview = DB::table('Watches')
      ->where('IdMovie',$request['IdMovie'])
      ->where('IdUser',$request['IdUser'])
    ->update([
        'IdMovie' => $request['IdMovie'],
        'IdUser' => $request['IdUser'],
        'Rating' => $request['Rating'],
        'Review' => $request['Review'],
        'titleReview' =>  $request['titleReview'],
        'updated_at' =>  $request['dateCreate'],
      ]);
      return "Successful";
  }
}
}
