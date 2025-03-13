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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('head_name')->nullable();
            $table->string('alternate_name')->nullable();
            $table->unsignedBigInteger('type_id')->nullable()->constrained('office_types');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('office_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void

    
    {
        {
            Schema::table('offices', function (Blueprint $table) {
                $table->string('head_name')->nullable(false)->change(); // Revert change
            });
        }

        Schema::dropIfExists('offices');
    }
};