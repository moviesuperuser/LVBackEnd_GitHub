<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CommentsController extends Controller
{
  public function action(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'IdComment' => 'required|numeric',
        'IdUser'    => 'required|numeric',
        'Action'    => 'required|numeric|min:-1|max:1',
        'date'      => 'required|date'
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    //Check Action issit in Comment_Action table
    $action_check = (array)DB::table('Comment_action')
      ->where('IdComment', $request['IdComment'])
      ->where('IdUSer', $request['IdUser'])
      ->select('Action')
      ->first();
    //Update ACtion in Comment Table
    $actionCommentTable = (array)DB::table('Comments')
      ->where('id', $request['IdComment'])
      ->select('Like', 'Dislike', 'Sumlike')
      ->first();
    // dd($action_check);
    $like = $actionCommentTable['Like'];
    $dislike = $actionCommentTable['Dislike'];
    $Sumlike = $actionCommentTable['Sumlike'];
    if ((count($action_check) == 0)) {
      if ($request['Action'] != 0) {
        $action_check = DB::table('Comment_action')
          ->where('IdComment', $request['IdComment'])
          ->where('IdUser', $request['IdUser'])
          ->insert([
            'IdComment' => $request['IdComment'],
            'IdUser' => $request['IdUser'],
            'Action' => $request['Action'],
            'created_at' => $request['date'],
            'updated_at' => $request['date']
          ]);

        if ($request['Action'] == -1) {
          $dislike = $dislike + 1;
          $Sumlike = $Sumlike - 1;
        } else {
          $like = $like + 1;
          $Sumlike = $Sumlike + 1;
        }
      }
    } else {
      if ($request['Action'] != 0) {
        if ($action_check['Action'] != $request['Action']) {
          $action_Comment_check = DB::table('Comment_action')
            ->where('IdComment', $request['IdComment'])
            ->where('IdUser', $request['IdUser'])
            ->update([
              'Action' => $request['Action'],
              'updated_at' => $request['date']
            ]);

          if ($request['Action'] == -1) {
            $dislike = $dislike + 1;
            $like = $like - 1;
            $Sumlike = $Sumlike - 2;
          } else {
            $like = $like + 1;
            $dislike = $dislike - 1;
            $Sumlike = $Sumlike + 2;
          }
        }
      } else {
        $action_Comment_check = DB::table('Comment_action')
          ->where('IdComment', $request['IdComment'])
          ->where('IdUser', $request['IdUser'])
          ->delete();
        if ($action_check['Action'] == -1) {
          $dislike = $dislike - 1;
          $Sumlike = $Sumlike + 1;
        }
        if ($action_check['Action'] == 1) {
          $like = $like + 1;
          $Sumlike = $Sumlike + 1;
        }
      }
    }
    $Comment_action_update = DB::table("Comments")
      ->where('id', $request['IdComment'])
      ->update([
        'Like' => $like,
        'Dislike' => $dislike,
        'Sumlike' => $Sumlike
      ]);
    return response()->json(
      "Successfull",
      200
    );
  }



  private function createJsonResult($response)
  {
    $result = response()->json($response, 200);
    return $result
      ->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  }


  public function showComments($IdMovie)
  {
    $rootComments = DB::table('Comments')
      ->where('IdMovie', '=', $IdMovie)
      ->where('IdParentUser', -1)
      ->orderBy('Sumlike', "DESC")
      ->select("*")
      ->get();
    $result = [];
    foreach ($rootComments as $comment) {
      $comment = (array)$comment;
      $childComments = DB::table('Comments')
        ->where('IdMovie', '=', $IdMovie)
        ->where('IdParentUser', $comment['id'])
        ->orderBy('created_at', "DESC")
        ->select("*")
        ->get();
      if (count($childComments) == 0) {
        $childCommentsJson = [];
      } else {
        $childCommentsJson =  $childComments;
      }
      $comment_result = array(
        'id' => $comment['id'],
        'IdMovie' => $comment['IdMovie'],
        'IdUser' => $comment['IdUser'],
        'IdParentUser' => $comment['IdParentUser'],
        'UserName' => $comment['UserName'],
        'Body' => $comment['Body'],
        'Flag' => $comment['Flag'],
        'Like' => $comment['Like'],
        'Dislike' => $comment['Dislike'],
        'Sumlike' => $comment['Sumlike'],
        'created_at' =>  $comment['created_at'],
        'updated_at' =>  $comment['updated_at'],
        'childComments' => $childCommentsJson
      );
      $result = array_merge($result, array($comment_result));
    }
    return $this->createJsonResult($result);
  }
  public function updateComment(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'id' => 'required|numeric',
        'IdMovie' => 'required|numeric',
        'IdUser' => 'required|numeric',
        'IdParentUser' => 'sometimes|numeric',
        'UserName' => 'required|string',
        'Body' => 'required|string',
        'dateUpdate' =>  'required|date'
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    $updateComment = DB::table('Comments')
      ->where('id', $request['id'])
      ->where('IdMovie', $request['IdMovie'])
      ->where('IdUser', $request['IdUser'])
      ->update([
        'IdMovie' => $request['IdMovie'],
        'IdUser' => $request['IdUser'],
        'IdParentUser' => $request['IdParentUser'],
        'UserName' => $request['UserName'],
        'Body' => $request['Body'],
        'updated_at' =>  $request['dateUpdate'],
      ]);
    return $this->createJsonResult($request->all());
    return response()->json(
      [$request->all()],
      200
    );
  }
  public function addComment(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'IdMovie' => 'required|numeric',
        'IdUser' => 'required|numeric',
        'Body' => 'required|string',
        'dateCreate' =>  'required|date'
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [$validator->errors()],
        422
      );
    }
    try {
      $addComment = DB::table('Comments')
        ->insert([
          'IdMovie' => $request['IdMovie'],
          'IdUser' => $request['IdUser'],
          'UserName' => $request['UserName'],
          'Body' => $request['Body'],
          'created_at' =>  $request['dateCreate'],
          'updated_at' =>  $request['dateCreate'],
        ]);
    } catch (ModelNotFoundException $exception) {
      return back()->withError($exception->getMessage())->withInput();
    }
    return response()->json(
      ["CREATED"],
      200
    );
  }
}
