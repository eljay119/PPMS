<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('ppmp_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('office_id')->nullable()->after('category_id');
            $table->unsignedBigInteger('source_of_fund_id')->nullable()->after('office_id');
            $table->decimal('abc', 15, 2)->nullable()->after('source_of_fund_id');
            $table->string('end_user')->nullable()->after('abc');

            // Foreign keys
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('set null');
            $table->foreign('source_of_fund_id')->references('id')->on('source_of_funds')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('ppmp_projects', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropForeign(['source_of_fund_id']);
            $table->dropColumn(['office_id', 'source_of_fund_id', 'abc', 'end_user']);
        });
    }
};

