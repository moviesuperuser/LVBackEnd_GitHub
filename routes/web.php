<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', function (Request $request) {
    
  $filename = $request->file("thing")->store("1jF_4AYVCqrSduKWyoC1kG7-JAKwKsFEn","google") ;
  dump($filename);
  $googleDriveStorage = Storage::disk('google');
  $dir = '/';
  $recursive = true; // Get subdirectories also?
  $file = collect(Storage::disk('google')->listContents($dir, $recursive))
      ->where('type', '=', 'file')
      ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
      ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
      ->sortBy('timestamp')
      ->last();
  dump("FILE NAME : ");
  dump($file);
  dump('_____________________________');
  dump(Storage::Disk('google')->url($file['path']));
  #echo '<img src='.$link .' alt="Girl in a jacket">';
  $file_id = $file['basename'];
  $link = 'https://drive.google.com/file/d/'.$file_id .'/preview';
  #echo '<iframe frameborder="0" width="640" height="480" src="'.$link1.'" ; allowfullscreen="true" allow="autoplay"></iframe>';
  echo '<iframe frameborder="0" width="640" height="480" src="'.$link.'" ; allowfullscreen="true" allow="autoplay"></iframe>';

});


Route::get('newest', function() {
  $filename = 'test.txt';

  Storage::disk('google')->put($filename, \Carbon\Carbon::now()->toDateTimeString());

  $dir = '/';
  $recursive = false; // Get subdirectories also?
  $file = collect(Storage::disk('google')->listContents($dir, $recursive))
      ->where('type', '=', 'file')
      ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
      ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
      ->sortBy('timestamp')
      ->last();
      dump(Storage::Disk('google')->url($file['path']));
});