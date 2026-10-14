<?php
// Mocking the Pub/Sub Streaming Pull loop to verify Span Context does not leak.
require __DIR__ . '/../vendor/autoload.php';

use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\SDK\Trace\TracerProvider;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;

$exporter = new InMemoryExporter();
$tracerProvider = new TracerProvider(new SimpleSpanProcessor($exporter));
$tracer = $tracerProvider->getTracer('google-cloud-pubsub-mock', '1.0.0');

// Mock Streaming Pull Loop
echo "Starting Pub/Sub Streaming Pull PoC...\n";

// The overall subscriber span (T2)
$subscriberSpan = $tracer->spanBuilder('Subscriber.StreamingPull')
    ->setSpanKind(SpanKind::KIND_CLIENT)
    ->startSpan();
$subscriberScope = $subscriberSpan->activate();

try {
    for ($i = 1; $i <= 3; $i++) {
        // T3: Process individual message
        $messageSpan = $tracer->spanBuilder("ProcessMessage $i")
            ->setSpanKind(SpanKind::KIND_INTERNAL)
            ->startSpan();
        
        $messageScope = $messageSpan->activate();
        try {
            // Simulate user callback executing
            echo "Processing message $i in trace " . $messageSpan->getContext()->getTraceId() . "\n";
            
            // T4: Simulated network call inside the user callback (e.g. acking the message)
            $ackSpan = $tracer->spanBuilder("POST /v1/projects/p/subscriptions/s:acknowledge")
                ->setSpanKind(SpanKind::KIND_CLIENT)
                ->startSpan();
            $ackScope = $ackSpan->activate();
            try {
                // Network delay
            } finally {
                $ackSpan->end();
                $ackScope->detach();
            }
        } finally {
            $messageSpan->end();
            $messageScope->detach(); // CRITICAL: Detaching prevents context leak to next message loop
        }
    }
} finally {
    $subscriberSpan->end();
    $subscriberScope->detach();
}

echo "\nTotal Spans Exported: " . count($exporter->getSpans()) . "\n";
foreach ($exporter->getSpans() as $span) {
    echo "- Span: " . $span->getName() . " | Parent ID: " . $span->getParentContext()->getSpanId() . "\n";
}
