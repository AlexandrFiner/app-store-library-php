<?php

namespace AppStoreLibrary\Responses;

abstract class IncomingJsonResponse implements IncomingResponse
{
    public function getContentType(): string
    {
        return 'application/json';
    }

    abstract public function getData(): array;

    public function getContent(): string
    {
        return json_encode($this->getData(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}