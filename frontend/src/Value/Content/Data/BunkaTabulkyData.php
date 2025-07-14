<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-type BunkaTabulkyDataArray array{}
 */
readonly final class BunkaTabulkyData
{
    /** @use CanCreateManyFromStrapiResponse<BunkaTabulkyDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param BunkaTabulkyDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self();
    }
}
