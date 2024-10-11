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
        if ($this->response->getStatusCode() !== 200) {
            throw new \Exception($this->response->getReasonPhrase(), $this->response->getStatusCode());
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
