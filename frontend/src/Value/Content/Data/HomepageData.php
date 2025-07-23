<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-import-type SlideDataArray from SlideData
 * @phpstan-type HomepageDataArray array{
 *     Slider: array<SlideDataArray>,
 *  }
 */
readonly final class HomepageData
{
    /**
     * @param array<SlideData> $Slider
     */
    public function __construct(
        public array $Slider,
    ) {}

    /**
     * @param HomepageDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Slider: SlideData::createManyFromStrapiResponse($data['Slider']),
        );
    }
}
