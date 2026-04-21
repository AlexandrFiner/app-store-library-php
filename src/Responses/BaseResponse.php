<?php

namespace AppStoreLibrary\Responses;

use AppStoreLibrary\Enums\ServerApi\ErrorCodes;
use AppStoreLibrary\Exceptions\AppStoreServerApiException;
use Psr\Http\Message\ResponseInterface;

abstract class BaseResponse
{
    private array $content;

    /**
     * @throws AppStoreServerApiException
     * @throws \Exception
     */
    protected function __construct(private readonly ResponseInterface $response)
    {
        $response->getBody()->rewind();
        if ($content = $response->getBody()->getContents()) {
            $this->content = json_decode($content, true);
            if (isset($this->content['errorCode'])) {
                $error = ErrorCodes::tryFrom($this->content['errorCode']);
                throw new AppStoreServerApiException(
                    $error?->getMessage() ?? '',
                    $error?->value ?? $this->content['errorCode'],
                );
            }
        }
        $statusCode = $this->response->getStatusCode();
        if ($statusCode < 200 || $statusCode >= 300) {
            throw new \Exception($this->response->getReasonPhrase(), $statusCode);
        }
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getRateLimit(): array
    {
        return $this->response->getHeader('X-Rate-Limit');
    }
}
