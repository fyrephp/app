<?php
declare(strict_types=1);

namespace Tests\TestCase;

use Fyre\TestSuite\TestCase;
use Fyre\TestSuite\Traits\IntegrationTestTrait;

class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    public function testWelcomePage(): void
    {
        $this->get('/');

        $this->assertResponseOk();
        $this->assertResponseContains('Welcome to the future.');
    }
}
