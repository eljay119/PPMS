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
        'office_id',
        'source_of_fund_id', 
        'end_user', 
        'abc',
        'mode_of_procurement_id',
        'status_id',
        'type_id',
        'app_project_id',
        'ppmp_id',
    ];

    public function ppmp()
    {
        return $this->belongsTo(PPMP::class, 'ppmp_id');
    }

    public function category()
    {
        return $this->belongsTo(PpmpProjectCategory::class, 'category_id');
    }

    public function modeOfProcurement()
    {
        return $this->belongsTo(ModeOfProcurement::class, 'mode_of_procurement_id');
    }

    public function status()
    {
        return $this->belongsTo(PpmpProjectStatus::class, 'status_id');
    }

    public function appProject()
    {
        return $this->belongsTo(AppProject::class, 'app_project_id');
    }

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }
    
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
    
    public function sourceOfFund()
    {
        return $this->belongsTo(SourceOfFund::class, 'source_of_fund_id');
    }
    public function endUser()
    {
        return $this->belongsTo(User::class, 'end_user');
    }

}
