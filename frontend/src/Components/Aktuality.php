<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use CeladnaZS\Web\Services\Strapi\StrapiContent;
use CeladnaZS\Web\Value\Content\Data\AktualitaData;
use CeladnaZS\Web\Value\Content\Data\TagData;

#[AsTwigComponent]
readonly final class Aktuality
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @param array<TagData> $kategorie
     * @return array<AktualitaData>
     */
    public function getItems(int $Pocet, array $kategorie): array
    {
        $tagSlugs = [];
        foreach ($kategorie as $kategorieItem) {
            $tagSlugs[] = $kategorieItem->slug;
        }

        return $this->content->getAktualityData(limit: $Pocet, tag: $tagSlugs);
    }
}
