<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Department extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared("
        CREATE TABLE `departments` (
          `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
          `lang` CHAR(10) NULL DEFAULT 'vi',
          `parent_id` INT(10) UNSIGNED NULL,
          `title` VARCHAR(100) NOT NULL,
          `status` tinyint(2) DEFAULT '1',
          `created_by` INT(5) UNSIGNED NULL,
          `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
          `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
  }
