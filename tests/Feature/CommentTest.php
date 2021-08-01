<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
  //******************************TEST SHOWCOMMENT****************************************/
  /**
   * @test
   * @group comment
   * ? Test 1
   * todo: Test showcomment with movieID
   * @param MovieId
   * @return Status_200
   */
  public function showcomment_with_movieID()
  {
    $response = $this->json('GET', '/api/comment/showComments/2');
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group comment
   * ? Test 2
   * todo: Test showcomment with movieSlug
   * @param slug
   * @return Status_200
   */
  public function showcomment_with_movieSlug()
  {
    $response = $this->json('GET', '/api/comment/showComments/The-GodFather');
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group comment
   * ? Test 3
   * todo: Test showcomment not have param
   * @param 
   * @return Status_404
   */
  public function showcomment_no_param()
  {
    $response = $this->json('GET', '/api/comment/showComments');
    $response
      ->assertStatus(404);
  }
  //*********************ADD Comment*********************************/
  /**
   * @test
   * @group comment
   * ? Test 1
   * todo: Test addcomment not have param
   * @param 
   * @return Status_405
   */
  public function addcomment_no_param()
  {
    $response = $this->json('GET', '/api/comment/addComment');
    $response
      ->assertStatus(405);
  }
  /**
   * @test
   * @group comment
   * ? Test 2
   * todo: Test addcomment not IdMovie
   * @param IdUser,IdParentUser,UserName,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_not_have_IDMovie()
  {
    $response = $this->postJson('/api/comment/addComment', [
      // 'IdMovie' => "TestByUnitTest",
      'IdUser' => 2,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-18-11",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group comment
   * ? Test 3
   * todo: Test addcomment not IdUser
   * @param IdUser,IdParentUser,UserName,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_not_have_IDUser()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 3,
      // 'IdUser' => 2,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-18-11",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group comment
   * ? Test 4
   * todo: Test addcomment not have IdParentUser
   * @param IdMovie,IdUser,UserName,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_not_have_IdParentUser()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 1,
      'IdUser' => 2,
      // 'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-18-11",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group comment
   * ? Test 5
   * todo: Test addcomment not have UserName
   * @param IdMovie,IdUser,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_not_have_UserName()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 1,
      'IdUser' => 2,
      'IdParentUser' => 1,
      // 'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-18-11",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group comment
   * ? Test 6
   * todo: Test addcomment not have UserName
   * @param IdMovie,IdUser,UserName,IdParentUser,dateCreate
   * @return Status_422
   */
  public function addcomment_not_have_Body()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 1,
      'IdUser' => 2,
      'IdParentUser' => 1,
      'UserName' => "An",
      // 'Body' => "Comment Test",
      'dateCreate' => "1999-18-11",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group comment
   * ? Test 7
   * todo: Test addcomment not have UserName
   * @param IdMovie,IdUser,UserName,IdParentUser,Body
   * @return Status_422
   */
  public function addcomment_not_have_dateCreate()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 1,
      'IdUser' => 2,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      // 'dateCreate' => "1999-18-11",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group comment
   * ? Test 8
   * todo: Test addcomment with Idmovie not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdMovie_not_have_DB()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 100000000000000000000,
      'IdUser' => 2,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }

  /**
   * @test
   * @group comment
   * ? Test 8
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 9
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_2()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 10
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_3()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 11
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_4()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 8
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_5()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 8
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_6()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 8
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_7()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group comment
   * ? Test 8
   * todo: Test addcomment with IdUser not have in DB
   * @param IdMovie,IdUser,UserName,IdParentUser,Body,dateCreate
   * @return Status_422
   */
  public function addcomment_IdUser_not_have_DB_8()
  {
    $response = $this->postJson('/api/comment/addComment', [
      'IdMovie' => 2,
      'IdUser' => 100000000000000000000,
      'IdParentUser' => 1,
      'UserName' => "An",
      'Body' => "Comment Test",
      'dateCreate' => "1999-11-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(500);
  }
}
