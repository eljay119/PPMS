<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class App extends Model
{
    use HasFactory;

    protected $table = 'apps';

    protected $fillable = [
        'fiscal_year',
        'version_name',
        'year',
        'status_id',
        'prepared_id',
    ];
    
    public function appProjects()
    {
        return $this->hasMany(AppProject::class);
    }

    public function appStatus()
    {
        return $this->belongsTo(AppStatus::class, 'status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'prepared_id');
    }
public function mergedProjects()
{
    return $this->hasMany(\App\Models\MergedProject::class, 'app_id');
}

}
