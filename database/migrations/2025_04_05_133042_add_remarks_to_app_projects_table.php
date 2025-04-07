<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->string('remarks')->nullable()->after('end_user_id');
        });
    }

    public function down()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }

};
