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
            v_dashboard_rekap_user AS
        SELECT
            usr.id AS id_pelaksana,
            usr.name AS nama_pelaksana,
            COUNT(DISTINCT tl.id) AS jlh_tasklists_user_aktif,
            COUNT(DISTINCT CASE WHEN tl.column_id = 1 THEN tl.id END) AS jlh_tasklists_potential_user,
            COUNT(DISTINCT CASE WHEN tl.column_id = 2 THEN tl.id END) AS jlh_tasklists_onprogress_user,
            COUNT(DISTINCT CASE WHEN tl.column_id = 3 THEN tl.id END) AS jlh_tasklists_completed_user,
            COUNT(DISTINCT t.id) AS jlh_tasks_user_aktif,
            COUNT(DISTINCT st.id) AS jlh_subtasks_user_aktif
        FROM
            users AS usr
            LEFT JOIN subtasks AS st ON usr.id = st.pelaksana
            LEFT JOIN tasks AS t ON st.task_id = t.id
            LEFT JOIN tasklist_columns AS tc ON t.tasklist_column_id = tc.id
            LEFT JOIN tasklists AS tl ON tc.tasklist_id = tl.id
        WHERE
            tl.deleted_at IS NULL
        GROUP BY
            usr.id,
            usr.name
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_dashboard_rekap_user');
    }
};
