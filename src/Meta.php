<?php

namespace Turahe\SEOTools;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Turahe\SEOTools\Contracts\Meta as MetaTagsContract;

/**
 * Meta provides implementation for `Meta` contract.
 *
 * @see MetaTagsContract
 */
class Meta implements MetaTagsContract
{
    /**
     * The meta title.
     *
     * @var string
     */
    protected $title;

    /**
     * The meta title session.
     *
     * @var string
     */
    protected $title_session;

    /**
     * The meta title session.
     *
     * @var string
     */
    protected $title_default;

    /**
     * The title tag separator.
     *
     * @var string
     */
    protected $title_separator;

    /**
     * The meta description.
     *
     * @var string
     */
    protected $description;

    /**
     * The meta keywords.
     *
     * @var array
     */
    protected $keywords = [];

    /**
     * extra metatags.
     *
     * @var array
     */
    protected $metatags = [];

    /**
     * The canonical URL.
     *
     * @var string
     */
    protected $canonical;

    /**
     * The AMP URL.
     *
     * @var string
     */
    protected $amphtml;

    /**
     * The prev URL in pagination.
     *
     * @var string
     */
    protected $prev;

    /**
     * The next URL in pagination.
     *
     * @var string
     */
    protected $next;

    /**
     * The alternate languages.
     *
     * @var array
     */
    protected $alternateLanguages = [];

    /**
     * The meta robots.
     *
     * @var string
     */
    protected $robots;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * The webmaster tags.
     */
    protected array $webmasterTags = [
        'google' => 'google-site-verification',
        'bing' => 'msvalidate.01',
        'alexa' => 'alexaVerifyID',
        'pinterest' => 'p:domain_verify',
        'yandex' => 'yandex-verification',
        'norton' => 'norton-safeweb-site-verification',
    ];

    public function __construct(array $config)
    {
        $this->config = new Repository($config);
    }

