<?php declare(strict_types=1);

include dirname(__DIR__) . '/config/config.php';
include CORE_PATH . 'Database/Migrations/AbstractMigration.php';
include CORE_PATH . 'Database/Migrations/Schema.php';
include CORE_PATH . 'Database/Migrations/Blueprint.php';

use Core\Database\Migrations\AbstractMigration;
use Core\Database\Migrations\Schema;
use Core\Database\Migrations\Blueprint;

class m0001_initial extends AbstractMigration {
    public function up() {
        Schema::create('tags', function(Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    public function down() {
        Schema::drop('tags');
    }
}

$run = new m0001_initial();

var_dump($run->up());

Blueprint::initial('run', ['id' => 1, 'name' => 'Admin']);