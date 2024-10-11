<?php

namespace AppStoreLibrary\Responses;

trait HasIncludedTrait
{
    private null|array|object $included;

    private function setIncluded(array $content): void
    {
        $this->included = $content['included'] ?? null;
    }

    public function getIncluded(): null|array|object
    {
        return $this->included;
    }
}
