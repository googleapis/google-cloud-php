<?php

require __DIR__ . '/../vendor/autoload.php';

use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\SDK\Trace\TracerProviderFactory;
use OpenTelemetry\SDK\Trace\SpanExporter\ConsoleSpanExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;

class TelemetryConfiguration {
    public static function isTracingEnabled(?TracerProviderInterface $constructorProvider = null): bool {
        $env = getenv('GOOGLE_CLOUD_TELEMETRY_ENABLED');
        
        // 1. Global Override
        if ($env === 'false') {
            return false;
        }

        // 2. Constructor-Based Enablement
        if ($constructorProvider !== null) {
            return true;
        }

        // 3. Environment-Based Enablement
        if ($env === 'true') {
            return true;
        }

        // 4. Default
        return false;
    }
}

class SecretManagerClientMock {
    private ?TracerProviderInterface $tracerProvider;
    private $tracer;

    public function __construct(?TracerProviderInterface $tracerProvider = null) {
        $this->tracerProvider = $tracerProvider;
        
        if (TelemetryConfiguration::isTracingEnabled($tracerProvider)) {
            $provider = $this->tracerProvider ?? \OpenTelemetry\API\Globals::tracerProvider();
            $this->tracer = $provider->getTracer('google-cloud-secretmanager', '1.0.0');
        } else {
            $this->tracer = null;
        }
    }

    public function accessSecretVersion(string $name) {
        $span = null;
        if ($this->tracer) {
            $span = $this->tracer->spanBuilder('SecretManagerServiceClient.access_secret_version')
                ->setSpanKind(SpanKind::KIND_INTERNAL)
                ->setAttribute('gcp.client.service', 'secretmanager')
                ->startSpan();
            $scope = $span->activate();
        }

        try {
            if ($span) {
                $t4 = $this->tracer->spanBuilder('GET /v1/' . $name . ':access')
                    ->setSpanKind(SpanKind::KIND_CLIENT)
                    ->setAttribute('rpc.system.name', 'http')
                    ->setAttribute('http.request.method', 'GET')
                    ->setAttribute('gcp.resource.destination.id', '//secretmanager.googleapis.com/' . $name)
                    ->startSpan();
                
                $t4->setAttribute('http.response.status_code', 200);
                $t4->end();
            }

            return "super_secret_value";
        } finally {
            if ($span) {
                $span->end();
                $scope->detach();
            }
        }
    }
}

use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\TracerProvider;

// Setup OTel SDK for testing
$exporter = new InMemoryExporter();
$tracerProvider = new TracerProvider(new SimpleSpanProcessor($exporter));

echo "--- Test 1: Disabled by default ---\n";
putenv('GOOGLE_CLOUD_TELEMETRY_ENABLED'); // Unset
$client1 = new SecretManagerClientMock();
$client1->accessSecretVersion('projects/my-project/secrets/my-secret');
echo "Spans generated: " . count($exporter->getSpans()) . "\n\n";

echo "--- Test 2: Enabled via Constructor ---\n";
$exporter2 = new InMemoryExporter();
$tracerProvider2 = new TracerProvider(new SimpleSpanProcessor($exporter2));
$client2 = new SecretManagerClientMock($tracerProvider2);
$client2->accessSecretVersion('projects/my-project/secrets/my-secret');
echo "Spans generated: " . count($exporter2->getSpans()) . "\n\n";

echo "--- Test 3: Global Override (Disabled) ---\n";
putenv('GOOGLE_CLOUD_TELEMETRY_ENABLED=false');
$exporter3 = new InMemoryExporter();
$tracerProvider3 = new TracerProvider(new SimpleSpanProcessor($exporter3));
$client3 = new SecretManagerClientMock($tracerProvider3);
$client3->accessSecretVersion('projects/my-project/secrets/my-secret');
echo "Spans generated: " . count($exporter3->getSpans()) . "\n\n";

echo "--- Test 4: Environment Enablement (Global Provider) ---\n";
putenv('GOOGLE_CLOUD_TELEMETRY_ENABLED=true');
$exporter4 = new InMemoryExporter();
$tracerProvider4 = new TracerProvider(new SimpleSpanProcessor($exporter4));
\OpenTelemetry\API\Globals::registerInitializer(function(\OpenTelemetry\API\Instrumentation\Configurator $configurator) use ($tracerProvider4) {
    return $configurator->withTracerProvider($tracerProvider4);
});
$client4 = new SecretManagerClientMock();
$client4->accessSecretVersion('projects/my-project/secrets/my-secret');
echo "Spans generated: " . count($exporter4->getSpans()) . "\n";


