<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('app_project_status_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('app_project_status_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable(false)->change();
        });
    }
};
