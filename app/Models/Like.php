<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function likeable(){

        return $this->morphTo();
    }

    public function post(){

        return $this->morphedByMany(Post::class , 'likeable');
    }
}
