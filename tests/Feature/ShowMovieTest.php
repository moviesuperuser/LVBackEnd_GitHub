<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowMovieTest extends TestCase
{
  /**
   * @test
   * @group movie
   * ? Test 1
   * todo: Test ShowMovie with slug1
   * @param slug
   * @return Status_200
   */
  public function ShowMovie_with_Slug1()
  {
    $response = $this->json('GET', '/api/ShowMovie/The-Godfather');
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group movie
   * ? Test 2
   * todo: Test ShowMovie with slug2
   * @param slug
   * @return Status_200
   */
  public function ShowMovie_with_Slug2()
  {
    $response = $this->json('GET', '/api/ShowMovie/slug-1/The-Godfather');
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group movie
   * ? Test 3
   * todo: Test ShowMovie with slug3
   * @param slug
   * @return Status_200
   */
  public function ShowMovie_with_Slug3()
  {
    $response = $this->json('GET', '/api/ShowMovie/slug-1/slug-2/The-Godfather');
    $response
      ->assertStatus(200);
  }
   /**
   * @test
   * @group movie
   * ? Test 2
   * todo: Test ShowMovie with slug4
   * @param slug
   * @return Status_404
   */
  public function ShowMovie_with_Slug4()
  {
    $response = $this->json('GET', '/api/ShowMovie/slug-1/slug-2/slug-3/The-Godfather');
    $response
      ->assertStatus(404);
  }
   /**
   * @test
   * @group movie
   * ? Test 5
   * todo: Test ShowMovie with slug movie not exist
   * @param slug
   * @return Status_400
   */
  public function ShowMovie_with_slug_not_exist()
  {
    $response = $this->json('GET', '/api/ShowMovie/not-exist');
    $response
      ->assertStatus(200);
  }
}
