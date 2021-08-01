<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
  /**
   * @test
   * @group review
   * ? Test 1
   * todo: Test ShowReview with MovieId
   * @param MovieId
   * @return Status_200
   */
  public function ShowReview_with_MovieId()
  {
    $response = $this->json('GET', '/api/review/showReviews/100');
    $response
      ->assertStatus(200);
  }
     /**
   * @test
   * @group review
   * ? Test 2
   * todo: Test ShowReview with MovieId not exist
   * @param MovieId
   * @return Status_200
   */
  public function ShowReview_with_MovieId_not_Exist()
  {
    $response = $this->json('GET', '/api/review/showReviews/-1');
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 3
   * todo: Test creaate review successful
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_successful()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 4
   * todo: Test creaate review duplicate
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_duplicate()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 5
   * todo: Test creaate review drop MovieId
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_drop_MovieId()
  {
    $response = $this->postJson('/api/review/createReview', [
      // 'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group review
   * ? Test 6
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_2()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 7
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_7()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 8
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_8()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 9
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_9()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 10
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_10()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 11
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_11()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 12
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_12()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test _13
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_13()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 14
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_14()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group review
   * ? Test 15
   * todo: Test creaate review with MovieId not exist
   * @param IdMovie,IdUser,Rating,Review,titleReview,dateCreate
   * @return Status_422
   */
  public function create_review_MovieId_not_exist_15()
  {
    $response = $this->postJson('/api/review/createReview', [
      'IdMovie' => 1,
      'IdUser' => 1,
      'Rating' => 10,
      'Review' => "Unit Test Review",
      'titleReview' => "title Test",
      'dateCreate' => "2021-07-18",
    ]);
    // dd($response);
    $response
      ->assertStatus(200);
  }
}
 