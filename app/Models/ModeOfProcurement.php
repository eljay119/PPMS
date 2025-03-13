<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModeOfProcurement extends Model
{
    use HasFactory;

    protected $table = 'mode_of_procurements';

    protected $fillable = [
        'name',
        'section',
        'conditions',
        'threshold',
    ];
}
