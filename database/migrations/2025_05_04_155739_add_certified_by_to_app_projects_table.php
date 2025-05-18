<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('certified_by')->nullable()->after('certified_at');
            $table->foreign('certified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('app_projects', function (Blueprint $table) {
            $table->dropForeign(['certified_by']);
            $table->dropColumn('certified_by');
        });
    }
};
