<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands\Logs;

use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class ClearLogFileTest extends TestCase
{
    public function testHandleSuccessfulClearLogs(): void
    {
        Process::shouldReceive('run')
            ->once()
            ->with('echo "" > storage/logs/laravel.log && echo "" > storage/logs/cron.log')
            ->andReturn(new class {
                public function successful() { return true; }
                public function output() { return 'Logs cleared successfully.'; }
                public function errorOutput() { return ''; }
            });
        $this->artisan('logs:clear')
            ->expectsOutput('Logs cleared successfully.')
            ->assertExitCode(0);
    }

    public function testHandleFailedClearLogs(): void
    {
        Process::shouldReceive('run')
            ->once()
            ->with('echo "" > storage/logs/laravel.log && echo "" > storage/logs/cron.log')
            ->andReturn(new class {
                public function successful() { return false; }
                public function output() { return ''; }
                public function errorOutput() { return 'Failed to clear logs.'; }
            });
        $this->artisan('logs:clear')
            ->expectsOutput('Failed to clear logs.')
            ->assertExitCode(0);
    }
}
