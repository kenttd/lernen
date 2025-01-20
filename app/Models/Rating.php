<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Rating extends Model {
    public $guarded = [];
    
    use HasFactory;

    public function author(): HasOne {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function profile()
    {
        return $this->hasOneThrough(Profile::class, User::class, 'id', 'user_id', 'student_id', 'id');
    }

    public function address(): MorphOne {
        return $this->morphOne(Address::class, 'addressable');
    }
}
