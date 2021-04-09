# Laravel API with JSON Web Token

Install Laravel 
1. Pull project. 
2. composer install. 
3. Create file .env and copy content file .env.example to .env. 
5. Run "php artisan key:generate".  
6. Run "php artisan jwt:secret".
7. Run "php artisan cache:clear".
8. Run "php artisan config:clear".
9. Run "php artisan serve" to start. 

###  API Auth: 

1. Login

    `/api/auth/login`: POST method. 

Required post parameters `email` and `password`  \
If you want to TEST add "Accept" in Key and "application/json" in Value in Header.

2. Register

    `/api/auth/register`: POST method.

Required post `request` parameters `name`, `email`, `password`,`email`,`dateOfBirth`,`gender`,`ShareInfo`. \
Parameters in `request` 
```php
      `username`     => 'required|string|between:2,100', 
      `name`         => 'required|string|between:2,100', 
      `email`        => 'required|email|unique:users',   //email must unique 
      `password`     => 'required|confirmed|min:6', 
      `SocialMedia`  => 'sometimes|string',    //If password null or undefined return value['null'] 
      `dateOfBirth`  => 'required|date', 
      `gender`       => 'required|string', 
      `urlAvatar`    => 'sometimes|string',    //If password null or undefined return value['null'] 
      `ShareInfo`    => 'required|numeric|min:0|max:1' //`ShareInfo` must have value[0,1] 
      'PreferedGenres' => 'required|string'    //String value like "Adventure, Adventure, Comedy"
```
3. Profile (Authenticated)
    `api/auth/profile?token=VALID_TOKEN`: GET method


4. To logout (Authenticated)

    `/api/auth/logout?token=VALID_TOKEN`: GET method

### API ShowMovie: 
    `/api/ShowMovie/{slug1}/{slug2?}/{slug3?}`: GET method

### API Genres:  
    `/api/ShowGenres/{slug1}/{slug2?}/{slug3?}?REQUEST`: GET method 
REQUEST: 
```php 
      `sort = value`  //with value=['A-to-Z','Z-to-A'] or undentify 
      `movienumber = Interger` //if undentify movienumber = 20 
      `page = Interger` //if undentify page = 1   
```      
     

###  API Collections:  
  `/api/ShowCollection/{slug1}/{slug2?}/{slug3?}?REQUEST`: GET method 
```php
      `sort = value`  //with value=['A-to-Z','Z-to-A'] or undentify 
      `movienumber = Interger` //if undentify movienumber = 20 
      `page = Interger` //if undentify page = 1 
```    
      
###  API Comment: 

1. showComments: \
    `/api/comment/showComments/{IdMovie}` : GET method 

2. addComment: \
    `/api/comment/addComment` : POST method  \
Required post `request` parameters `id`, `IdMovie`, `IdUser`,`IdParentUser`,`Body`,`dateUpdate` \
Parameters in `request` 
```php
        'IdMovie' => 'required|numeric',  
        'IdUser' => 'required|numeric',  
        'IdParentUser' => 'sometimes|numeric',  //If comment in root return `IdParentUser` = -1 
        'UserName' => 'required|string',        // It is name in User not username
        'Body' => 'required|string',  
        'dateUpdate' =>  'required|date'  
```

3. updateComment:  \
    `/api/comment/updateComment` : POST method  \
Required post `request` parameters `IdMovie`, `IdUser`,`IdParentUser`,`Body`,`dateCreate` \
Parameters in `request` 
```php
        'id' => 'required|numeric', 
        'IdMovie' => 'required|numeric', 
        'IdUser' => 'required|numeric', 
        'IdParentUser' => 'sometimes|numeric',  //If comment in root return `IdParentUser` = -1
        'UserName' => 'required|string',        // It is name in User not username
        'Body' => 'required|string', 
        'dateCreate' =>  'required|date' 
```

4. actionComment(Like,Dislike): \
    `/api/comment/action` : POST METHOD  \
Required post `request` parameters `IdComment`, `IdUser`,`Action`,`date` \
Parameters in `request`  
```php
        'IdComment' => 'required|numeric',
        'IdUser'    => 'required|numeric',
        'Action'    => 'required|numeric|min:-1|max:1',   //Like=1 ; Dislike=-1 ; Nothing = 0 
        'date'      => 'required|date'
```   

###  API Review:
1. showReviews: \
    `/api/comment/showReviews/{IdMovie}` : GET method 

