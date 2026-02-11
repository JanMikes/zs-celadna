<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use CeladnaZS\Web\Services\Strapi\StrapiContent;
use CeladnaZS\Web\Value\Content\Data\FooterData;

#[AsTwigComponent]
readonly final class Footer
{
    public function __construct(
        private StrapiContent $content,
    ) {
    }

    public function getFooterData(): FooterData|null
    {
        return $this->content->getFooterData();
    }
}
