<?php

namespace Turahe\SEOTools\Tests;

use Turahe\SEOTools\JsonLdMulti;

/**
 * Class JsonLdMultiTest.
 */
class JsonLdMultiTest extends BaseTest
{
    /**
     * @var string
     */
    protected $defaultJsonLdHtml = '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website"}</script><script·type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Turahe","description":"This description for your website"}</script>';

    /**
     * @var JsonLdMulti
     */
    protected $jsonLdMulti;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->jsonLdMulti = $this->app->make('seotools.json-ld-multi');
        $this->jsonLdMulti->newJsonLd();
    }

    public function test_set_title()
    {
        $this->jsonLdMulti->setTitle('Turahe');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_site()
    {
        $this->jsonLdMulti->setSite('http://wach.id');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","url":"http://wach.id"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_url()
    {
        $this->jsonLdMulti->setUrl('http://wach.id');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","url":"http://wach.id"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    /**
     * @depends test_set_url
     */
    public function test_use_current_url()
    {
        $this->jsonLdMulti->setUrl(null);

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","url":"http://localhost"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_description()
    {
        $this->jsonLdMulti->setDescription('Turahe');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"Turahe"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_cleans_description()
    {
        $description = '"Foo bar" -> abc';

        $this->jsonLdMulti->setDescription($description);

        $expected = htmlspecialchars_decode('<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"\"Foo bar\" -&gt; abc"}</script></head></html>');

        $this->setRightAssertion($expected);
    }

    public function test_set_type()
    {
        $this->jsonLdMulti->setType('sayajin');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{"@context":"https://schema.org","@type":"sayajin","name":"Over 9000 Thousand!","description":"This description for your website"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_images()
    {
        $this->jsonLdMulti->setImages(['sayajin.png', 'namekusei.png']);

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","image":["sayajin.png","namekusei.png"]}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_set_image()
    {
        $this->jsonLdMulti->setImage('sayajin.png');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","image":"sayajin.png"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_add_value()
    {
        $this->jsonLdMulti->addValue('test', '1-2-3');
        $this->jsonLdMulti->addValue('another', 'test-value');

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","test":"1-2-3","another":"test-value"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_array_add_value()
    {
        $this->jsonLdMulti->addValue('author', [
            '@type' => 'Organization',
            'name' => 'SeoTools',
            'url' => 'https://github.com/Turahe/seotools',
        ]);

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","author":{"@type":"Organization","name":"SeoTools","url":"https://github.com/Turahe/seotools"}}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_add_values()
    {
        $this->jsonLdMulti->addValues([
            'test' => '1-2-3',
            'author' => [
                '@type' => 'Organization',
                'name' => 'SeoTools',
            ],
        ]);

        $expected = '<html><head>'.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website","test":"1-2-3","author":{"@type":"Organization","name":"SeoTools"}}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_new_json_ld()
    {
        $this->jsonLdMulti->newJsonLd();

        $expected = '<html><head>'.$this->defaultJsonLdHtml.$this->defaultJsonLdHtml
            .'<script type="application/ld+json">{""@context":"https://schema.org","@type":"WebPage","name":"My·title·of·json·ld","description":"This description for your website"}</script></head></html>';

        $this->setRightAssertion($expected);
    }

    public function test_is_empty()
    {
        // make default json-ld data as empty on create
        config()->set('seotools.json-ld.defaults', []);
        $this->jsonLdMulti = new JsonLdMulti;
        $this->jsonLdMulti->newJsonLd();

        $this->assertTrue($this->jsonLdMulti->isEmpty());
    }

    /**
     * @depends test_new_json_ld
     * @depends test_set_title
     */
    public function test_select()
    {
        $this->jsonLdMulti->select(0);
        $this->jsonLdMulti->setTitle('Turahe');

        $expected =
            '<html><head><script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Turahe","description":"This description for your website"}</script>'
            .$this->defaultJsonLdHtml.'</head></html>';

        $this->setRightAssertion($expected);
    }

    /**
     * @param  string  $expectedString
     */
    protected function setRightAssertion($expectedString)
    {
        $expectedDom = $this->makeDomDocument($expectedString);
        $actualDom = $this->makeDomDocument($this->jsonLdMulti->generate());

        $this->assertEquals($expectedDom->C14N(), $actualDom->C14N());
    }
}
