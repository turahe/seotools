<?php
namespace Turahe\SEOTools\Tests;

use Turahe\SEOTools\Tools;
use Turahe\SEOTools\Contracts\Meta;
use Turahe\SEOTools\Contracts\OpenGraph;
use Turahe\SEOTools\Contracts\TwitterCards;

/**
 * Class ToolsTest.
 */
class ToolsTest extends BaseTest
{
    /**
     * @var Tools
     */
    protected $seoTools;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seoTools = $this->app->make('seotools');
    }

    public function test_metatag_instance()
    {
        $this->assertInstanceOf(Meta::class, $this->seoTools->metatags());
    }

    public function test_opengraph_instance()
    {
        $this->assertInstanceOf(OpenGraph::class, $this->seoTools->opengraph());
    }

    public function test_twitter_instance()
    {
        $this->assertInstanceOf(TwitterCards::class, $this->seoTools->twitter());
    }

    public function test_set_title()
    {
        $this->seoTools->setTitle('It\'s Turahe Post!');

        $expected = "<title>My Title - It's Turahe Post!</title>";
        $expected .= '<meta name="description" content="This description for your website">';
        $expected .= '<meta property="og:title" content="My Title" />';
        $expected .= '<meta property="og:description" content="This description for your website" />';
        $expected .= '<meta name="twitter:title" content="My Title" />';
        $expected .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Kamehamehaaaaaaa","description":"This description for your website"}</script>';

        $this->assertEquals('It\'s Turahe Post! - My Title', $this->seoTools->getTitle());
        $this->setRightAssertion($expected);
    }

    public function test_set_description()
    {
        $this->seoTools->setDescription('My Title Description');

        $expected = "<title>It's Turahe Post!</title>";
        $expected .= '<meta name="description" content="My Title Description">';
        $expected .= '<meta property="og:description" content="My Title Description" />';
        $expected .= '<meta property="og:title" content="Turahe Post!" />';
        $expected .= '<meta name="twitter:description" content="My Title Description" />';
        $expected .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"Kamehamehaaaaaaa"}</script>';

        $this->setRightAssertion($expected);
    }

    public function test_set_canonical()
    {
        $this->seoTools->setCanonical('http://domain.com');

        $expected = "<title>My Title</title>";
        $expected .= '<meta name="description" content="This description for your website">';
        $expected .= '<link rel="canonical" href="http://domain.com"/>';
        $expected .= '<meta property="og:title" content="Over 9000 Thousand!" />';
        $expected .= '<meta property="og:description" content="This description for your website" />';
        $expected .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This description for your website"}</script>';

        $this->setRightAssertion($expected);
    }

    public function test_add_images()
    {
        $this->seoTools->addImages(['Kamehamehaaaaaaa.png']);
        $this->seoTools->addImages('Kamehamehaaaaaaa.png');

        $expected = "<title>My Title</title>";
        $expected .= '<meta name="description" content="This description for your website">';
        $expected .= '<meta property="og:title" content="Over 9000 Thousand!" />';
        $expected .= '<meta property="og:description" content="This description for your website" />';
        $expected .= '<meta property="og:image" content="Kamehamehaaaaaaa.png" />';
        $expected .= '<meta property="og:image" content="Kamehamehaaaaaaa.png" />';
        $expected .= '<meta name="twitter:image" content="Kamehamehaaaaaaa.png" />';
        $expected .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This description for your website","image":["Kamehamehaaaaaaa.png","Kamehamehaaaaaaa.png"]}</script>';

        $this->setRightAssertion($expected);
    }

    public function test_generate()
    {
        $expected = "<title>My Title</title>";
        $expected .= '<meta name="description" content="This description for your website">';
        $expected .= '<meta property="og:title" content="Over 9000 Thousand!" />';
        $expected .= '<meta property="og:description" content="This description for your website" />';
        $expected .= '<script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Over 9000 Thousand!","description":"This description for your website"}</script>';

        $this->setRightAssertion($expected);
    }

    /**
     * @param $expectedString
     */
    protected function setRightAssertion($expectedString)
    {
        $expectedDom = $this->makeDomDocument($expectedString);
        $actualDom = $this->makeDomDocument($this->seoTools->generate(true));

        $this->assertEquals($expectedDom->C14N(), str_replace(["\n", "\r"], '', $actualDom->C14N()));
    }
}
