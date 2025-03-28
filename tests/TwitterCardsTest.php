<?php

namespace Turahe\SEOTools\Tests;

use Turahe\SEOTools\TwitterCards;

/**
 * Class TwitterCardsTest.
 */
class TwitterCardsTest extends BaseTest
{
    /**
     * @var TwitterCards
     */
    protected $twitterCards;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->twitterCards = $this->app->make('seotools.twitter');
    }

    public function test_set_title()
    {
        $this->twitterCards->setTitle('Turahe');

        $expected = '<meta name="twitter:title" content="Turahe" />';

        $this->setRightAssertion($expected);
    }

    public function test_set_site()
    {
        $this->twitterCards->setSite('http://wach.id');

        $expected = '<meta name="twitter:site" content="http://wach.id" />';

        $this->setRightAssertion($expected);
    }

    public function test_set_url()
    {
        $this->twitterCards->setUrl('http://wach.id');

        $expected = '<meta name="twitter:url" content="http://wach.id" />';

        $this->setRightAssertion($expected);
    }

    public function test_set_description()
    {
        $this->twitterCards->setDescription('Turahe');

        $expected = '<meta name="twitter:description" content="Turahe" />';

        $this->setRightAssertion($expected);
    }

    public function test_cleans_description()
    {
        $description = '"Foo bar" -> abc';

        $this->twitterCards->setDescription($description);

        $expected = '<meta name="twitter:description" content="&quot;Foo bar&quot; -&gt; abc" />';

        $this->setRightAssertion($expected);
    }

    public function test_set_type()
    {
        $this->twitterCards->setType('sayajin');

        $expected = '<meta name="twitter:card" content="sayajin" />';

        $this->setRightAssertion($expected);
    }

    public function test_set_images()
    {
        $this->twitterCards->setImages(['sayajin.png', 'namekusei.png']);

        $expected = '<meta name="twitter:images0" content="sayajin.png" />';
        $expected .= '<meta name="twitter:images1" content="namekusei.png" />';

        $this->setRightAssertion($expected);
    }

    public function test_set_image()
    {
        $this->twitterCards->setImage('sayajin.png');

        $expected = '<meta name="twitter:image" content="sayajin.png" />';

        $this->setRightAssertion($expected);
    }

    protected function setRightAssertion($expectedString)
    {
        $expectedDom = $this->makeDomDocument($expectedString);
        $actualDom = $this->makeDomDocument($this->twitterCards->generate(true));

        $this->assertEquals($expectedDom->C14N(), str_replace(["\n", "\r"], '', $actualDom->C14N()));
    }
}
