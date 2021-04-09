<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests as Reqs;
use Recombee\RecommApi\Exceptions as Ex;
use Carbon\Carbon;

class AuthController extends Controller
{


  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  } //end __construct()


  public function login(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
      ]
    );

    if ($validator->fails()) {
      return response()->json($validator->errors(), 400);
    }

    $token_validity = (24 * 60);

    $this->guard()->factory()->setTTL($token_validity);

    if (!$token = $this->guard()->attempt($validator->validated())) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  } //end login()


  
  public function register(Request $request)
  {
    $toArrayPreferedGenres = explode(",",$request->PreferedGenres);
    $validator = Validator::make(
      $request->all(),
      [
        'username'     => 'required|string|between:2,100',
        'name'     => 'required|string|between:2,100',
        'email'    => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
        'SocialMedia' => 'sometimes|string',
        'dateOfBirth' => 'required|date',
        'gender' => 'required|string',
        'urlAvatar' => 'sometimes|string',
        'ShareInfo' => 'required|numeric|min:0|max:1',
        'PreferedGenres' => 'required|string'

      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    //Check validate Gender
    $gender = $request->gender;
    if ($gender != 'Male' && $gender != 'Female' && $gender != 'Non-binary') {
      return response()->json(
        "Gender not correct",
        422
      );
    }
    //Check SocialMedia null
    $SocialMedia = $request->SocialMedia;
    if ($SocialMedia === 'undefined' || $SocialMedia === 'null') {
      $request->merge(['SocialMedia' => ""]);
    }
    //Check UrlAvatar null
    $urlAvatar = $request->urlAvatar;
    if ($urlAvatar === 'undefined' || $urlAvatar === 'null') {
      $request->merge(['urlAvatar' => ""]);
    }

    $user = new User();
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->SocialMedia = $request->SocialMedia;
    $user->dateOfBirth = $request->dateOfBirth;
    $user->gender = $request->gender;
    $user->urlAvatar = $request->urlAvatar;
    $user->PreferedGenres = $request->PreferedGenres;
    $user->ShareInfo = $request->ShareInfo;
    $user->id = $user->id;
    $user->save();



    // $user = User::create(
    //   array_merge(
    //     $validator->validated(),
    //     ['password' => bcrypt($request->password)]
    //   )
    // );
    //UPload REcomendBee
    $client = new Client("movies-dev", 'QKR26O5fSEtJnB7dxPrlpkE2rH2f093uh0ir5PlbrBphGEWYy8cl3rTIRxvqhzB1');
    // $test = {"Film-Noir", "Mystery"};
    $requestRecombee = 
      new Reqs\SetUserValues(
        $user->id,
        [
          "username" => $request->username,
          "name" => $request->name,
          "SocialMedia" => $request->SocialMedia,
          "age" => Carbon::parse($request->dateOfBirth)->age,
          "gender" => $request->gender,
          "VIP" => false,
          "FreeTrial"=>true,
          "urlAvatar" => $urlAvatar,
          "PreferedGenres" => json_decode(json_encode($toArrayPreferedGenres), FALSE),
          "ShareInfo" => $request->ShareInfo
        ],
        //optional parameters
        [
          "cascadeCreate" => true
        ]
    );
    $requestRecombee->setTimeout(5000);
    $client->send($requestRecombee);
    return response()->json(['message' => 'Comment created successfully']);
  } //end register()


  public function logout()
  {
    $this->guard()->logout();

    return response()->json(['message' => 'User logged out successfully']);
  } //end logout()


  public function profile()
  {
    return response()->json($this->guard()->user());
  } //end profile()


  public function refresh()
  {
    return $this->respondWithToken($this->guard()->refresh());
  } //end refresh()


  protected function respondWithToken($token)
  {
    return response()->json(
      [
        'token'          => $token,
        'token_type'     => 'bearer',
        'token_validity' => ($this->guard()->factory()->getTTL() * 60),
      ]
    );
  } //end respondWithToken()


  protected function guard()
  {
    return Auth::guard();
  } //end guard()


}//end class
