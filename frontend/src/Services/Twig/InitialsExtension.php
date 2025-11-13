<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Services\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class InitialsExtension extends AbstractExtension
{
    /**
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('initials', [$this, 'extractInitials']),
        ];
    }

    /**
     * Extracts initials from a full name, removing academic titles
     *
     * Examples:
     * - "Jan Mikeš" -> "JM"
     * - "Mgr. Jan Mikeš" -> "JM"
     * - "prof. MUDr. Jan Mikeš, Ph.D." -> "JM"
     * - "Prof., Mgr. Jan Mikeš, PHDR" -> "JMP"
     */
    public function extractInitials(string $fullName): string
    {
        // Remove commas
        $cleaned = str_replace(',', '', $fullName);

        // Split by spaces and filter out empty parts and words containing dots
        $nameParts = array_filter(
            array_map('trim', explode(' ', $cleaned)),
            fn(string $part) => $part !== '' && !str_contains($part, '.')
        );

        // Extract first letter of each part and convert to uppercase
        $initials = array_map(
            fn(string $part) => mb_strtoupper(mb_substr($part, 0, 1)),
            $nameParts
        );

        return implode('', $initials);
    }
}
