<?php
/*
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\ApiCore\Tests\System\ResumableUpload;

use Google\ApiCore\ResumableUpload\ResumableUpload;
use Google\ApiCore\ResumableUpload\ResumableUploadClient;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Protobuf\Timestamp;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;

/**
 * System tests validating ResumableUploadClient and ResumableUpload protocol implementation
 * against a locally running python scotty-uup-service instance.
 */
class ResumableUploadSystemTest extends TestCase
{
    private array $runningServers = [];

    protected function tearDown(): void
    {
        foreach ($this->runningServers as $server) {
            if (isset($server['pipes'])) {
                foreach ($server['pipes'] as $pipe) {
                    if (is_resource($pipe)) {
                        fclose($pipe);
                    }
                }
            }
            if (isset($server['process']) && is_resource($server['process'])) {
                proc_terminate($server['process']);
                proc_close($server['process']);
            }
            if (isset($server['dummyConfigPath']) && file_exists($server['dummyConfigPath'])) {
                @unlink($server['dummyConfigPath']);
            }
        }
        $this->runningServers = [];
        parent::tearDown();
    }

    private function startScottyServer(string $scenario = 'happy_path', array $scenarioConfig = []): array
    {
        $scottyDir = realpath(__DIR__ . '/../../../../../scotty-uup-service');
        if (!$scottyDir || !is_dir($scottyDir)) {
            $this->markTestSkipped(
                'scotty-uup-service repo not found at ' . __DIR__ . '/../../../../../scotty-uup-service.'
            );
        }

        exec('which uv 2>/dev/null', $out, $ret);
        if ($ret !== 0) {
            $this->markTestSkipped('uv tool not found; skipping scotty-uup-service integration tests.');
        }

        $logDir = sys_get_temp_dir() . '/scotty_integration_logs_' . uniqid();
        mkdir($logDir, 0777, true);

        $cmd = [
            'uv', 'run', 'scotty-service',
            '--port', '0',
            '--uri-path', 'upload',
            '--log-dir', $logDir,
            '--scenario', $scenario,
            '--scenario-config', json_encode($scenarioConfig)
        ];

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];

        $process = proc_open($cmd, $descriptors, $pipes, $scottyDir);
        if (!is_resource($process)) {
            $this->fail('Failed to start scotty-uup-service process.');
        }

        $portLine = trim(fgets($pipes[1]));
        $port = (int) $portLine;
        if ($port <= 0) {
            $this->fail("Invalid port output from scotty-service: $portLine");
        }

        $logPathLine = trim(fgets($pipes[1]));
        $msgLine = trim(fgets($pipes[1]));

        $dummyConfigPath = sys_get_temp_dir() . '/dummy_rest_config_' . uniqid() . '.php';
        file_put_contents($dummyConfigPath, "<?php return ['interfaces' => []];");

        $serverInfo = [
            'process' => $process,
            'pipes' => $pipes,
            'port' => $port,
            'logDir' => $logDir,
            'dummyConfigPath' => $dummyConfigPath
        ];
        $this->runningServers[] = $serverInfo;

