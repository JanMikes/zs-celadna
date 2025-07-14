<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-type RadekTabulkyDataArray array{}
 */
readonly final class RadekTabulkyData
{
    /** @use CanCreateManyFromStrapiResponse<RadekTabulkyDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param RadekTabulkyDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self();
    }
}
