<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use CeladnaZS\Web\Services\Strapi\StrapiContent;
use CeladnaZS\Web\Value\Content\Data\KategorieUredniDeskyData;
use CeladnaZS\Web\Value\Content\Data\TagData;
use CeladnaZS\Web\Value\Content\Data\UredniDeskaData;

#[AsTwigComponent]
readonly final class UredniDeska
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @param array<KategorieUredniDeskyData> $kategorie
     * @return array<UredniDeskaData>
     */
    public function getItems(int $Pocet, array $kategorie): array
    {
        $categorySlugs = [];
        foreach ($kategorie as $category) {
            $categorySlugs[] = $category->slug;
        }

        return $this->content->getUredniDeskyData(category: $categorySlugs, limit: $Pocet, shouldHideIfExpired: true);
    }
}
