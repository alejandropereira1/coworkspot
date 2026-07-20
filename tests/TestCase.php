<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Forzar la conexión a la base de datos de testing
        config(['database.default' => 'sqlite']);
        config(['database.connections.sqlite.database' => database_path('testing.sqlite')]);
    }
}