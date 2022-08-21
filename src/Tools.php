<?php
namespace Turahe\SEOTools;

use Turahe\SEOTools\Contracts\Tools as SEOContract;

/**
 * Tools provides implementation for `Tools` contract.
 *
 * @see \Turahe\SEOTools\Contracts\Tools
 */
class Tools implements SEOContract
{
    /**
     * {@inheritdoc}
     */
    public function metatags()
    {
        return app('seotools.metatags');
    }

    /**
     * {@inheritdoc}
     */
    public function opengraph()
    {
        return app('seotools.opengraph');
    }

    /**
     * {@inheritdoc}
     */
    public function twitter()
    {
        return app('seotools.twitter');
    }

    /**
     * {@inheritdoc}
     */
    public function jsonLd()
    {
        return app('seotools.json-ld');
    }

    /**
     * {@inheritdoc}
     */
    public function jsonLdMulti()
    {
        return app('seotools.json-ld-multi');
    }

    /**
     * {@inheritdoc}
     */
    public function pwa()
    {
        return new PWA(config('seotools.manifest'));
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title, bool $appendDefault = true): self
    {
        $this->metatags()->setTitle($title, $appendDefault);
        $this->opengraph()->setTitle($title);
        $this->twitter()->setTitle($title);
        $this->jsonLd()->setTitle($title);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description): self
    {
        $this->metatags()->setDescription($description);
        $this->opengraph()->setDescription($description);
        $this->twitter()->setDescription($description);
        $this->jsonLd()->setDescription($description);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanonical(string $url): self
    {
        $this->metatags()->setCanonical($url);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addImages($urls): self
    {
        if (is_array($urls)) {
            $this->opengraph()->addImages($urls);
        } else {
            $this->opengraph()->addImage($urls);
        }

        $this->twitter()->setImage($urls);

        $this->jsonLd()->addImage($urls);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(bool $session = false): string
    {
        if ($session) {
            return $this->metatags()->getTitleSession();
        }

        return $this->metatags()->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function generate(bool $minify = false): string
    {
        $html = $this->metatags()->generate();
        $html .= PHP_EOL;
        $html .= $this->opengraph()->generate();
        $html .= PHP_EOL;
        $html .= $this->twitter()->generate();
        $html .= PHP_EOL;
        $html .= $this->pwa()->generate();
        $html .= PHP_EOL;
        // if json ld multi is use don't show simple json ld
        $html .= $this->jsonLdMulti()->generate() ?? $this->jsonLd()->generate();

        return ($minify) ? str_replace(PHP_EOL, '', $html) : $html;
    }
}
