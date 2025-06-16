<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type OdkazDataArray from OdkazData
 * @phpstan-type ObrazekDataArray array{
 *     Obrazek: ImageDataArray,
 *     Odkaz: null|OdkazDataArray,
 * }
 */
readonly final class ObrazekData
{
    /** @use CanCreateManyFromStrapiResponse<ObrazekDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public ImageData $Obrazek,
        public null|OdkazData $Odkaz,
    ) {
    }

    /**
     * @param ObrazekDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            ImageData::createFromStrapiResponse($data['Obrazek']),
            $data['Odkaz'] !== null ? OdkazData::createFromStrapiResponse($data['Odkaz']) : null,
        );
    }
}
