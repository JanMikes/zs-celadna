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
            $url = $this->strapiLinkHelper->getLinkForSlug($this->data->sekceSlug);
        } else {
            $url = $this->data->url ?? '#';
        }

        if ($this->data->Kotva !== null) {
            $url .= '#' . $this->data->Kotva;
        }

        $url = str_replace('##', '#', $url);

        return $url;
    }
}
