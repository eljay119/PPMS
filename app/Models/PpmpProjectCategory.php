<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmpProjectCategory extends Model
{
    use HasFactory;

    protected $table = 'ppmp_project_categories'; 

    protected $fillable = ['name', 'description'];
}
