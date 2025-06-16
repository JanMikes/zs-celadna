<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Value\Content\Data;

readonly final class Component
{
    public function __construct(
        public string $type,
        public object $data,
    ) {
    }
}
