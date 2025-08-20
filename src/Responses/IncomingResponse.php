<?php

namespace AppStoreLibrary\Responses;

interface IncomingResponse
{
    public function getContentType(): string;

    public function getContent(): string;
}