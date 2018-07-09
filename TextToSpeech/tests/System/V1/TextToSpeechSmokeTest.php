<?php
/*
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\TextToSpeech\Tests\System\V1;

use Google\ApiCore\Testing\GeneratedTest;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

/**
 * @group text-to-speech
 * @group gapic
 */
class TextToSpeechSmokeTest extends GeneratedTest
{
    /**
     * @test
     */
    public function annotateVideoTest()
    {
        $textToSpeechClient = new TextToSpeechClient();

        $input = new SynthesisInput();
        $input->setText('Japan\'s national soccer team won against Colombia!');
        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode('en-US');
        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::MP3);

        $resp = $textToSpeechClient->synthesizeSpeech(
            $input,
            $voice,
            $audioConfig
        );

        $this->assertNotNull($resp->getAudioContent());
    }
}
