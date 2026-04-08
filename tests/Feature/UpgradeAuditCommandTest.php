<?php

namespace Tests\Feature;

use Tests\TestCase;

class UpgradeAuditCommandTest extends TestCase
{
    /** @test */
    public function it_lists_legacy_dependencies_for_modernization()
    {
        $this->artisan('system:upgrade-audit')
            ->expectsOutput('Inventário de modernização gerado com sucesso.')
            ->expectsOutputToContain('laravel/framework')
            ->expectsOutputToContain('laravel-mix')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_output_findings_as_json()
    {
        $this->artisan('system:upgrade-audit --json')
            ->expectsOutputToContain('"pacote": "laravel/framework"')
            ->expectsOutputToContain('"pacote": "laravel-mix"')
            ->assertExitCode(0);
    }
}
