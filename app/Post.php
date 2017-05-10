<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /*Eloquent does not know which table to use for our model
    Eloquent will also assume that each table has
    - a primary key column named id.
    You may define a $primaryKey property to override this convention.
    Eloquent assumes that the primary key is an
    -incrementing integer value
    to use a non-incrementing or a non-numeric primary key you must
    -set the public $incrementing property on your model to false
    */
    protected $table = 'posts';
    protected $primaryKey = 'id';
    /*Eloquent
    need to specify either a fillable or guarded attribute on the model, as all Eloquent models protect against mass-assignment
    */
    //za create metodu
    protected $fillable = ['title', 'content'];
}
