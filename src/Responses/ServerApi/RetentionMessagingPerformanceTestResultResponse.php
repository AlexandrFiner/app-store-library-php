<?php

namespace AppStoreLibrary\Responses\ServerApi;

use AppStoreLibrary\Responses\BaseResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @link https://developer.apple.com/documentation/retentionmessaging/performancetestresultresponse
 */
class RetentionMessagingPerformanceTestResultResponse extends BaseResponse
{
    protected array $config = [];
    protected array $failures = [];
    protected ?int $numPending = null;
    protected array $responseTimes = [];
    protected ?string $result = null;
    protected ?int $successRate = null;
    protected ?string $target = null;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);
        $properties = $this->getContent();
        $this->config = $properties['config'] ?? [];
        $this->failures = $properties['failures'] ?? [];
        $this->numPending = $properties['numPending'] ?? null;
        $this->responseTimes = $properties['responseTimes'] ?? [];
        $this->result = $properties['result'] ?? null;
        $this->successRate = $properties['successRate'] ?? null;
        $this->target = $properties['target'] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return array<string, int>
     */
    public function getFailures(): array
    {
        return $this->failures;
    }

    public function getNumPending(): ?int
    {
        return $this->numPending;
    }

    /**
     * @return array<string, int>
     */
    public function getResponseTimes(): array
    {
        return $this->responseTimes;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function getSuccessRate(): ?int
    {
        return $this->successRate;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }
}
