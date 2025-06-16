<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type OdkazDataArray from OdkazData
 * @phpstan-type DlazdiceDataArray array{
 *     Ikona: null|ImageDataArray,
 *     Nadpis_dlazdice: string,
 *     Odkaz: OdkazDataArray,
 * }
 */
readonly final class DlazdiceData
{
    /** @use CanCreateManyFromStrapiResponse<DlazdiceDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|ImageData $Ikona,
        public string $Nadpis_dlazdice,
        public OdkazData $Odkaz,
    ) {
    }

    /**
     * @param DlazdiceDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Ikona'] ? ImageData::createFromStrapiResponse($data['Ikona']) : null,
            $data['Nadpis_dlazdice'],
            OdkazData::createFromStrapiResponse($data['Odkaz']),
        );
    }
}
