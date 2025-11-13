<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Services\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class InitialsExtension extends AbstractExtension
{
    /**
     * Common Czech academic titles that should be removed before extracting initials
     */
    private const ACADEMIC_TITLES = [
        'Mgr.',
        'Ing.',
        'Bc.',
        'MUDr.',
        'JUDr.',
        'PhDr.',
        'RNDr.',
        'PaedDr.',
        'ThLic.',
        'ThDr.',
        'Ph.D.',
        'CSc.',
        'DrSc.',
        'Dr.',
        'prof.',
        'doc.',
    ];

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
     */
    public function extractInitials(string $fullName): string
    {
        // Remove academic titles
        $nameWithoutTitles = $this->removeAcademicTitles($fullName);

        // Split by spaces and filter out empty parts
        $nameParts = array_filter(
            array_map('trim', explode(' ', $nameWithoutTitles)),
            fn(string $part) => $part !== ''
        );

        // Extract first letter of each part and convert to uppercase
        $initials = array_map(
            fn(string $part) => mb_strtoupper(mb_substr($part, 0, 1)),
            $nameParts
        );

        return implode('', $initials);
    }

    private function removeAcademicTitles(string $name): string
    {
        $result = $name;

        foreach (self::ACADEMIC_TITLES as $title) {
            $result = str_replace($title, '', $result);
        }

        // Remove commas that might be left after removing titles
        $result = str_replace(',', '', $result);

        // Clean up multiple spaces
        $result = preg_replace('/\s+/', ' ', $result);

        return trim($result ?? '');
    }
}
