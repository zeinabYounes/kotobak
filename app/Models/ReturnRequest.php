<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;
    protected $table = 'return_request';

    public function book()
    {
      return $this->belongsTo('App\Models\Book','book_id');
    }
    public function reader()
    {
      return $this->belongsTo('App\Models\User','user_id');///reader
    }

}
