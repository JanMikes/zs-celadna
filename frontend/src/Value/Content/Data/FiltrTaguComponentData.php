<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

readonly final class FiltrTaguComponentData
{
    /**
     * @param array{} $data
     */
    public static function createFromStrapiResponse(array $data): self
    {
        return new self();
    }
}
