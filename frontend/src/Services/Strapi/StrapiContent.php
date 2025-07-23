<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Services\Strapi;

use CeladnaZS\Web\Value\Content\Data\HomepageData;
use Psr\Clock\ClockInterface;
use CeladnaZS\Web\Value\Content\Data\AktualitaData;
use CeladnaZS\Web\Value\Content\Data\KategorieUredniDesky;
use CeladnaZS\Web\Value\Content\Data\KategorieUredniDeskyData;
use CeladnaZS\Web\Value\Content\Data\MenuData;
use CeladnaZS\Web\Value\Content\Data\SekceData;
use CeladnaZS\Web\Value\Content\Data\UredniDeskaData;
use CeladnaZS\Web\Value\Content\Exception\InvalidKategorie;
use CeladnaZS\Web\Value\Content\Exception\NotFound;
use CeladnaZS\Web\Value\Content\Data\ClovekData;
use CeladnaZS\Web\Value\Content\Data\DlazdiceData;
use CeladnaZS\Web\Value\Content\Data\FileData;
use CeladnaZS\Web\Value\Content\Data\ImageData;
use CeladnaZS\Web\Value\Content\Data\TagData;

/**
 * @phpstan-import-type AktualitaDataArray from AktualitaData
 * @phpstan-import-type ClovekDataArray from ClovekData
 * @phpstan-import-type DlazdiceDataArray from DlazdiceData
 * @phpstan-import-type FileDataArray from FileData
 * @phpstan-import-type ImageDataArray from ImageData
 * @phpstan-import-type MenuDataArray from MenuData
 * @phpstan-import-type SekceDataArray from SekceData
 * @phpstan-import-type TagDataArray from TagData
 * @phpstan-import-type UredniDeskaDataArray from UredniDeskaData
 * @phpstan-import-type KategorieUredniDeskyDataArray from KategorieUredniDeskyData
 */
readonly final class StrapiContent
{
    public function __construct(
        private StrapiApiClient $strapiClient,
        private ClockInterface $clock,
    ) {}

    /**
     * @return array<string, SekceData>
     */
    public function getSectionSlugs(): array
    {
        /** @var array{data: array<SekceDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('sekces', populateLevel: 2);

        $data = [];

        foreach ($strapiResponse['data'] as $sekceData) {
            $data[$sekceData['slug']] = SekceData::createFromStrapiResponseWithoutComponents($sekceData);
        }

        return $data;
    }

    /**
     * @param null|string|array<string> $tag
     * @return array<AktualitaData>
     */
    public function getAktualityData(int|null $limit = null, null|array|string $tag = null): array
    {
        $pagination = null;

        if ($limit !== null) {
            $pagination = [
                'limit' => $limit,
                'start' => 0,
            ];
        }

        $filters = [
            'Zobrazovat' => ['$eq' => true],

        ];

        if (is_string($tag)) {
           $filters['tags'] = ['slug' => ['$eq' => $tag]];
        }

        if (is_array($tag)) {
            foreach ($tag as $tagName) {
                $filters['tags']['slug']['$in'][] = $tagName;
            }
        }

        /** @var array{data: array<AktualitaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('aktualities',
            filters: $filters,
            pagination: $pagination,
            sort: [
                'Datum_zverejneni:desc'
            ]);

        return AktualitaData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getAktualitaData(string $slug): AktualitaData
    {
        /** @var array{data: array<AktualitaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('aktualities',
            filters: [
                'Zobrazovat' => ['$eq' => true],
                'slug' => ['$eq' => $slug]
            ]);

        return AktualitaData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    /**
     * @param string|array<string>|null $category
     * @return array<UredniDeskaData>
     */
    public function getUredniDeskyData(
        string|array|null $category = null,
        int|null $limit = null,
        int|null $year = null,
        bool $shouldHideIfExpired = false
    ): array {
        $now = $this->clock->now();
        $filters = [];

        if ($shouldHideIfExpired === true) {
            $filters = [
                'Zobrazovat' => ['$eq' => true],
                '$or' => [
                    ['Datum_stazeni' => ['$null' => true]],
                    ['Datum_stazeni' => ['$gte' => $now->format('Y-m-d')]],
                ],
            ];
        }

        if (is_string($category)) {
            $filters['categories'] = ['slug' => ['$eq' => $category]];
        }

        if (is_array($category)) {
            foreach ($category as $categoryName) {
                $filters['categories']['slug']['$in'][] = $categoryName;
            }
        }

        $pagination = null;

        if ($limit !== null) {
            $pagination = [
                'limit' => $limit,
                'start' => 0,
            ];
        }

        /** @var array{data: array<UredniDeskaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('uredni-deskas',
            filters: $filters,
            pagination: $pagination,
            sort: ['Datum_zverejneni:desc', 'Nadpis'],
        );

        return UredniDeskaData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getUredniDeskaData(string $slug): UredniDeskaData
    {
        /** @var array{data: array<UredniDeskaDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('uredni-deskas',
            filters: [
                'slug' => ['$eq' => $slug],
            ]);

        return UredniDeskaData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    /**
     * @return array<KategorieUredniDeskyData>
     */
    public function getKategorieUredniDesky(): array
    {
        /** @var array{data: array<KategorieUredniDeskyDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('kategorie-uredni-deskies');

        return KategorieUredniDeskyData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<TagData>
     */
    public function getTagy(): array
    {
        /** @var array{data: array<TagDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('tagies', sort: ['rank']);

        return TagData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    /**
     * @return array<MenuData>
     */
    public function getMenu(): array
    {
        /** @var array{data: array<MenuDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('menus', sort: ['Poradi']);

        return MenuData::createManyFromStrapiResponse($strapiResponse['data']);
    }

    public function getSekceData(string $slug): SekceData
    {
        /** @var array{data: array<SekceDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('sekces',
            populateLevel: 6,
            filters: [
            'slug' => ['$eq' => $slug]
        ]);

        return SekceData::createFromStrapiResponse(
            $strapiResponse['data'][0] ?? throw new NotFound
        );
    }

    public function getHomepageData(): HomepageData
    {
        /** @var array{data: array<SekceDataArray>} $strapiResponse */
        $strapiResponse = $this->strapiClient->getApiResource('homepage',
            populateLevel: 4,
        );

        return HomepageData::createFromStrapiResponse(
            $strapiResponse['data'] ?? throw new NotFound
        );
    }
}
