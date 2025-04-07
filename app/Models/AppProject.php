<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppProject extends Model
{
    use HasFactory;

    protected $table = 'app_projects';

    protected $fillable = [
        'title',
        'description',
        'abc',
        'quarter',
        'mode_id',
        'app_id',
        'ppmp_project_id',
        'category_id',
        'status_id',
        'remarks',        
        'fund_id',
        'end_user_id',
        'office_id',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function category()
    {
        return $this->belongsTo(PpmpProjectCategory::class, 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(AppProjectStatus::class, 'status_id');
    }

    public function sourceOfFund()
    {
        return $this->belongsTo(SourceOfFund::class, 'fund_id');
    }
    
    public function endUser()
    {
        return $this->belongsTo(User::class, 'end_user_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
    
    public function modeOfProcurement()
    {
        return $this->belongsTo(ModeOfProcurement::class, 'mode_id');
    }
    public function ppmp()
    {
        return $this->belongsTo(PPMP::class, 'ppmp_id');
    }
    public function ppmpProject()
    {
        return $this->belongsTo(PpmpProject::class, 'ppmp_project_id');
    }

}
