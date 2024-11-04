<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections';

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }

}
