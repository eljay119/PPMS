<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ppmps', function (Blueprint $table) {
            $table->unsignedBigInteger('fund_source_id')->after('fiscal_year');
            $table->unsignedBigInteger('status_id')->after('fund_source_id');

            // If you want to add foreign key constraints
            $table->foreign('fund_source_id')->references('id')->on('source_of_funds')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('ppmp_statuses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('ppmps', function (Blueprint $table) {
            $table->dropForeign(['fund_source_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn(['fund_source_id', 'status_id']);
        });
    }
};
