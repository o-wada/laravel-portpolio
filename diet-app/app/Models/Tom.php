<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $rules = [
        'image' => 'image|file'
    ];
}
