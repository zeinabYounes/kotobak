<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibrarianAction extends Model
{
    use HasFactory;
    protected $table = 'librarian_actions';
    public $timestamps = false;

    public function request()
    {
      return $this->belongsTo('App\Models\BookRequest','request_id');
    }
    public function librarian()
    {
      return $this->belongsTo('App\Models\User','user_id');///librarian_id
    }
}
