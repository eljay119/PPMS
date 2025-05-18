<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpmpFile extends Model
{
    public function ppmp()
    {
        return $this->belongsTo(PPMP::class, 'ppmp_id');
    }

}
