<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*VAŽNO
1)ovo je u višim verzijama Laravela maknuto u routes/ folder podijeljen u dva fajla api.php i web.php
2)web.php sadrži routes s middlewareom i csrf-om
*
*/

//'/' predstavlja korisnički definiranu rutu do view-a 'welcome' (http://localhost/cms_admin/public)
//promjenom u '/example' i dalje dolazimo do 'welcome' view-a (http://localhost/cms_admin/public/example)

/* Jednostavni primjeri
Route::get('/', function () {
    return view("welcome");

});

Route::get('/about', function () {
    return "Hi about page!";

});

Route::get('/contact', function () {
    return "Hi, I'm contact!";
});


//ruta do određenog posta - pr. 1 (http://localhost/cms_admin/public/post/1/marko)
//unutar {} možemo staviti bilo koje ime za varijablu
//da bi dohvatili varijablu moramo je staviti u function()

Route::get('/post/{id}/{name}', function($id,$name){
    //u pregledniku ispisuje prosljeđenu vrijednost u url-u  za $id i $name
    return "This is post number: " . $id . " " . $name;
});

//primjer cusotm url-a s porukom
//http://localhost/cms_admin/public/admin/posts

Route::get('/admin/posts', function () {
    return "Admin is here :D";

});

//možemo skratiti url (/admin/post/example) stavljajući ga u associative array
Route::get('admin/posts/example', array('as' => 'admin.home', function(){

    $url = route('admin.home');
    return "this url is: " . $url;

}));
*/

/*RESURSI -> php artisan route:list
 * 1)sve između ' ' puput 'res' je url
 * 2)napravili smo automatski url parametre za 'res'
 * 3)napravili smo automatski url metode za 'res'
 * 4)napravili smo automatski namespace za 'res'
 */

//pozivanje kontrolera - 'ImeKontrolera@njegovaMetoda'
Route::get('/info/{id}','PostsController@index');

//http://localhost:8000/res/1
Route::resource('res','PostsController'); //This is the show method with id parameter: 1

//prosljeđivanje with metodom
//http://localhost:8000/contact/ada
//http://localhost:8000/contact/3/marko/123 - za compact
Route::get('/contact', 'PostsController@contact');

//prikaz ktoz array-a
Route::get('/admin',function (){
    return view('admin', ['id' => 'Prvi']);
});
//http://localhost:8000/posts/3/2/123
Route::get('/posts/{id}/{name}/{password}', 'PostsController@posts');

