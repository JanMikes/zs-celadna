<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-type PoleFormulareSMoznostmiDataArray array{
 *     Povinne: null|bool,
 *     Typ: string,
 *     Nadpis_pole: null|string,
 *     Napoveda: null|string,
 *     Moznosti: array<array{Text: string}>,
 *     __component: string,
 *  }
 */
readonly final class PoleFormulareSMoznostmiData
{
    /** @use CanCreateManyFromStrapiResponse<PoleFormulareSMoznostmiDataArray> */
    use CanCreateManyFromStrapiResponse;

    /**
     * @param array<string> $Moznosti
     */
    public function __construct(
        public bool $Povinne,
        public string $Typ,
        public string $Nadpis_pole,
        public array $Moznosti,
        public null|string $Napoveda,
    ) {}

    /**
     * @param PoleFormulareSMoznostmiDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $options = [];

        foreach ($data['Moznosti'] as $option) {
            $options[] = $option['Text'];
        }

        return new self(
            $data['Povinne'] ?? false,
            $data['Typ'],
            $data['Nadpis_pole'] ?? '',
            $options,
            $data['Napoveda'],
        );
    }
}
