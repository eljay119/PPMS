<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('project_type_id')->nullable()->after('status_id');
            $table->foreign('project_type_id')->references('id')->on('project_types')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->dropForeign(['project_type_id']);
            $table->dropColumn('project_type_id');
        });
    }
};
