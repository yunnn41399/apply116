<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateApplicationCartTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'application_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'department_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        // 同一份報名資料不能重複加入同一個校系
        $this->forge->addUniqueKey([
            'application_id',
            'department_id',
        ]);
        $this->forge->createTable(
            'application_cart'
        );
    }
    public function down()
    {
        $this->forge->dropTable(
            'application_cart'
        );
    }
}
