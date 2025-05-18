<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->morphs('notifiable'); // adds notifiable_type (string) and notifiable_id (unsignedBigInteger)
            $table->text('data')->nullable();
            $table->timestamp('read_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropMorphs('notifiable');
            $table->dropColumn(['data', 'read_at']);
        });
    }
};
