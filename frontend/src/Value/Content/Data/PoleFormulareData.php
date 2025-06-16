<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-type PoleFormulareDataArray array{
 *     Povinne: null|bool,
 *     Typ: string,
 *     Nadpis_pole: null|string,
 *     Napoveda: null|string,
 *     __component: string,
 *  }
 */
readonly final class PoleFormulareData
{
    /** @use CanCreateManyFromStrapiResponse<PoleFormulareDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public bool $Povinne,
        public string $Typ,
        public string $Nadpis_pole,
        public null|string $Napoveda,
    ) {}

    /**
     * @param PoleFormulareDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Povinne'] ?? false,
            $data['Typ'],
            $data['Nadpis_pole'] ?? '',
            $data['Napoveda'],
        );
    }
}
