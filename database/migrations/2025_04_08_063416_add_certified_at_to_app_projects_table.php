<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->timestamp('certified_at')->nullable()->after('status_id');
        });
    }
    
    public function down()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->dropColumn('certified_at');
        });
    }
};
