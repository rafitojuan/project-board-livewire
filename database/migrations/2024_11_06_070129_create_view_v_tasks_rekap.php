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
            v_tasks_rekap AS
        SELECT
            b.tasklist_column_id AS tasklist_column_id,
            a.id_tasks AS id_tasks,
            a.nama_tasks AS nama_tasks,
            COUNT(a.id_subtasks) AS jlh_subtasks,
            ROUND((SUM(a.score_status) / COUNT(a.id_subtasks)), 0) AS jlh_score,
            SUM(a.biaya) AS biaya_subtasks,
            MIN(a.tgl_mulai_subtasks) AS tgl_mulai_subtasks,
            MAX(a.tgl_akhir_subtasks) AS tgl_akhir_subtasks,
            b.status_id AS status_tasks,
            c.name AS nama_status,
	        c.color AS warna_status,
            d.id AS id_user,
            d.name AS nama_user
        FROM v_tasks_detil a
        LEFT JOIN tasks b ON a.id_tasks = b.id
        LEFT JOIN statuses c ON b.status_id = c.id
        LEFT JOIN users d ON b.user_id = d.id
        GROUP BY a.id_tasks
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_tasks_rekap');
    }
};
