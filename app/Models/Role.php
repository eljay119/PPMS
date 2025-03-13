<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    //
    use HasFactory;

    // Specify the table name (optional if it's the plural form of the model name)
    protected $table = 'roles';

    // Specify the fillable fields if you want to mass assign them
    protected $fillable = ['name','description'];

    // Define relationships if any
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

}
