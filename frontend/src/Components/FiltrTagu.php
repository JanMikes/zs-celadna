<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Components;

use CeladnaZS\Web\Value\Content\Data\TagData;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use CeladnaZS\Web\Services\Strapi\StrapiContent;

#[AsTwigComponent]
readonly final class FiltrTagu
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @return array<TagData>
     */
    public function getItems(): array
    {
        return $this->content->getTagy();
    }
}
