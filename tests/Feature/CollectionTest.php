<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
  //***************************ShowCollectionList********************************************/
  /**
   * @test
   * @group collection
   * ? Test 1
   * todo: Test showCollection List
   * @param 
   * @return Status_200
   */
  public function showCollectionList()
  {
    $response = $this->json('GET', '/api/ShowCollectionList');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test 1
   * todo: Test showCollection List
   * @param slug
   * @return Status_404
   */
  public function showCollectionList_with_Slug()
  {
    $response = $this->json('GET', '/api/ShowCollectionList/movie');
    $response
      ->assertStatus(404);
  }
  //***********************ShowCollection************************************/
  /**
   * @test
   * @group collection
   * ? Test 1
   * todo: Test ShowCollection with slug1
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_Slug1()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musical');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test 2
   * todo: Test ShowCollection with slug2
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_Slug2()
  {
    $response = $this->json('GET', '/api/ShowCollection/slug-1/Musical');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test 3
   * todo: Test ShowCollection with slug3
   * @param slug
   * @return Status_500
   */
  public function ShowCollection_with_Slug3()
  {
    $response = $this->json('GET', '/api/ShowCollection/slug-1/slug-2/Musical');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test 2
   * todo: Test ShowCollection with slug4
   * @param slug
   * @return Status_404
   */
  public function ShowCollection_with_Slug4()
  {
    $response = $this->json('GET', '/api/ShowCollection/slug-1/slug-2/slug-3/Musical');
    $response
      ->assertStatus(404);
  }
  /**
   * @test
   * @group collection
   * ? Test 5
   * todo: Test ShowCollection with slug movie not exist
   * @param slug
   * @return Status_400
   */
  public function ShowCollection_with_slug_not_exist()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musicalss');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test 6
   * todo: Test ShowCollection with slug movie not enough 
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_slug_not_enough()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musi');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test
   * todo: Test ShowCollection with slug movie not enough 
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_slug_not_enough_2()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musi');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test
   * todo: Test ShowCollection with slug movie not enough 
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_slug_not_enough_3()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musi');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test
   * todo: Test ShowCollection with slug movie not enough 
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_slug_not_enough_4()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musi');
    $response
      ->assertStatus(500);
  }
  /**
   * @test
   * @group collection
   * ? Test
   * todo: Test ShowCollection with slug movie not enough 
   * @param slug
   * @return Status_200
   */
  public function ShowCollection_with_slug_not_enough_5()
  {
    $response = $this->json('GET', '/api/ShowCollection/Musi');
    $response
      ->assertStatus(500);
  }
}
