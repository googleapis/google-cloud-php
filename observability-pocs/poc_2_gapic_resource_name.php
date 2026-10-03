<?php
// Mocking the GAPIC generator dynamic path parsing heuristic

$tests = [
    [
        'api_domain' => 'pubsub.googleapis.com',
        'http_annotation' => 'v1/{name=projects/*/topics/*}',
        'runtime_path' => 'v1/projects/my-project/topics/my-topic'
    ],
    [
        'api_domain' => 'spanner.googleapis.com',
        'http_annotation' => 'v1/{session=projects/*/instances/*/databases/*/sessions/*}:commit',
        'runtime_path' => 'v1/projects/p/instances/i/databases/d/sessions/s:commit'
    ],
    [
        'api_domain' => 'storage.googleapis.com',
        'http_annotation' => 'b/{bucket}/o/{object}',
        'runtime_path' => 'b/my-bucket/o/my-file.txt'
    ]
];

echo "Starting GAPIC Resource Name Parser PoC...\n\n";

foreach ($tests as $test) {
    echo "Testing annotation: " . $test['http_annotation'] . "\n";
    
    // In gapic-generator-php, this regex generation would happen at compile-time.
    // We convert the annotation to a regex pattern capturing the dynamic parts.
    // Simplified regex generation for PoC:
    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)=([^\}]+)\}/', '(?P<$1>$2)', $test['http_annotation']);
    // Handle simple {bucket} cases without explicit wildcards
    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/:]+)', $pattern);
    
    // Replace * with regex wildcard for the generated pattern
    $pattern = str_replace('*', '[^/:]+', $pattern);
    $pattern = '#^' . $pattern . '$#';
    
    echo "  Generated Regex: $pattern\n";
    
    // At runtime in the client library, we apply the regex to the actual path.
    if (preg_match($pattern, $test['runtime_path'], $matches)) {
        // Find the named capturing group that matches a valid GCP resource structure
        // (For simplicity in PoC, we just take the first named match that contains a slash)
        $extractedResource = null;
        foreach ($matches as $key => $value) {
            if (is_string($key) && strpos($value, '/') !== false) {
                $extractedResource = $value;
                break;
            }
        }
        
        if (!$extractedResource && isset($matches[1])) {
             // Fallback for simple non-slashed variables (like bucket name)
             $extractedResource = $matches['bucket'] ?? null;
        }

        if ($extractedResource) {
            $formattedId = '//' . $test['api_domain'] . '/' . $extractedResource;
            echo "  Extracted Resource ID: " . $formattedId . "\n\n";
        } else {
            echo "  FAILED to extract resource.\n\n";
        }
    } else {
        echo "  FAILED to match runtime path.\n\n";
    }
}
