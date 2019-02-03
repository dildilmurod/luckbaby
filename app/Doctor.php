<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    public static $rules = array(
        // required and has to match the password field
    );
    protected $fillable = [
        '',
    ];

    protected $table = 'doctors';

    public $primaryKey = 'id';

    public $timestamps = true;

//    public function author(){
//        return $this->belongsTo('App\Author');
//    }
//
//    public function genres(){
//        return $this->belongsToMany('App\Genre', 'book_genre', 'book_id', 'genre_id');
//    }
}
