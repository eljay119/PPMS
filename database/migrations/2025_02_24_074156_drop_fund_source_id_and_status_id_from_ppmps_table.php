<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ppmps', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['fund_source_id']);
            $table->dropForeign(['status_id']);

            // Now drop the columns
            $table->dropColumn(['fund_source_id', 'status_id']);
        });
    }

    public function down()
    {
        Schema::table('ppmps', function (Blueprint $table) {
            // Recreate the columns
            $table->unsignedBigInteger('fund_source_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();

            // Recreate the foreign key constraints
            $table->foreign('fund_source_id')->references('id')->on('source_of_funds')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }
};
