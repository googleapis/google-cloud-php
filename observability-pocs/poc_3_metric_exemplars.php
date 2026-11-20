<?php
// Mocking Metric Exemplars with OpenTelemetry PHP SDK
require __DIR__ . '/../vendor/autoload.php';

use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter as InMemoryTraceExporter;
use OpenTelemetry\SDK\Metrics\MeterProvider;
use OpenTelemetry\SDK\Metrics\MetricExporter\InMemoryExporter as InMemoryMetricExporter;
use OpenTelemetry\SDK\Metrics\MetricReader\ExportingReader;

$traceExporter = new InMemoryTraceExporter();
$tracerProvider = new TracerProvider(new SimpleSpanProcessor($traceExporter));
$tracer = $tracerProvider->getTracer('poc-tracer');

$metricExporter = new InMemoryMetricExporter();
$meterProvider = OpenTelemetry\SDK\Metrics\MeterProvider::builder()
    ->addReader(new ExportingReader($metricExporter))
    ->build();
$meter = $meterProvider->getMeter('poc-meter');

$histogram = $meter->createHistogram(
    'gcp.client.request.duration',
    'ms',
    'Duration of client request'
);

echo "Starting Metric Exemplars PoC...\n";

// Start a trace
$span = $tracer->spanBuilder('Storage.Upload')->setSpanKind(SpanKind::KIND_CLIENT)->startSpan();
$scope = $span->activate();

try {
    echo "Active Trace ID: " . $span->getContext()->getTraceId() . "\n";
    echo "Active Span ID:  " . $span->getContext()->getSpanId() . "\n";
    
    // Simulate workload
    usleep(150000); // 150ms
    
    // Record the metric WHILE the trace context is active. 
    // The OTel SDK should automatically attach the active trace as an exemplar.
    $histogram->record(150.5, ['gcp.client.service' => 'storage']);
    echo "Recorded metric: 150.5 ms\n";
} finally {
    $span->end();
    $scope->detach();
}

// Force flush the metrics reader to the memory exporter
$meterProvider->shutdown();

echo "\nVerifying Metric Export for Exemplars:\n";
$metrics = $metricExporter->collect();

foreach ($metrics as $metric) {
    if ($metric->name === 'gcp.client.request.duration') {
        echo print_r($metric->data, true);
    }
}
