<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use CeladnaZS\Web\Services\Strapi\StrapiLinkHelper;
use CeladnaZS\Web\Value\Content\Data\OdkazData;

#[AsTwigComponent]
final class Odkaz
{
    public null|OdkazData $data = null;

    public function __construct(
        readonly private StrapiLinkHelper $strapiLinkHelper,
    ) {
    }

    public function getLink(): string
    {
        assert($this->data !== null);

        if ($this->data->sekceSlug !== null) {
            return $this->strapiLinkHelper->getLinkForSlug($this->data->sekceSlug);
        }

        return $this->data->url ?? '#';
    }
}
