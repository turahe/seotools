<?php
namespace Turahe\SEOTools\Tests;

use Turahe\SEOTools\JsonLd;

/**
 * Class TwitterCardsTest.
 */
class JsonLdTest extends BaseTest
{
    /**
     * @var JsonLd
     */
    protected $jsonLd;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonLd = $this->app->make('seotools.json-ld');
    }

    public function test_set_title()
    {
        $this->jsonLd->setTitle('Turahe');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Turahe","description":"This description for your website"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_site()
    {
        $this->jsonLd->setSite('http://wach.id');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This description for your website","url":"http://wach.id"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_url()
    {
        $this->jsonLd->setUrl('http://wach.id');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This description for your website","url":"http://wach.id"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    /**
     * @depends test_set_url
     */
    public function test_use_current_url()
    {
        $this->jsonLd->setUrl(null);

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This description for your website","url":"http://localhost"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_description()
    {
        $this->jsonLd->setDescription('Turahe');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"Turahe"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_cleans_description()
    {
        $description = '"Foo bar" -> abc';

        $this->jsonLd->setDescription($description);

        $expected = htmlspecialchars_decode('<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"\"Foo bar\" -&gt; abc"}</script></head></html>');

        $this->setRightAssertion($expected);
    }

    public function test_set_type()
    {
        $this->jsonLd->setType('sayajin');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"sayajin","name":"Over 9000 Thousand!","description":"This·description·for·your·website"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_images()
    {
        $this->jsonLd->setImages(['sayajin.png', 'namekusei.png']);

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","image":["sayajin.png","namekusei.png"]}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_image()
    {
        $this->jsonLd->setImage('sayajin.png');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","image":"sayajin.png"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_add_value()
    {
        $this->jsonLd->addValue('test', '1-2-3');
        $this->jsonLd->addValue('another', 'test-value');

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","test":"1-2-3","another":"test-value"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_array_add_value()
    {
        $this->jsonLd->addValue('author', [
            '@type' => 'Organization',
            'name'  => 'SeoTools',
            'url'   => 'https://github.com/Turahe/seotools',
        ]);

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","author":{"@type":"Organization","name":"SeoTools","url":"https://github.com/Turahe/seotools"}}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_self_add_value()
    {
        $this->jsonLd->addValue('author', new JsonLd([
            'type' => 'Organization',
            'name' => 'SeoTools',
            'url'  => 'https://github.com/Turahe/seotools',
        ]));

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","author":{"@type":"Organization","url":"https://github.com/Turahe/seotools","name":"SeoTools"}}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_self_array_add_value()
    {
        $this->jsonLd->addValue('author', [new JsonLd([
            'type' => 'Organization',
            'name' => 'SeoTools',
            'url'  => 'https://github.com/Turahe/seotools',
        ])]);

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","author":[{"@type":"Organization","url":"https://github.com/Turahe/seotools","name":"SeoTools"}]}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_add_values()
    {
        $this->jsonLd->addValues([
            'test'   => '1-2-3',
            'author' => [
                '@type' => 'Organization',
                'name'  => 'SeoTools',
            ],
        ]);

        $expected = '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This·description·for·your·website","test":"1-2-3","author":{"@type":"Organization","name":"SeoTools"}}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_is_empty()
    {
        // make default json-ld data as empty on create
        config()->set('seotools.json-ld.defaults', []);
        $this->jsonLd = new JsonLd();

        $this->assertTrue($this->jsonLd->isEmpty());
    }

    /**
     * @param string $expectedString
     */
    protected function setRightAssertion($expectedString)
    {
        $expectedDom = $this->makeDomDocument($expectedString);
        $actualDom = $this->makeDomDocument($this->jsonLd->generate(true));

        $this->assertEquals($expectedDom->C14N(), str_replace(["\n", "\r"], '', $actualDom->C14N()));
    }
}
