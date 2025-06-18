<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    // Разрешенные для массового заполнения поля
    protected $fillable = ['name', 'url'];
}
