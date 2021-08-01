<?php

namespace Tests\Feature;

use Tests\TestCase;

class GenreTest extends TestCase
{
  /**
   * @test
   * @group genre
   * ? Test 1
   * todo: Test showgenre with slug1
   * @param slug
   * @return Status_200
   */
  public function showgenre_with_Slug1()
  {
    $response = $this->json('GET', '/api/ShowGenres/Musical');
    $response
      ->assertStatus(200);
  }
  /**
   * @test
   * @group genre
   * ? Test 2
   * todo: Test showgenre with slug2
   * @param slug
   * @return Status_500
   */
  public function showgenre_with_Slug2()
  {
    $response = $this->json('GET', '/api/ShowGenres/slug-1/Musical');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group genre
   * ? Test 3
   * todo: Test showgenre with slug3
   * @param slug
   * @return Status_500
   */
  public function showgenre_with_Slug3()
  {
    $response = $this->json('GET', '/api/ShowGenres/slug-1/slug-2/Musical');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group genre
   * ? Test 2
   * todo: Test showgenre with slug4
   * @param slug
   * @return Status_404
   */
  public function showgenre_with_Slug4()
  {
    $response = $this->json('GET', '/api/ShowGenres/slug-1/slug-2/slug-3/Musical');
    $response
      ->assertStatus(404);
  }
  /**
   * @test
   * @group genre
   * ? Test 5
   * todo: Test showgenre with slug movie not exist
   * @param slug
   * @return Status_500
   */
  public function showgenre_with_slug_not_exist()
  {
    $response = $this->json('GET', '/api/ShowGenres/Musicalss');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group genre
   * ? Test 6
   * todo: Test showgenre with slug movie not enough 
   * @param slug
   * @return Status_500
   */
  public function showgenre_with_slug_not_enough()
  {
    $response = $this->json('GET', '/api/ShowGenres/Musi');
    $response
      ->assertStatus(500);
  }
}
