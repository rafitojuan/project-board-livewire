<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW
            v_dashboard_rekap AS
        SELECT
            COUNT(CASE WHEN (vtr.tgl_selesai_tasklist IS NULL)
                THEN vtr.tasklists_id END) AS jlh_tasklists_aktif,
            COUNT(CASE WHEN (vtr.tgl_selesai_tasklist IS NOT NULL)
                THEN vtr.tasklists_id END) AS jlh_tasklists_nonaktif,
            COUNT(vtr.tasklists_id) AS jlh_seluruh_nonaktif,
            SUM(vtr.total_biaya) AS total_keseluruhan_biaya,
            SUM(vtr.nilai_kontrak) AS total_nilai,
            SUM(CASE WHEN (vtr.id_kolom_tasklists = 3)
                THEN 1 ELSE 0 END) AS jlh_tasklists_selesai
        FROM
            v_tasklists_rekap vtr
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_dashboard_rekap');
    }
};
