<?php

namespace AppStoreLibrary\Tests\Unit\AppStoreServerApi;

use AppStoreLibrary\Clients\FakeClient;
use AppStoreLibrary\Enums\ServerNotifications\Environment;
use AppStoreLibrary\Responses\ServerApi\RetentionMessagingPerformanceTestResultResponse;
use AppStoreLibrary\Sender;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GetRetentionMessagingPerformanceTestResultsTest extends TestCase
{
    public function testSendsExpectedRequestAndParsesResponse(): void
    {
        FakeClient::$responseBody = json_encode([
            'config' => [
                'responseTimeThreshold' => 700,
                'requestCount' => 25,
            ],
            'failures' => [
                'TIMED_OUT' => 2,
                'TLS_ISSUE' => 1,
            ],
            'numPending' => 3,
            'responseTimes' => [
                'average' => 650,
                'p50' => 640,
                'p90' => 680,
                'p95' => 690,
                'p99' => 699,
            ],
            'result' => 'PASS',
            'successRate' => 88,
            'target' => 'https://example.com/retention-message',
        ]);

        $api = new Sender(
            FakeClient::class,
            Environment::Sandbox,
            [
                'APPSTORE_CONNECT_ISSUER_ID' => 'issuer_id',
                'APPSTORE_CONNECT_BUNDLE_ID' => 'bundle_id',
                'APPSTORE_CONNECT_PRIVATE_KEY' => 'private_key',
                'APPSTORE_CONNECT_KEY_ID' => 'key_id',
            ],
        );

        $capturedMethod = null;
        $capturedUrl = null;

        $result = $api->getRetentionMessagingPerformanceTestResults(
            requestId: '11111111-2222-3333-4444-555555555555',
            afterRequest: function (
                Carbon $startedAt,
                RequestInterface $request,
                array $options,
                ?ResponseInterface $response,
                ?\Throwable $error
            ) use (&$capturedMethod, &$capturedUrl): void {
                $capturedMethod = $request->getMethod();
                $capturedUrl = $request->getUri()->__toString();
            },
        );

        $this->assertSame('GET', $capturedMethod);
        $this->assertSame(
            '/inApps/v1/messaging/performanceTest/result/11111111-2222-3333-4444-555555555555',
            $capturedUrl
        );
        $this->assertInstanceOf(RetentionMessagingPerformanceTestResultResponse::class, $result);
        $this->assertSame([
            'responseTimeThreshold' => 700,
            'requestCount' => 25,
        ], $result->getConfig());
        $this->assertSame([
            'TIMED_OUT' => 2,
            'TLS_ISSUE' => 1,
        ], $result->getFailures());
        $this->assertSame(3, $result->getNumPending());
        $this->assertSame([
            'average' => 650,
            'p50' => 640,
            'p90' => 680,
            'p95' => 690,
            'p99' => 699,
        ], $result->getResponseTimes());
        $this->assertSame('PASS', $result->getResult());
        $this->assertSame(88, $result->getSuccessRate());
        $this->assertSame('https://example.com/retention-message', $result->getTarget());
    }
}
