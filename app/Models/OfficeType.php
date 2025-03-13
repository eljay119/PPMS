<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeType extends Model
{
    use HasFactory;

    protected $table = 'office_types'; // Optional, as Laravel auto-detects

    protected $fillable = ['type'];

    // Corrected relationship
    public function offices()
    {
        return $this->hasMany(Office::class); // Fixed: Changed from OfficeType::class to Office::class
    }
}
