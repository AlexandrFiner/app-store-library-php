<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

use AppStoreLibrary\Enums\ConnectApi\ResourceType;

class ResourceData
{
    public function __construct(
        public ResourceType $type,
        public string $id,
    ) {
    }

    public function toRequest(): array
    {
        return [
            'type' => $this->type->value,
            'id' => $this->id,
        ];
    }
}
