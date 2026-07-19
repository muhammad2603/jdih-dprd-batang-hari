<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublicComplaintsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type"              => 'BIGINT',
                "constraint"        => 20,
                "unsigned"          => true,
                "auto_increment"    => true
            ],

            "name" => [
                "type"          => 'VARCHAR',
                "constraint"    => 150
            ],

            "email" => [
                "type"          => 'VARCHAR',
                "constraint"    => 255
            ],

            "phone" => [
                "type"          => 'VARCHAR',
                "constraint"    => 15
            ],

            "subject" => [
                "type"          => 'VARCHAR',
                "constraint"    => 255
            ],

            "message" => [
                "type"          => 'TEXT'
            ],

            "status" => [
                "type"          => 'VARCHAR',
                "constraint"    => 255,
                "default"       => 'new'
            ],

            "ip_address" => [
                "type"          => 'VARCHAR',
                "constraint"    => 45,
                'null'          => true
            ],

            "user_agent" => [
                "type"          => 'TEXT',
                "null"          => true
            ],

            "created_at" => [
                "type"          => 'DATETIME',
                "null"          => true
            ],

            "updated_at" => [
                "type"          => 'DATETIME',
                "null"          => true
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status');
        $this->forge->addKey('created_at');
        $this->forge->createTable('public_complaints');
    }

    public function down()
    {
        $this->forge->dropTable('public_complaints');
    }
}