    /**
     * {@inheritdoc}/
     */
    public function generate($minify = false): string
    {
        $this->loadWebMasterTags();

        $title = $this->getTitle();
        $description = $this->getDescription();
        $keywords = $this->getKeywords();
        $metatags = $this->getMetatags();
        $canonical = $this->getCanonical();
        $amphtml = $this->getAmpHtml();
        $prev = $this->getPrev();
        $next = $this->getNext();
        $languages = $this->getAlternateLanguages();
        $robots = $this->getRobots();

        $html = [];

        if ($title) {
            $html[] = Arr::get($this->config, 'add_notranslate_class', false) ? "<title class=\"notranslate\">$title</title>" : "<title>$title</title>";
        }

        if ($description) {
            $html[] = "<meta name=\"description\" content=\"{$description}\">";
        }

        if (! empty($keywords)) {
            if ($keywords instanceof \Illuminate\Support\Collection) {
                $keywords = $keywords->toArray();
            }

            $keywords = implode(', ', $keywords);
            $html[] = "<meta name=\"keywords\" content=\"{$keywords}\">";
        }

        foreach ($metatags as $key => $value) {
            $name = $value[0];
            $content = $value[1];

            // if $content is empty jump to nest
            if (empty($content)) {
                continue;
            }

            $html[] = "<meta {$name}=\"{$key}\" content=\"{$content}\">";
        }

        if ($canonical) {
            $html[] = "<link rel=\"canonical\" href=\"{$canonical}\"/>";
        }

        if ($amphtml) {
            $html[] = "<link rel=\"amphtml\" href=\"{$amphtml}\"/>";
        }

        if ($prev) {
            $html[] = "<link rel=\"prev\" href=\"{$prev}\"/>";
        }

        if ($next) {
            $html[] = "<link rel=\"next\" href=\"{$next}\"/>";
        }

        foreach ($languages as $lang) {
            $html[] = "<link rel=\"alternate\" hreflang=\"{$lang['lang']}\" href=\"{$lang['url']}\"/>";
        }

        if ($robots) {
            $html[] = "<meta name=\"robots\" content=\"{$robots}\">";
        }

        return ($minify) ? implode('', $html) : implode(PHP_EOL, $html);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle(string $title, bool $appendDefault = true): self
    {
        // open redirect vulnerability fix
        $title = str_replace(['http-equiv=', 'url='], '', $title);

        // clean title
        $title = strip_tags($title);

        // store title session
        $this->title_session = $title;

        // store title
        if ($appendDefault === true) {
            $this->title = $this->parseTitle($title);
        } else {
            $this->title = $title;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitleDefault(string $default): self
    {
        $this->title_default = $default;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitleSeparator(string $separator): self
    {
        $this->title_separator = $separator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description): self
    {
        // clean and store description
        // if is false, set false
        $this->description = ! $description ? $description : htmlspecialchars($description, ENT_QUOTES, 'UTF-8', false);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setKeywords(array|string $keywords): self
    {
        if (! is_array($keywords)) {
            $keywords = explode(', ', $keywords);
        }

        // clean keywords
        $keywords = array_map('strip_tags', $keywords);

        // store keywords
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addKeyword(array|string $keyword): self
    {
        if (is_array($keyword)) {
            $this->keywords = array_merge($keyword, $this->keywords);
        } else {
            $this->keywords[] = strip_tags($keyword);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeMeta(string $key): self
    {
        Arr::forget($this->metatags, $key);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addMeta(array|string $meta, ?string $value = null, string $name = 'name'): self
    {
        // multiple metas
        if (is_array($meta)) {
            foreach ($meta as $key => $value) {
                $this->metatags[$key] = [$name, $value];
            }
        } else {
            $this->metatags[$meta] = [$name, $value];
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCanonical(string $url): self
    {
        $this->canonical = $url;

        return $this;
    }

    /**
     * Sets the AMP html URL.
     *
     * @param  string  $url
     * @return MetaTagsContract
     */
    public function setAmpHtml($url): self
    {
        $this->amphtml = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPrev(string $url): self
    {
        $this->prev = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setNext(string $url): self
    {
        $this->next = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAlternateLanguage(string $lang, string $url): self
    {
        $this->alternateLanguages[] = ['lang' => $lang, 'url' => $url];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAlternateLanguages(array $languages): self
    {
        $this->alternateLanguages = array_merge($this->alternateLanguages, $languages);

        return $this;
    }

    /**
     * Sets the meta robots.
     *
     *
     * @return MetaTagsContract
     */
    public function setRobots(string $robots): self
    {
        $this->robots = $robots;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->title ?: $this->getDefaultTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTitle(): string
    {
        if (empty($this->title_default)) {
            return $this->config->get('defaults.title', null);
        }

        return $this->title_default;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitleSession(): string
    {
        return $this->title_session ?: $this->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitleSeparator(): string
    {
        return $this->title_separator ?: $this->config->get('defaults.separator', ' - ');
    }

    /**
     * {@inheritdoc}
     */
    public function getKeywords(): array
    {
        return $this->keywords ?: $this->config->get('defaults.keywords', []);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetatags(): array
    {
        return $this->metatags;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): string
    {
        return $this->description ?: $this->config->get('defaults.description', null);
    }

    /**
     * {@inheritdoc}
     */
    public function getCanonical(): string
    {
        if ($this->canonical) {
            return $this->canonical;
        }

        $canonical_config = $this->config->get('defaults.canonical', false);

        if ($canonical_config === null || $canonical_config === 'full') {
            return htmlspecialchars(app('url')->full());
        } elseif ($canonical_config === 'current') {
            return htmlspecialchars(app('url')->current());
        }

        return $canonical_config;
    }

    /**
     * Get the AMP html URL.
     *
     * @return string
     */
    public function getAmpHtml()
    {
        return $this->amphtml;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrev(): ?string
    {
        return $this->prev;
    }

    /**
     * {@inheritdoc}
     */
    public function getNext(): ?string
    {
        return $this->next;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlternateLanguages(): array
    {
        return $this->alternateLanguages;
    }

    /**
     * Get meta robots.
     *
     * @return string
     */
    public function getRobots()
    {
        return $this->robots ?: $this->config->get('defaults.robots', null);
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->description = null;
        $this->title_session = null;
        $this->next = null;
        $this->prev = null;
        $this->canonical = null;
        $this->amphtml = null;
        $this->metatags = [];
        $this->keywords = [];
        $this->alternateLanguages = [];
        $this->robots = null;
    }

    /**
     * Get parsed title.
     */
    protected function parseTitle(string $title): string
    {
        $default = $this->getDefaultTitle();

        if (empty($default)) {
            return $title;
        }
        $defaultBefore = $this->config->get('defaults.titleBefore', false);

        return $defaultBefore ? $default.$this->getTitleSeparator().$title : $title.$this->getTitleSeparator().$default;
    }

    /**
     * Load webmaster tags from configuration.
     */
    protected function loadWebMasterTags()
    {
        foreach ($this->config->get('webmaster_tags', []) as $name => $value) {
            if (! empty($value)) {
                $meta = Arr::get($this->webmasterTags, $name, $name);
                $this->addMeta($meta, $value);
            }
        }
    }
}
