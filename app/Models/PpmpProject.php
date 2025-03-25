<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpmpProject extends Model
{
    use HasFactory;

    protected $table = 'ppmp_projects';

    protected $fillable = [
        'title',
        'description',
        'amount',
        'remarks',
        'category_id',
        'mode_of_procurement_id',
        'status_id',
        'type_id',
        'app_project_id',
        'ppmp_id',
    ];

    // Relationship with PPMP
    public function ppmp()
    {
        return $this->belongsTo(PPMP::class, 'ppmp_id');
    }

    // Relationship with Category (Corrected to PpmpProjectCategory)
    public function category()
    {
        return $this->belongsTo(PpmpProjectCategory::class, 'category_id');
    }

    // Relationship with Mode of Procurement
    public function modeOfProcurement()
    {
        return $this->belongsTo(ModeOfProcurement::class, 'mode_of_procurement_id');
    }

    // Relationship with Status
    public function status()
    {
        return $this->belongsTo(PpmpProjectStatus::class, 'status_id');
    }

    // Relationship with App Project
    public function appProject()
    {
        return $this->belongsTo(AppProject::class, 'app_project_id');
    }

    // ✅ Renamed for consistency with Blade view
    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }
}
