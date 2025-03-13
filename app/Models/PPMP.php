<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPMP extends Model
{
    protected $table = 'ppmps';
    
    protected $fillable = ['fiscal_year', 'source_of_fund_id', 'ppmp_status_id', 'office_id', 'type_id'];

    public function sourceofFund()
    {
        return $this->belongsTo(SourceOfFund::class, 'source_of_fund_id');
    }

    public function ppmpStatus()
    {
        return $this->belongsTo(PpmpStatus::class, 'ppmp_status_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function projects()
    {
        return $this->hasMany(PpmpProject::class, 'ppmp_id');
    }

    public function ppmpProjects()
    {
        return $this->hasMany(PpmpProject::class, 'ppmp_id');
    }

    public function ppmpProjectStatus()
    {
        return $this->belongsTo(PpmpProjectStatus::class, 'ppmp_project_status_id');
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }

}