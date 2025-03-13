<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class App extends Model
{
    //
    use HasFactory;

    protected $table = 'apps';

    protected $fillable = [
        'version_name',
        'year',
        'status_id',
        'prepared_id',
    ];

    public function appProjects()
    {
        return $this->hasMany(AppProject::class);
    }
}
