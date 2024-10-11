<?php

namespace AppStoreLibrary\Responses;

use JetBrains\PhpStorm\ArrayShape;

trait HasPaginationTrait
{
    private null|array|object $pagination;

    private function setPagination(array $content): void
    {
        $this->pagination = $content['links'] ?? null;
    }

    #[ArrayShape(['url' => 'string', 'cursor' => 'string|null'])]
    private function extractCursor(?string $url): ?array
    {
        if (!$url) {
            return null;
        }

        parse_str(parse_url($url, PHP_URL_QUERY), $params);

        return [
            'url' => $url,
            'cursor' => $params['cursor'] ?? null,
        ];
    }

    /**
     * Links related to the response document, including paging links.
     * https://developer.apple.com/documentation/appstoreconnectapi/pageddocumentlinks
     *
     * @return array
     */
    #[ArrayShape(['first' => 'array|null', 'next' => 'array|null', 'current' => 'array|null'])]
    public function getPagination(): array
    {
        return [
            'first' => $this->extractCursor($this->pagination['first'] ?? null),
            'current' => $this->extractCursor($this->pagination['self'] ?? null),
            'next' => $this->extractCursor($this->pagination['next'] ?? null),
        ];
    }
}
