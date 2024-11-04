<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedCopy extends Model
{
    use HasFactory;
    protected $table = 'borrowed_copies';

    public function book()
    {
      return $this->belongsTo('App\Models\Book','book_id');
    }
    public function reader()
    {
      return $this->belongsTo('App\Models\User','user_id');
    }

}
