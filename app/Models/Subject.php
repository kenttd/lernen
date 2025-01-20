<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model {
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    public $fillable  = [
        'id', 'name', 'description', 'status', 'deleted_at'
    ];

    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }
}
