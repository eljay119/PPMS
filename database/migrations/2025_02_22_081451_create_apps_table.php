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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('version_name');
            $table->integer('year');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('prepared_id');
            $table->timestamps();
            $table->foreign('prepared_id')->references('id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apps', function (Blueprint $table) {
            $table->dropForeign(['prepared_id']);
        });

        Schema::dropIfExists('apps');
    }
};
