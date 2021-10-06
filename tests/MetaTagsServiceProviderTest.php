<?php

namespace Turahe\Metatags\Tests;

/**
 * Class metatagsServiceProviderTest.
 */
class MetaTagsServiceProviderTest extends BaseTest
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
                'Turahe\Metatags\Contracts\MetaTags',
                'Turahe\Metatags\SEOMeta',
            ],
            [
                'Turahe\Metatags\Contracts\OpenGraph',
                'Turahe\Metatags\OpenGraph',
            ],
            [
                'Turahe\Metatags\Contracts\metatags',
                'Turahe\Metatags\metatags',
            ],
            [
                'Turahe\Metatags\Contracts\TwitterCards',
                'Turahe\Metatags\TwitterCards',
            ],
            [
                'Turahe\Metatags\Contracts\JsonLd',
                'Turahe\Metatags\JsonLd',
            ],
            [
                'Turahe\Metatags\Contracts\JsonLdMulti',
                'Turahe\Metatags\JsonLdMulti',
            ],
        ];
    }
}
