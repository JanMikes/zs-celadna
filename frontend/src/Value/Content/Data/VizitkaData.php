<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-import-type TelefonDataArray from TelefonData
 * @phpstan-type VizitkaDataArray array{
 *     Adresa: null|string,
 *     Odkaz_na_mapu: null|string,
 *     Odkaz: null|string,
 *     Oteviraci_doba: null|string,
 *     Telefony: array<TelefonDataArray>,
 *     lides: array<string>,
 * }
 */
readonly final class VizitkaData
{
    /** @use CanCreateManyFromStrapiResponse<VizitkaDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Adresa,
        public null|string $OdkazNaMapu,
        public null|string $Odkaz,
        public null|string $OteviraciDoba,
        /** @var array<string> */
        public array $lides,
        /** @var array<TelefonData> */
        public array $Telefony,
    ) {}

    /**
     * @param VizitkaDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Adresa: $data['Adresa'],
            OdkazNaMapu: $data['Odkaz_na_mapu'],
            Odkaz: $data['Odkaz'],
            OteviraciDoba: $data['Oteviraci_doba'],
            lides: [],
            Telefony: TelefonData::createManyFromStrapiResponse($data['Telefony']),
        );
    }
}
