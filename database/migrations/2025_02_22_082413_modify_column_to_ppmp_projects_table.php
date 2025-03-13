<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ppmp_projects', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('app_project_id')->nullable()->change();
            $table->string('remarks')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppmp_projects', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('app_project_id')->nullable(false)->change();
            $table->string('remarks')->nullable(false)->change();
            $table->string('description')->nullable(false)->change();
        });
    }
};
