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
            // Existing foreign keys
            $table->foreign('category_id')->references('id')->on('ppmp_project_categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mode_of_procurement_id')->references('id')->on('mode_of_procurements')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('project_types')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('app_project_id')->references('id')->on('app_projects')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppmp_projects', function (Blueprint $table) {
            // Drop the foreign key for PPMP reference
            $table->dropForeign(['ppmp_id']);

            // Drop existing foreign keys
            $table->dropForeign(['category_id', 'mode_of_procurement_id', 'type_id', 'app_project_id']);
        });
    }
};
