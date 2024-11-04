<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    public $timestamps = false;

    public function section()
    {
      return $this->belongsTo('App\Models\Section','section_id');
    }
    public function shelf()
    {
      return $this->belongsTo('App\Models\Shelf','shelf_id');
    }
    public function copies()
    {
        return $this->hasMany('App\Models\Copy');
    }
    public function requests()
    {
        return $this->hasMany('App\Models\BookRequest');
    }

}
