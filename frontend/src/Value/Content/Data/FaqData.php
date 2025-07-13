<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

use DateTimeImmutable;

/**
 * @phpstan-type FaqDataArray array{
 *      Otazka: string,
 *      Odpoved: string,
 *  }
 */
readonly final class FaqData
{
    /** @use CanCreateManyFromStrapiResponse<FaqDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public string $Otazka,
        public string $Odpoved,
    ) {}

    /**
     * @param FaqDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Otazka: $data['Otazka'],
            Odpoved: $data['Odpoved'],
        );
    }
}