        return $serverInfo;
    }

    private function createClientAndUpload(array $serverInfo, string $data, ?callable $progressCallback = null): bool
    {
        $port = $serverInfo['port'];
        $httpHandler = HttpHandlerFactory::build();
        $requestBuilder = $this->createMock(\Google\ApiCore\RequestBuilder::class);
        $requestBuilder->method('build')->willReturnCallback(function ($path, $message, $headers = []) use ($port) {
            $body = $message ? $message->serializeToJsonString() : '';
            return new \GuzzleHttp\Psr7\Request('POST', "http://127.0.0.1:$port", $headers, $body);
        });
        $client = new ResumableUploadClient(
            $requestBuilder,
            [$httpHandler, 'async'],
            serviceAddress: "http://127.0.0.1:$port",
            uploadPrefix: '/upload'
        );

        $options = ['chunkSize' => 1024];
        if ($progressCallback !== null) {
            $options['progressCallback'] = $progressCallback;
        }

        $upload = new ResumableUpload(
            $client,
            'test.method',
            new Timestamp(),
            null,
            $options
        );

        $stream = Utils::streamFor($data);
        return $upload->startUpload($stream);
    }

    public function testHappyPathUpload()
    {
        $serverInfo = $this->startScottyServer('happy_path');

        $callbackBytes = null;
        $callbackUrl = null;
        $payload = "hello world from happy path integration test to scotty uup service!";

        $result = $this->createClientAndUpload(
            $serverInfo,
            $payload,
            function (int $bytes, ResumableUpload $upload) use (&$callbackBytes, &$callbackUrl) {
                $callbackBytes = $bytes;
                $callbackUrl = $upload->getUploadUrl();
            }
        );

        $this->assertTrue($result);
        $this->assertEquals(strlen($payload), $callbackBytes);
        $this->assertStringStartsWith("http://127.0.0.1:{$serverInfo['port']}/upload?sid=", $callbackUrl);

        // Verify audit log JSON lines produced by scotty-uup-service
        $logFiles = glob($serverInfo['logDir'] . '/session_*.jsonl');
        $this->assertNotEmpty($logFiles, 'scotty-service did not produce any session log file.');

        $lines = file($logFiles[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $events = array_map(fn($line) => json_decode($line, true), $lines);

        $startReqs = array_filter(
            $events,
            fn($e) => ($e['event_type'] ?? '') === 'request_received'
                && ($e['headers']['X-Goog-Upload-Command'] ?? '') === 'start'
        );
        $this->assertNotEmpty($startReqs, 'Expected start command in scotty audit logs.');
        $startReq = reset($startReqs);
        $this->assertEquals('resumable', $startReq['headers']['X-Goog-Upload-Protocol'] ?? '');
    }

    public function testNonFatalErrorOnStartRecovery()
    {
        $serverInfo = $this->startScottyServer('non_fatal_error_on_start', [
            'error_code' => 503,
            'failure_count' => 2,
            'action_after_failures' => 'succeed'
        ]);

        $payload = "data with transient 503 error on start";
        $result = $this->createClientAndUpload($serverInfo, $payload);

        $this->assertTrue($result);

        // Verify logs show injected error and subsequent recovery
        $logFiles = glob($serverInfo['logDir'] . '/session_*.jsonl');
        $this->assertNotEmpty($logFiles);
        $lines = file($logFiles[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $events = array_map(fn($line) => json_decode($line, true), $lines);

        $injections = array_filter(
            $events,
            fn($e) => ($e['event_type'] ?? '') === 'scenario_action' && ($e['action'] ?? '') === 'inject_error'
        );
        $this->assertCount(2, $injections, 'Expected exactly 2 injected errors during start.');
    }

    public function testNonFatalErrorOnChunkUploadRecovery()
    {
        $serverInfo = $this->startScottyServer('non_fatal_error_on_chunk_upload', [
            'error_code' => 503,
            'failure_count' => 2,
            'action_after_failures' => 'succeed',
            'after_offset' => 0
        ]);

        $payload = "data with transient 503 error on chunk upload";
        $result = $this->createClientAndUpload($serverInfo, $payload);

        $this->assertTrue($result);

        // Verify logs show injected error and subsequent recovery
        $logFiles = glob($serverInfo['logDir'] . '/session_*.jsonl');
        $this->assertNotEmpty($logFiles);
        $lines = file($logFiles[0], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $events = array_map(fn($line) => json_decode($line, true), $lines);

        $injections = array_filter(
            $events,
            fn($e) => ($e['event_type'] ?? '') === 'scenario_action' && ($e['action'] ?? '') === 'inject_error'
        );
        $this->assertCount(2, $injections, 'Expected exactly 2 injected errors during chunk upload.');
    }
}
