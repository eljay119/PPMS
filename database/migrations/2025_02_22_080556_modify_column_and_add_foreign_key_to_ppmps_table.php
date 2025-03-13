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
        Schema::table('ppmps', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('ppmp_status_id');
            $table->foreign('ppmp_status_id')->references('id')->on('ppmp_statuses')
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppmps', function (Blueprint $table) {
            //
            $table->dropColumn(['ppmp_status_id']);
            $table->dropForeign(['ppmp_status_id']);

        });
    }
};
