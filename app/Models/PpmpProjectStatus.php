<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmpProjectStatus extends Model
{
    use HasFactory;

    protected $table = 'ppmp_project_statuses'; 
    
    protected $fillable = ['status', 'description'];

    // Relationship with PPMP Projects
    public function ppmpProjects()
    {
        return $this->hasMany(PpmpProject::class, 'status_id');
    }
}
