<?php

namespace Turahe\SEOTools\Tests;

use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Class SEOToolsServiceProviderTest.
 */
class SEOToolsServiceProviderTest extends BaseTest
{
    /**
     * Verify if classes are in service container.
     */
    #[DataProvider('bindsListProvider')]
    public function test_container_are_provided(string $contract, string $concreteClass)
    {
        $this->assertInstanceOf(
            $contract,
            $this->app[$concreteClass]
        );
    }

    public static function bindsListProvider(): array
    {
        return [
            [
                'Turahe\SEOTools\Contracts\Meta',
                'Turahe\SEOTools\Meta',
            ],
            [
                'Turahe\SEOTools\Contracts\OpenGraph',
                'Turahe\SEOTools\OpenGraph',
            ],
            [
                'Turahe\SEOTools\Contracts\Tools',
                'Turahe\SEOTools\Tools',
            ],
            [
                'Turahe\SEOTools\Contracts\TwitterCards',
                'Turahe\SEOTools\TwitterCards',
            ],
            [
                'Turahe\SEOTools\Contracts\JsonLd',
                'Turahe\SEOTools\JsonLd',
            ],
            [
                'Turahe\SEOTools\Contracts\JsonLdMulti',
                'Turahe\SEOTools\JsonLdMulti',
            ],
        ];
    }
}
