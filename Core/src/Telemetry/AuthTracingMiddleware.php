<?php
namespace Google\Cloud\Core\Telemetry;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Middleware for tracing authentication requests.
 */
class AuthTracingMiddleware
{
    /**
     * @var callable
     */
    private $httpHandler;

    private TracerProviderInterface $tracerProvider;

    /**
     * @param callable $httpHandler The HTTP handler to wrap.
     * @param TracerProviderInterface $tracerProvider The tracer provider.
     */
    public function __construct(callable $httpHandler, TracerProviderInterface $tracerProvider)
    {
        $this->httpHandler = $httpHandler;
        $this->tracerProvider = $tracerProvider;
    }

    /**
     * Can be used as a callable for google-auth-library-php
     * 
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface|PromiseInterface
     */
    public function __invoke(RequestInterface $request, array $options = [])
    {
        $span = $this->tracerProvider->getTracer('google-cloud-php', '')
            ->spanBuilder('AuthRequest')
            ->setSpanKind(SpanKind::KIND_CLIENT)
            ->setAttribute('rpc.system', 'http')
            ->setAttribute('rpc.service', 'auth')
            ->startSpan();

        $scope = $span->activate();

        try {
            $handler = $this->httpHandler;
            $response = $handler($request, $options);
            
            if ($response instanceof PromiseInterface) {
                return $response->then(
                    function (ResponseInterface $res) use ($span) {
                        $span->setStatus(StatusCode::STATUS_OK);
                        $span->end();
                        return $res;
                    },
                    function (\Throwable $e) use ($span) {
                        $span->setStatus(StatusCode::STATUS_ERROR, $e->getMessage());
                        $span->end();
                        throw $e;
                    }
                );
            }
            
            $span->setStatus(StatusCode::STATUS_OK);
            return $response;
        } catch (\Throwable $e) {
            $span->setStatus(StatusCode::STATUS_ERROR, $e->getMessage());
            throw $e;
        } finally {
            $scope->detach();
            if (!isset($response) || !($response instanceof PromiseInterface)) {
                $span->end();
            }
        }
    }
}
