<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use CeladnaZS\Web\Services\Strapi\StrapiContent;
use CeladnaZS\Web\Value\Content\Data\MenuData;

#[AsTwigComponent]
readonly final class Menu
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    /**
     * @return array<MenuData>
     */
    public function getItems(): array
    {
        return $this->content->getMenu();
    }
}
