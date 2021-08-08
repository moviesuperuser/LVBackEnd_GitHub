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
    $user = User::where('email',$request['email'])->first();
    // return $user;
    $banExpired = $user['BAN_expired'];
    $banNum = $user['Banned'];
    
    $nowTime = Carbon::now('UTC');
    if ($nowTime->lessThan($banExpired)) {
      $hourBan = $nowTime->diffInHours($banExpired);
      if($hourBan>0){
        return response()->json(
        "Xin lỗi! Bạn đã bị ban trong ".$hourBan." giờ.",
        207
        );
      }
      else{
        $minuteBan = $nowTime->diffInMinutes($banExpired);
        return response()->json(
          "Xin lỗi! Bạn đã bị ban trong ".$minuteBan." phút.",
          207
        );
      }
    }
    $token_validity = (24 * 60);

    $this->guard()->factory()->setTTL($token_validity);

    if (!$token = $this->guard()->attempt($validator->validated())) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  } //end login()


  private function PreferedGenresFormat($PreferedGenres){
    $result = str_replace(' ', '', $PreferedGenres);
    $result =  str_replace('{', '', $result);
      return str_replace('}', '', $result);
  }
  private function PreferedGenresFormatRecombee($PreferedGenres){
    $result = str_replace('}', '', $PreferedGenres);
    $result =  str_replace('{', '', $result);
    $toArrayPreferedGenres = explode(",", $result);
      return json_decode(json_encode($toArrayPreferedGenres), FALSE);
  }
  public function register(Request $request)
  {
    $toArrayPreferedGenres = explode(",", $request->PreferedGenres);
    $validator = Validator::make(
      $request->all(),
      [
        'username'     => 'required|string|between:2,100',
        'name'     => 'required|string|between:2,100',
        'email'    => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'SocialMedia' => 'sometimes|string',
        'dateOfBirth' => 'required|date',
        'gender' => 'required|string',
        'urlAvatar' => 'sometimes|string',
        'ShareInfo' => 'required|numeric|min:0|max:1',
        'Newsletter' => 'required|numeric|min:0|max:1',
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
    $user->PreferedGenres =$this->PreferedGenresFormat($request->PreferedGenres);
    $user->ShareInfo = $request->ShareInfo;
    $user->Newsletter = $request->Newsletter;
    $user->id = $user->id;
    $user->save();

    //UPload REcomendBee
    $client = new Client("movies202-dev", 'JPhrE3mFxojlFRbEaxzQNQFubp9h73V8h3JtRokprr5Kd3b7uE8O54ZpZOwHB0oT');
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
          "FreeTrial" => true,
          "urlAvatar" => $urlAvatar,
          "PreferedGenres" => $this->PreferedGenresFormatRecombee($request->PreferedGenres),
          "ShareInfo" => $request->ShareInfo,
          "Newsletter" => $request->Newsletter
        ],
        //optional parameters
        [
          "cascadeCreate" => true
        ]
      );
    $requestRecombee->setTimeout(5000);
    $client->send($requestRecombee);
    return response()->json(['message' => 'User created successfully']);
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
