<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaderStatus extends Model
{
    use HasFactory;
    protected $table = 'reader_statuses';
    public $timestamps = false;
    public function user()
    {
      return $this->belongsTo('App\Models\User','user_id');
    }
}
