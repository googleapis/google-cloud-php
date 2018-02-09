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

namespace Google\Cloud\Tests\Unit\Speech\V1;

use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\Testing\MockBidiStreamingCall;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig_AudioEncoding;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\StreamingRecognitionConfig;
use Google\Cloud\Speech\V1\StreamingRecognitionResult;
use Google\Cloud\Speech\V1\StreamingRecognizeRequest;
use Google\Cloud\Speech\V1\StreamingRecognizeResponse;
use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @group speech
 */
class SpeechClientTest extends TestCase
{
    private $client;
    private $transport;

    public function setUp()
    {
        $this->transport = $this->prophesize(TransportInterface::class);
        $this->client = new SpeechClient([
            'transport' => $this->transport->reveal(),
        ]);
    }

    public function testCreateRequestStream()
    {
        $expectedStream = [
            (new StreamingRecognizeRequest())->setAudioContent("abcd"),
            (new StreamingRecognizeRequest())->setAudioContent("efg"),
        ];

        $chunks = ["abcd", "efg"];
        $requestStream = $this->client->createRequestStream($chunks);

        $this->assertEquals($expectedStream, iterator_to_array($requestStream));
    }

    public function testRecognizeAudioStream()
    {
        $encoding = RecognitionConfig_AudioEncoding::FLAC;
        $sampleRateHertz = 44100;
        $languageCode = 'en-US';
        $recognitionConfig = new RecognitionConfig();
        $recognitionConfig->setEncoding($encoding);
        $recognitionConfig->setSampleRateHertz($sampleRateHertz);
        $recognitionConfig->setLanguageCode($languageCode);
        $config = new StreamingRecognitionConfig();
        $config->setConfig($recognitionConfig);

        $f = $this->createResource("abcdefgh");
        $audioStream = $this->client->createAudioStream($f, 5);

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

        $responseStream = $this->client->recognizeAudioStream($config, $audioStream);

        $this->assertSame($expectedResponseStream, iterator_to_array($responseStream));

        /** @var StreamingRecognizeRequest[] $receivedCalls */
        $receivedCalls = $mockBidiStreamingCall->popReceivedCalls();

        $expectedConfigMessage = new StreamingRecognizeRequest();
        $expectedConfigMessage->setStreamingConfig($config);

        $this->assertSame(3, count($receivedCalls));
        $this->assertEquals($expectedConfigMessage, $receivedCalls[0]);
        $this->assertSame("abcde", $receivedCalls[1]->getAudioContent());
        $this->assertSame("fgh", $receivedCalls[2]->getAudioContent());
    }

    private function createResource($data)
    {
        $resource = fopen('php://memory','r+');
        fwrite($resource, $data);
        rewind($resource);
        return $resource;
    }
}
