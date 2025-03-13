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
        Schema::create('ppmps', function (Blueprint $table) {
            $table->id();
            $table->integer('fiscal_year')->unsigned();
            $table->unsignedBigInteger('source_of_fund_id');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices')
                  ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppmps');
    }
};
