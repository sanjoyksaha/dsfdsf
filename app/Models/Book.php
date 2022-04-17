<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'details', 'status'];

    public function path()
    {
        return '/updatebook/'.$this->id;
    }
}
