<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

class RelationshipList
{
    /**
     * @param  ResourceData[]  $data
     */
    public function __construct(
        public array $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => array_map(fn(ResourceData $item) => $item->toRequest(), $this->data)];
    }
}
