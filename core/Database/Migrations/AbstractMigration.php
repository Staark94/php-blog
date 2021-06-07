<?php declare(strict_types=1);

namespace Core\Database\Migrations;
//namespace Core\Database\Migrations\Interfaces;

abstract class AbstractMigration {
    abstract public function up();
    abstract public function down();

    public function run() {
        return $this->up();
    }
}