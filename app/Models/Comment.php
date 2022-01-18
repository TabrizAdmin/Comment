<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'text', 'mother_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'mother_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Comment', 'mother_id');
    }
}
