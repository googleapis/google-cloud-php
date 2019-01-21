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

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

namespace Google\Cloud\TextToSpeech\Tests\System\V1;

use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\ApiCore\Testing\GeneratedTest;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

/**
 * @group texttospeech
 * @group gapic
 */
class TextToSpeechSmokeTest extends GeneratedTest
{
    /**
     * @test
     */
    public function synthesizeSpeechTest()
    {
        $textToSpeechClient = new TextToSpeechClient();
        $text = 'test';
        $input = new SynthesisInput();
        $input->setText($text);
        $languageCode = 'en-US';
        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode($languageCode);
        $audioEncoding = AudioEncoding::MP3;
        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding($audioEncoding);
        $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
    }
}
