<?php

namespace App;

use CloudConvert\Api;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public static $rules = array(
        // required and has to match the password field
    );
    protected $fillable = [
        'file', 'patient_id', 'name', 'surname'
    ];

    protected $table = 'records';

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
