<?php

namespace Turahe\SEOTools\Tests;

/**
 * Class SEOToolsServiceProviderTest.
 */
class SEOToolsServiceProviderTest extends BaseTest
{
    /**
     * Verify if classes are in service container.
     *
     * @dataProvider bindsListProvider
     *
     * @param string $contract
     * @param string $concreteClass
     */
    public function test_container_are_provided($contract, $concreteClass)
    {
        $this->assertInstanceOf(
            $contract,
            $this->app[$concreteClass]
        );
    }

    /**
     * @return array
     */
    public function bindsListProvider()
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
