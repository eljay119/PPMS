<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceOfFund extends Model
{
    use HasFactory;

    protected $table = 'source_of_funds'; // Optional, as Laravel auto-detects

    protected $fillable = ['name', 'description'];
}
