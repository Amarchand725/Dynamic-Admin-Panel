<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class FreshSeedDatabase extends Command
{
    protected $signature = 'db:fresh-seed';
    protected $description = 'Drop and recreate the database, then run seeders';

    public function handle()
    {
        $database = config('database.connections.mysql.database');
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        // Temporarily connect to 'mysql' without specifying a database
        config(['database.connections.mysql.database' => null]);
        DB::purge('mysql');
        DB::reconnect('mysql');

        // Drop database if exists
        DB::statement("DROP DATABASE IF EXISTS `$database`");
        $this->info("Dropped database `$database`");

        // Create database
        DB::statement("CREATE DATABASE `$database` CHARACTER SET $charset COLLATE $collation");
        $this->info("Created database `$database`");

        // Restore config
        config(['database.connections.mysql.database' => $database]);
        DB::purge('mysql');
        DB::reconnect('mysql');

        // Migrate and seed
        Artisan::call('migrate', ['--force' => true]);
        $this->info(Artisan::output());

        Artisan::call('db:seed', ['--force' => true]);
        $this->info(Artisan::output());
    }
}
