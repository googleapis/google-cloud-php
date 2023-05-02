<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Speech\Tests\Unit\V1;

use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\Testing\MockBidiStreamingCall;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Core\InsecureCredentialsWrapper;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig_AudioEncoding;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\StreamingRecognitionConfig;
use Google\Cloud\Speech\V1\StreamingRecognizeRequest;
use Google\Cloud\Speech\V1\StreamingRecognizeResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group speech
 */
class SpeechClientExtensionTest extends TestCase
{
    use ProphecyTrait;

    /** @var SpeechClient */
    private $client;
    /** @var TransportInterface */
    private $transport;

    public function setUp(): void
    {
        $this->transport = $this->prophesize(TransportInterface::class);
        $this->client = new SpeechClient([
            'transport' => $this->transport->reveal(),
            'credentials' => new InsecureCredentialsWrapper(),
        ]);
    }

    private function createRecognitionConfig()
    {
        $encoding = RecognitionConfig_AudioEncoding::FLAC;
        $sampleRateHertz = 44100;
        $languageCode = 'en-US';
        $recognitionConfig = new RecognitionConfig();
        $recognitionConfig->setEncoding($encoding);
        $recognitionConfig->setSampleRateHertz($sampleRateHertz);
        $recognitionConfig->setLanguageCode($languageCode);
        return $recognitionConfig;
    }

    /**
     * @dataProvider createRecognitionAudioDataProvider
     */
    public function testCreateRecognitionAudio($audio, $expectedRequestMessage)
    {
        $actualRequestMessage = $this->client->createRecognitionAudio($audio);
        $this->assertEquals($expectedRequestMessage->serializeToJsonString(), $actualRequestMessage->serializeToJsonString());
    }

    public function createRecognitionAudioDataProvider()
    {
        $uri = 'gs://my-bucket/my-audio.flac';
        $data = 'abcdefgh';
        $resourceData = 'zyxwvuts';
        $resource = $this->createResource($resourceData);
        $recognitionAudio = (new RecognitionAudio())
            ->setContent('directRequestData');
        return [
            [$uri, (new RecognitionAudio())
                    ->setUri($uri)],
            [$data, (new RecognitionAudio())
                    ->setContent($data)],
            [$resource, (new RecognitionAudio())
                    ->setContent($resourceData)],
            [$recognitionAudio, $recognitionAudio]
        ];
    }

    /**
     * @dataProvider recognizeAudioStreamData
     */
    public function testRecognizeAudioStream($audio, $expectedContent)
    {
        $recognitionConfig = $this->createRecognitionConfig();
        $config = new StreamingRecognitionConfig();
        $config->setConfig($recognitionConfig);

        $expectedResponseStream = [
            new StreamingRecognizeResponse(),
            new StreamingRecognizeResponse(),
        ];

        $mockBidiStreamingCall = new MockBidiStreamingCall($expectedResponseStream);

        $this->transport->startBidiStreamingCall(Argument::allOf(
            Argument::type(Call::class),
            Argument::which('getMethod', 'google.cloud.speech.v1.Speech/StreamingRecognize')
        ),
            Argument::type('array')
        )
            ->shouldBeCalledTimes(1)
            ->willReturn(new BidiStream($mockBidiStreamingCall));

        $responseStream = $this->client->recognizeAudioStream($config, $audio);

        $this->assertSame($expectedResponseStream, iterator_to_array($responseStream));

        /** @var StreamingRecognizeRequest[] $receivedCalls */
        $receivedCalls = $mockBidiStreamingCall->popReceivedCalls();

        $expectedConfigMessage = new StreamingRecognizeRequest();
        $expectedConfigMessage->setStreamingConfig($config);

        // Expect one extra call, for the config message
        $this->assertSame(count($expectedContent) + 1, count($receivedCalls));
        $initialReceivedCall = array_shift($receivedCalls);
        $this->assertEquals($expectedConfigMessage, $initialReceivedCall);
        for ($i = 0; $i < count($expectedContent); $i++) {
            $this->assertSame($expectedContent[$i], $receivedCalls[$i]->getAudioContent());
        }
    }

    public function recognizeAudioStreamData()
    {
        $data = 'abcdefgh';
        $iterableData = ['abcd', 'efgh'];
        $resourceData = 'zyxwvuts';
        $streamingData = '12345678';
        $resource = $this->createResource($resourceData);
        $streamingRecognizeRequest = new StreamingRecognizeRequest();
        $streamingRecognizeRequest->setAudioContent($streamingData);
        return [
            [$data, [$data]],
            [$iterableData, $iterableData],
            [[$streamingRecognizeRequest], [$streamingData]],
            [$resource, [$resourceData]]
        ];
    }

    private function createResource($data)
    {
        $resource = fopen('php://memory','r+');
        fwrite($resource, $data);
        rewind($resource);
        return $resource;
    }
}
