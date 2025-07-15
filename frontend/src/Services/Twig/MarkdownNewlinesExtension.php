<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Services\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;

final class MarkdownNewlinesExtension extends AbstractExtension
{
    /**
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('newlines', [$this, 'formatNewlines'], ['is_safe' => ['all']]),
        ];
    }

    public function formatNewlines(string $text): Markup
    {
        // Remove \n that immediately follow a closing HTML tag
        $formatted = preg_replace('/(<\/[^>]+>)\n/', '$1', $text);
        $formatted = str_replace("\n", "<br>", $formatted);

        return new Markup($formatted, 'UTF-8');
    }
}
