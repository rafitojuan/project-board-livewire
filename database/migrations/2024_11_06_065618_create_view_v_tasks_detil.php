<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW
            v_tasks_detil AS
        SELECT
            a.task_id AS id_tasks,
            b.name AS nama_tasks,
            a.id AS id_subtasks,
            a.name AS nama_subtasks,
            a.pelaksana AS pelaksana,
            a.biaya AS biaya,
            a.started_at AS tgl_mulai_subtasks,
            a.end_at AS tgl_akhir_subtasks,
            a.keterangan AS keterangan,
            a.status_id AS status_subtasks,
            c.score AS score_status,
            c.name AS nama_status,
            c.color AS warna_status
        FROM subtasks a
        LEFT JOIN tasks b ON a.task_id = b.id
        LEFT JOIN statuses c ON a.status_id = c.id
        WHERE a.status_id <> '9'
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_tasks_detil');
    }
};
