<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Personas extends Migration
{
    public function up()
    {
        $this->forge->addField(array(
            "id" => array(
                "type" => "INT",
                "constraint" => 9,
                "unsigned" => true,
                "auto_increment" => true
            ),
            "mtime" => array(
                "type" => "datetime"
            ),
            "nombre" => array(
                "type" => "VARCHAR",
                "constraint" => 32
            ),
            "color" => array(
                "type" => "VARCHAR",
                "constraint" => 6
            ),
            "fondo" => array(
                "type" => "VARCHAR",
                "constraint" => 6
            )
        ));
            
        $this->forge->addKey('id', true);
        $this->forge->createTable('categorias');
    }

    public function down()
    {
        $this->forge->dropTable('categorias');
    }
}