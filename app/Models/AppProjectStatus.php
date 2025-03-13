<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProjectStatus extends Model
{
    use HasFactory;

    protected $table = 'app_project_statuses';

    protected $fillable = ['name', 'description'];
}
