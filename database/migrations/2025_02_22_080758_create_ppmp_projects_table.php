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
        Schema::create('ppmp_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('amount',15,2);
            $table->string('remarks');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('mode_of_procurement_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('app_project_id');
            $table->unsignedBigInteger('ppmp_id');            
            $table->timestamps();
            $table->foreign('status_id')->references('id')->on('ppmp_project_statuses')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ppmp_id')->references('id')->on('ppmps')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppmp_projects', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropForeign(['ppmp_id']);
        });

        Schema::dropIfExists('ppmp_projects');
    }
};