<?php

declare(strict_types=1);

namespace Tests\Lib;

use App\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

/**
 * Trait RefreshDatabaseLite
 * @see https://wand-ta.hatenablog.com/entry/2019/12/15/185625
 * @package Tests\Lib
 */
trait RefreshDatabaseLite
{
    use RefreshDatabase;

    /**
     * Refresh a conventional test database.
     *
     * @return void
     */
    protected function refreshTestDatabase()
    {
        if (! RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:refresh --seed');

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}
