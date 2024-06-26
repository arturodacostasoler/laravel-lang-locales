<?php

/**
 * This file is part of the "laravel-lang/locales" project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Andrey Helldar <helldar@dragon-code.pro>
 * @copyright 2024 Laravel Lang Team
 * @license MIT
 *
 * @see https://laravel-lang.com
 */

declare(strict_types=1);

namespace Tests;

use DragonCode\Support\Facades\Filesystem\Directory;
use LaravelLang\Config\ServiceProvider as ConfigServiceProvider;
use LaravelLang\Locales\ServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            ConfigServiceProvider::class,
        ];
    }

    protected function cleanUp(): void
    {
        Directory::ensureDelete(lang_path());
        Directory::ensureDirectory(lang_path());
    }
}
