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
            v_tugas_user AS
        SELECT
            `tl`.`id` AS `id_projek`,
            `tl`.`name` AS `nama_projek_aktif`,
            json_arrayagg(
                json_object(
                    'nama_kegiatan',
                    `t`.`name`,
                    'subtasks',(
                    SELECT
                        json_arrayagg(
                        json_object(
                            'nama_tugas', `st`.`name`,
                            'pelaksana_id', `usr`.`id`,
                            'pelaksana_nama', `usr`.`name`
                        ))
                    FROM
                        (
                            `subtasks` `st`
                            LEFT JOIN `users` `usr` ON ((
                                    `usr`.`id` = `st`.`pelaksana`
                                )))
                    WHERE
                    ( `st`.`task_id` = `t`.`id` )))) AS `kegiatan_list`
        FROM
            ((
                    `tasklists` `tl`
                    LEFT JOIN `tasklist_columns` `tc` ON ((
                            `tl`.`id` = `tc`.`tasklist_id`
                        )))
                LEFT JOIN `tasks` `t` ON ((
                        `t`.`tasklist_column_id` = `tc`.`id`
                    )))
        WHERE
            ( `tl`.`deleted_at` IS NULL )
        GROUP BY
            `tl`.`id`,
            `tl`.`name`
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS v_tugas_user');
    }
};
