<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppStatus extends Model
{
    use HasFactory;

    protected $table = 'app_statuses';

    protected $fillable = [
        'name',
        'description',
    ];
}
