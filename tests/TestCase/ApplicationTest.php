<?php
declare(strict_types=1);

namespace Tests\TestCase;

use Fyre\Http\Exceptions\NotFoundException;
use Fyre\TestSuite\TestCase;
use Fyre\TestSuite\Traits\IntegrationTestTrait;

class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    public function testMissingPageException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessageIs('No route found for the path `/missing`.');

        $this->disableErrorRendering();

        $this->get('/missing');
    }

    public function testMissingPageResponse(): void
    {
        $this->get('/missing');

        $this->assertResponseCode(404);
    }

    public function testWelcomePage(): void
    {
        $this->get('/');

        $this->assertResponseOk();
        $this->assertResponseContains('Welcome to the future.');
    }
}
