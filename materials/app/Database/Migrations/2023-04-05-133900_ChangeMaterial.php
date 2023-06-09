<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Changes the created_at column to published_at.
 * Created_at was never used, but published_at is important.
 *
 * @author Jan Martinek
 */
class ChangeMaterial extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('materials', [
            'created_at' => [
                'name' => 'published_at',
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->db->table('materials')
                 ->where('published_at', null)
                 ->update(['published_at' => date('Y-m-d H:i:s', 0)]);

        $this->forge->modifyColumn('materials', [
            'published_at' => [
                'name' => 'created_at',
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
    }
}