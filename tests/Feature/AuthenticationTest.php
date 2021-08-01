<?php

namespace Tests\Feature;
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
    /**
   * @test
   * @group login
   * ? Test 11
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password_2()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "!@@#$^"]);
    $response
      ->assertStatus(401);
  }
    /**
   * @test
   * @group login
   * ? Test 12
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password_3()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "!@@#$^"]);
    $response
      ->assertStatus(401);
  }
      /**
   * @test
   * @group login
   * ? Test 14
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password_4()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "!@@#$^"]);
    $response
      ->assertStatus(401);
  }
      /**
   * @test
   * @group login
   * ? Test 15
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password_5()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "!@@#$^"]);
    $response
      ->assertStatus(401);
  }
      /**
   * @test
   * @group login
   * ? Test 11
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password_6()
  {
    $response = $this->postJson('/api/auth/login', ['email' => "KhanhAn@gmail.com", 'password' => "!@@#$^"]);
    $response
      ->assertStatus(401);
  }

      /**
   * @test
   * @group login
   * ? Test 17
   * todo: Test special characters_inPassword
   * @param email,password
   * @return Status_401 
   */
  public function Login_Special_Characters_Password_7()
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
  //  * @param name,username,email,password,email,SocialMedia,dateOfBirth,gender,ShareInfo
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
   * @param name,username,email,password,email,dateOfBirth,SocialMedia,gender,ShareInfo,Newsletter.PreferedGenres
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
   * @param username,email,password,email,dateOfBirth,gender,SocialMedia,ShareInfo,Newsletter.PreferedGenres
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
   * @param name,email,password,email,dateOfBirth,gender,SocialMedia,ShareInfo,Newsletter.PreferedGenres
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
   * @param name,username,password,dateOfBirth,gender,SocialMedia,ShareInfo,Newsletter.PreferedGenres
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
   * @param name,username,email,password,gender,ShareInfo,SocialMedia,Newsletter.PreferedGenres
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
   * @param name,email,username,password,dateOfBirth,SocialMedia,ShareInfo,Newsletter.PreferedGenres
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
   * ? Test 7
   * todo: TestRegister gender is incorrect(must be Male, Female, Non-binary)
   * @param name,email,username,password,gender,dateOfBirth,SocialMedia,ShareInfo,Newsletter.PreferedGenres
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

  /**
   * @test
   * @group register
   * ? Test 8
   * todo: Test Register gender is incorrect(must be Male, Female, Non-binary)
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_not_have_SocialMedia()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      // 'SocialMedia' => "NULL",
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
   * ? Test 9
   * todo: Test Register dateOfBirth is wrong syntax must bu "yyyy-mm-dd"
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_dateOfBirth_Wrong_Syntax()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "18-11-1999",
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
   * ? Test 10
   * todo: Test Register ShareInfo must be value 0 and 1
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_ShareInfo_Wrong_value()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "3",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 11
   * todo: Test Newletter must be value 0 and 1
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_Newsletter_Wrong_value()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "3",
      'PreferedGenres' => "Adventure, Adventure, Comedy",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 12
   * todo: Test  PreferedGenres Null
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_PreferedGenres_Null()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 13
   * todo: Test  PreferedGenres must have format: "xxx, yyy, zzz"
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_PreferedGenres_wrong_format_1()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "[xxx,yyy,zzz]",
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 14
   * todo: Test  PreferedGenres must have format: "xxx, yyy, zzz"
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_PreferedGenres_wrong_format_2()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "Adventure, Adventure, Comedy", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 15
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_have_account()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 16
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_16()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 17
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_17()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 18
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_18()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 19
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_19()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 20
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_20()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 21
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_21()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 22
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_22()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 23
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_23()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 24
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_24()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 25
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_25()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  /**
   * @test
   * @group register
   * ? Test 26
   * todo: Test Register but have account User in System
   * @param name,email,username,password,gender,dateOfBirth,ShareInfo,Newsletter.PreferedGenres
   * @return Status_422
   */
  public function Register_26()
  {
    $response = $this->postJson('/api/auth/register', [
      'name' => "TestByUnitTest",
      'username' => "TestByUnitTest",
      'email' => "TestByUnitTest@gmail.com",
      'password' => "password",
      'SocialMedia' => "NULL",
      'dateOfBirth' => "1999-18-11",
      'gender' => "Male",
      'ShareInfo' => "1",
      'Newsletter' => "1",
      'PreferedGenres' => "xxx,yyy,zzz", //must have space in every word
    ]);
    $response
      ->assertStatus(422);
  }
  //*************************PROFILE********************************/
  /**
   * @test
   * @group profile
   * ? Test 1
   * todo: Test Profile with token wrong
   * @param token
   * @return Status_401
   */
  public function Profile_Wrong_Token()
  {
    $response = $this->json('GET', '/api/auth/profile', ['token' => 'aaaaaa']);

    $response
      ->assertStatus(401);
  }
  /**
   * @test
   * @group profile
   * ? Test 2
   * todo: Test Profile with token wrong
   * @param token
   * @return Status_401
   */
  public function Profile_Wrong_Token_2()
  {
    $response = $this->json('GET', '/api/auth/profile', ['token' => 'aaaaaa']);

    $response
      ->assertStatus(401);
  }

  
  /**
   * @test
   * @group profile
   * ? Test 3
   * todo: Test Profile with token wrong
   * @param token
   * @return Status_401
   */
  public function Profile_Wrong_Token_3()
  {
    $response = $this->json('GET', '/api/auth/profile', ['token' => 'aaaaaa']);

    $response
      ->assertStatus(401);
  }

  
  


  //*************************LOGOUT********************************/
  /**
   * @test
   * @group logout
   * ? Test 1
   * todo: Test Logout with token wrong
   * @param token
   * @return Status_401
   */
  public function Logout_Wrong_Token()
  {
    $response = $this->json('GET', '/api/auth/logout', ['token' => 'aaaaaa']);
    $response
      ->assertStatus(401);
  }
   /**
   * @test
   * @group logout
   * ? Test 2
   * todo: Test Logout with token wrong
   * @param token
   * @return Status_401
   */
  public function Logout_Wrong_Token_2()
  {
    $response = $this->json('GET', '/api/auth/logout', ['token' => 'aaaaaa']);
    $response
      ->assertStatus(401);
  }
   /**
   * @test
   * @group logout
   * ? Test 3
   * todo: Test Logout with token wrong
   * @param token
   * @return Status_401
   */
  public function Logout_Wrong_Token_3()
  {
    $response = $this->json('GET', '/api/auth/logout', ['token' => 'aaaaaa']);
    $response
      ->assertStatus(401);
  }
   /**
   * @test
   * @group logout
   * ? Test 3
   * todo: Test Logout with token wrong
   * @param token
   * @return Status_401
   */
  public function Logout_Wrong_Token_4()
  {
    $response = $this->json('GET', '/api/auth/logout', ['token' => 'aaaaaa']);
    $response
      ->assertStatus(401);
  }
  
}
