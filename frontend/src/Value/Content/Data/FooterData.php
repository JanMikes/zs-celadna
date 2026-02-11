<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-type FooterDataArray array{
 *     Kontakty_sloupec_1: string|null,
 *     Kontakty_sloupec_2: string|null,
 *  }
 */
readonly final class FooterData
{
    public function __construct(
        public string|null $Kontakty_sloupec_1,
        public string|null $Kontakty_sloupec_2,
    ) {}

    /**
     * @param FooterDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            Kontakty_sloupec_1: $data['Kontakty_sloupec_1'] ?? null,
            Kontakty_sloupec_2: $data['Kontakty_sloupec_2'] ?? null,
        );
    }
}
