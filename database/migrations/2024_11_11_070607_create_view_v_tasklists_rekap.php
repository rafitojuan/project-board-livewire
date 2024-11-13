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
            v_tasklists_rekap AS
        SELECT
            tl.id AS tasklists_id,
            tl.name AS tasklists_name,
            tl.work_id AS id_kontrak,
            COUNT(vtr.id_tasks) AS jlh_task,
            SUM(vtr.biaya_subtasks) AS total_biaya,
            sts.score AS progress,
            tl.pengadaan AS pengadaan,
            tl.company AS nama_perusahaan,
            tl.location AS lokasi_perusahaan,
            tl.value AS nilai_kontrak,
            MIN(tl.started_at) AS tgl_mulai_tasklist,
            MAX(tl.end_at) AS tgl_akhir_tasklist,
            MAX(tl.deleted_at) AS tgl_selesai_tasklist,
            sts.name AS status_tasklist,
            sts.color AS warna_status,
            tl.url AS link,
            usr.name AS name
        FROM tasklists tl
            LEFT JOIN tasklist_columns tc ON tl.id = tc.tasklist_id
            LEFT JOIN v_tasks_rekap vtr ON vtr.tasklist_column_id = tc.id
            LEFT JOIN users usr ON usr.id = tl.user_id
            LEFT JOIN statuses sts ON tl.status_id = sts.id
        GROUP BY
            tl.id,
            tl.name,
            tl.work_id,
            tl.pengadaan,
            tl.company,
            tl.location,
            tl.value,
            sts.score,
            sts.name,
            tl.url,
            usr.name
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_tasklists_rekap');
    }
};
