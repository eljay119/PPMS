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
        Schema::create('app_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('abc',15,2);
            $table->integer('quarter');
            $table->unsignedBigInteger('mode_id');
            $table->unsignedBigInteger('app_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('fund_id');
            $table->unsignedBigInteger('end_user_id');
            $table->foreign('app_id')->references('id')->on('apps')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('ppmp_project_categories')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('app_project_statuses')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fund_id')->references('id')->on('source_of_funds')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('end_user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('app_projects', function (Blueprint $table) {
        $table->dropForeign(['status_id']);
        $table->dropForeign(['app_id']);
        $table->dropForeign(['category_id']);
        $table->dropForeign(['fund_id']);
        $table->dropForeign(['end_user_id']);
    });

    Schema::dropIfExists('app_projects');
}

};
