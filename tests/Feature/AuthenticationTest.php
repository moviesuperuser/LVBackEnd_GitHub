<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
//*************************LOGIN********************************/
  /**
   * @test
   * @group login
   * ? Test 1
   * todo: Test login correct
   * @param email,password
   * @return Status_200
   */
  public function Login_correct()
  {
    $response = $this->postJson('/api/auth/login', ['email' => 'KhanhAn@gmail.com', 'password' => 'password']);
    $response
      ->assertStatus(200);
  }

  /**
   * @test
   * @group login
   * ? Test 2
   * todo: Test Login not have parameters
   * @param No
   * @return Status_400
   */
  public function Login_not_have_parameters()
  {
    $response = $this->postJson('/api/auth/login', []);
    $response
      ->assertStatus(400);
  }

  /**
   * @test
   * @group login
   * ? Test 3
   * todo: Test Login not have password
   * @param email
   * @return Status_400
   */
  public function Login_miss_password()
  {
    $response = $this->postJson('/api/auth/login', ['email' => 'KhanhAn@gmail.com']);
    $response
      ->assertStatus(400);
  }

  /**
   * @test
   * @group login
   * ? Test 4
   * todo: Test Login not have email
   * @param password
   * @return Status_400
   */
  public function Login_miss_email()
  {
    $response = $this->postJson('/api/auth/login', ['password' => 'password']);
    $response
      ->assertStatus(400);
  }

  /**
   * @test
   * @group login
   * ? Test 5
   * todo: Test Password less than 6 characters
   * @param email,password
   * @return Status_400
   */
  public function Login_incorrect_password()
  {
    $response = $this->postJson('/api/auth/login', ['email' => 'KhanhAn@gmail.com', 'password' => 'passw']);
    $response
      ->assertStatus(400);
  }
  /**
   * @test
   * @group login
   * ? Test 6
   * todo: Test Password account is incorrect
   * @param email,password
   * @return Status_401
   */
  public function Login_user_incorrect()
  {
    $response = $this->postJson('/api/auth/login', ['email' => 'KhanhAnaa@gmail.com', 'password' => 'password']);
    $response
      ->assertStatus(401);
  }
  /**
   * @test
   * @group login
   * ? Test 7
   * todo: Test SQL injection in email
   * @param email,password
   * @return Status_400
   */
  public function Login_SQL_Injection_inEmail()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "'SELECT * FROM users", 'password' => 'password']);
    $response
      ->assertStatus(400);
  }
  /**
   * @test
   * @group login
   * ? Test 8
   * todo: Test SQL injection in password
   * @param email,password
   * @return Status_401
   */
  public function Login_SQL_Injection_inPassword()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "'SELECT * FROM users"]);
    $response
      ->assertStatus(401);
  }
  /**
   * @test
   * @group login
   * ? Test 9
   * todo: Test special characters_inEmail
   * @param email,password
   * @return Status_400
   */
  public function Login_Special_Characters_Email()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "!@@#$^@gmail.com", 'password' => "'SELECT * FROM users"]);
    $response
      ->assertStatus(400);
  }
  /**
   * @test
   * @group login
   * ? Test 10
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "!@@#$^"]);
    $response
      ->assertStatus(401);
  }

  //*************************REGISTER********************************/
  // /**
  //  * @test
  //  * @group register
  //  * ? Test 1
  //  * todo: Test Register correct
  //  * @param name,username,email,password,email,dateOfBirth,gender,ShareInfo
  //  * @return Status_200
  //  */
  // public function Register_correct()
  // {
  //   $response = $this->postJson('/api/auth/register', [
  //     'name' => "TestByUnitTest",
  //     'username' => "TestByUnitTest",
  //     'email' => "TestByUnitTest@gmail.com",
  //     'password' => "password",
  //     'SocialMedia' => "NULL",
  //     'dateOfBirth' => "1987-10-12",
  //     'gender' => "Male",
  //     'ShareInfo' => "1",
  //     'Newsletter' => "1",
  //     'PreferedGenres' => "Adventure, Adventure, Comedy",
  //   ]);
  //   $response
  //     ->assertStatus(200);
  // }
  /**
   * @test
   * @group register
   * ? Test 2
   * todo: Test Register Is Ixist in Test 1 
   * @param name,username,email,password,email,dateOfBirth,gender,ShareInfo,Newsletter.PreferedGenres
   * @return Status_200
   */
  public function Register_account_isExist()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1987-10-12",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 2
   * todo: Test Register not have name 
   * @param username,email,password,email,dateOfBirth,gender,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_not_have_name()
  {
    $response = $this->postJson('/api/auth/register', [
      // 'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1987-10-12",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 3
   * todo: Test Register not have username 
   * @param name,email,password,email,dateOfBirth,gender,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_not_have_username()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      // 'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1987-10-12",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 4
   * todo: Test Register not have email 
   * @param name,username,password,dateOfBirth,gender,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_not_have_email()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      // 'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1987-10-12",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 6
   * todo: Test Register not have dateOfBirth 
   * @param name,username,password,gender,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_not_have_dateOfBirth()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      // 'dateOfBirth' => "1987-10-12",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 5
   * todo: Test Register not have gender 
   * @param name,username,password,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_not_have_gender()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1987-10-12",
      // 'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 5
   * todo: Test Register gender is incorrect(must be Male, Female, Non-binary)
   * @param name,username,password,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_gender_is_incorrect()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1987-10-12",
      'gender' => "aale",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  
  
}
