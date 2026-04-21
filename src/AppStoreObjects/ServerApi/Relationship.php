<?php

namespace AppStoreLibrary\AppStoreObjects\ServerApi;

class Relationship
{
    public function __construct(
        public ResourceData $data,
    ) {
    }

    public function toRequest(): array
    {
        return ['data' => $this->data->toRequest()];
    }
}
