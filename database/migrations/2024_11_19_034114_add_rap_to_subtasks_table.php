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
            $table->decimal('rab', 15, 2)->nullable()->after('completed');
            $table->decimal('rap', 15, 2)->nullable()->after('rab');
            $table->decimal('rapp', 15, 2)->nullable()->after('rap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subtasks', function (Blueprint $table) {
            $table->dropColumn('rab');
            $table->dropColumn('rap');
            $table->dropColumn('rapp');
        });
    }
};
