<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            CREATE TABLE `users` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `parent_id` int(10) unsigned DEFAULT NULL,
            `position_id` tinyint(10) unsigned DEFAULT NULL,
            `department_id` tinyint(10) unsigned DEFAULT NULL,
            `employee_id` int(10) unsigned DEFAULT NULL,
            `block_id` int(10) unsigned DEFAULT NULL,
            `role_id` int(10) unsigned DEFAULT NULL,
            `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `email` varchar(255) DEFAULT NULL,
            `facebook` varchar(255) DEFAULT NULL,
            `google` varchar(255) DEFAULT NULL,
            `status` tinyint(10) unsigned DEFAULT '0',
            `remember_token` varchar(200) DEFAULT NULL,
            `permissions` text COLLATE utf8mb4_unicode_ci,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
        ");
        DB::table('users')->insert(
            array(
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'status' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
