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
        'category_id',
        'status_id',
        'fund_id',
        'end_user_id',
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

    public function fund()
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

    public function sourceOfFund()
    {
        return $this->belongsTo(SourceOfFund::class);
    }

    public function modeOfProcurement()
    {
        return $this->belongsTo(ModeOfProcurement::class);
    }
}
