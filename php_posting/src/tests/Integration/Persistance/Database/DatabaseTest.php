<?php


namespace Tests\Integration\Persistance\Database;


use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabase()
    {
        $db = pg_connect("host=sheep port=5432 dbname=mary user=lamb password=foo");
    }
}