<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder {
    public function run() {
        $roles = ['Admin', 'Head', 'Bac Sec', 'Budget Officer', 'Campus Director'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
