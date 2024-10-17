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
        Schema::table('subtasks', function (Blueprint $table) {
            $table->string('pelaksana')->nullable();
            $table->integer('biaya')->nullable();
            $table->string('keterangan')->default('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subtasks', function (Blueprint $table) {
            $table->dropColumn('pelaksana');
            $table->dropColumn('biaya');
            $table->dropColumn('keterangan');
        });
    }
};
