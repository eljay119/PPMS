<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmpStatus extends Model
{
    use HasFactory;

    protected $table = 'ppmp_statuses'; // Optional, Laravel auto-detects

    protected $fillable = ['name'];

    // Define relationship with PPMP Projects
    public function ppmpProjects()
    {
        return $this->hasMany(PpmpProject::class, 'status_id');
    }
}
