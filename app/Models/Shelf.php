<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $table = 'shelves';
    public function section()
    {
      return $this->belongsTo('App\Models\Section','section_id');
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }

}
