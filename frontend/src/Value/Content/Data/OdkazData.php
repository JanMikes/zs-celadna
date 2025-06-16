<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

/**
 * @phpstan-type OdkazDataArray array{
 *     sekce: null|array{slug: string},
 *     URL: null|string,
 * }
 */
readonly final class OdkazData
{
    public function __construct(
        public null|string $sekceSlug,
        public null|string $url,
    ) {
    }

    /**
     * @param OdkazDataArray $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        $url = null;
        $slug = null;

        if ($data['URL'] !== null) {
            $url = ltrim($data['URL'], '/');

            if (str_starts_with($url, 'http') === false) {
                $url = '/' . $url;
            }
        }

        if ($data['sekce'] !== null) {
            $slug = $data['sekce']['slug'];
        }

        return new self(
            $slug,
            $url,
        );
    }
}
