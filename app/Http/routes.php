<?php
use App\Post;
use Illuminate\Routing\Route;

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

/*
|--------------------------------------------------------------------------
| Raw SQL
|--------------------------------------------------------------------------
Queries are using the DB facade.
DB facade provides methods for each type of query: select, update, insert, delete, and statement
*/


Route::get('/insert', function(){
    //upitnici su PDO placeholderi jer: parameter bindings that need to be bound to the query
    //$users = DB::select('select * from users where active = ?', [1]);
    //$results = DB::select('select * from users where id = :id', ['id' => 1]);
    //DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);

   DB::insert('insert into posts(title, content) values(?, ?)',['PHP with Laravel is awesome','Laravel is the shit']);

});

Route::get('/read', function(){
    $result = DB::select('select * from posts where id = ?', [1]);

  foreach ($result as $post){
       return $post->title;
    }
    //alternativan način -> vraća direktan view
    //return view('read',['result' => $result]);
});

Route::get('/update', function() {
    //$affected = DB::update('update users set votes = 100 where name = ?', ['John']);
    //update vraća broj tj. zahavećni red "affected row"
    $update = DB::update('update posts set title = "Update title" where id=?', [1]);
    return $update;
});

Route::get('/delete', function() {
   //$deleted = DB::delete('delete from users');
    //vraća broj obrisanih redaka
    $delete = DB::delete('delete from posts where id=?', [1]);
    return $delete;
});

/*
|--------------------------------------------------------------------------
| ELEOQUENT ORM
|--------------------------------------------------------------------------
Queries are using the DB facade.
DB facade provides methods for each type of query: select, update, insert, delete, and statement
*/

Route::get('/find', function(){
    $posts = Post::all();
    foreach ($posts as $post){
        return $post->title;
    }
});

/*
pomoću ugrađene find metode
Route::get('/find', function(){
    $post = Post::find(2);
//    foreach ($posts as $post){
//        return $post->title;
//    }
    return $post->title;
});
*/

//traženje pomoću constrains

Route::get('/findwhere', function(){
    //pronađi stupac id s vrijdnošću 2(where), svrstaj id prema dolje(orderBy), uzmi jedan(take), vrati rezultat(get)
    $posts = Post::where('id',2)->orderBy('id', 'desc')->take(1)->get();

    return $posts;

});

//pronalaženje podataka u tablici

Route::get('/findmore', function(){
/*
    //izbaci exception ako ne nađe parametar
    $posts = Post::findOrFail(2);
    return $posts;
*/

    //pretražuje korisnike i ako ih je manje od 50 ispisuje prvog
    $result = Post::where('users_count', '<', 50)->firstOrFail();
    return $result;
});

//unosi nove podatke u tablicu

Route::get('/insertelo', function(){

    //insanciramo objekt klase Post
    //sada preko varijable $post možemo obavljati operacije
    $post = new Post;

    $post->title = 'New Eloquent title insert';
    $post->content = 'Wow Eloquent is really cool';
    $post->save(); //inserta podatke

});

//mijenja(update) podatke u tablici - nije prigodno za forme,...create metoda je bolja

Route::get('/updateelo' ,function(){

    $post = Post::find(2);

    $post->title ='New Eloquent title insert 2';
    $post->content ='Wow Eloquent is really cool updejt 2';
    $post->save();

});

//pravi noci redak s informacijama - koristi se za masivno unošenje podataka za razliku od inserta

Route::get('/createelo', function(){
    //protected $fillable = ['name'];
    //$flight = App\Flight::create(['name' => 'Flight 10']);
    Post::create(['title'=>'the create method', 'content'=>'Really tired']);

});

//invoka se slično kao i create

Route::get('/updateelo', function(){

    Post::where('id',2)->where('is_admin',0)->update(['title' => 'New PHP', 'content' => 'Novi shit']);

});