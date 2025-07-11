<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

use DateTimeImmutable;

/**
 * @phpstan-type TerminAkceDataArray array{
 *     Nazev: null|string,
 *     Termin: string,
 *  }
 */
readonly final class TerminAkceData
{
    /** @use CanCreateManyFromStrapiResponse<TerminAkceDataArray> */
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public null|string $Nazev,
        public null|DateTimeImmutable $Termin,
    ) {}

    /**
     * @param TerminAkceDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Nazev: $data['Nazev'],
            Termin: $data['Termin'] ? new DateTimeImmutable($data['Termin']) : null,
        );
    }
}
