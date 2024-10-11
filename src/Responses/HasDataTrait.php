<?php

namespace AppStoreLibrary\Responses;

trait HasDataTrait
{
    private null|array|object $data;

    private function setData(array $content): void
    {
        $this->data = $content['data'] ?? null;
    }

    public function getData(): null|array|object
    {
        return $this->data;
    }
}
