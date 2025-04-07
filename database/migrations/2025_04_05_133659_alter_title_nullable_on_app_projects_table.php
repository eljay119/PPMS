<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change(); // or adjust as needed
        });
    }
    
};
