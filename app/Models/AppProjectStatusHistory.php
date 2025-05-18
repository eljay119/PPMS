<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppProjectStatusHistory extends Model
{
    protected $fillable = ['app_project_id', 'status_id', 'remarks', 'user_id', 'updated_by'];

    public function appProject()
    {
        return $this->belongsTo(AppProject::class, 'app_project_id');
    }

    public function status()
    {
        return $this->belongsTo(AppProjectStatus::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
