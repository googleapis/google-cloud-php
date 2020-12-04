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
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/texttospeech/v1/cloud_tts.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\TextToSpeech\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\ListVoicesRequest;
use Google\Cloud\TextToSpeech\V1\ListVoicesResponse;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

/**
 * Service Description: Service that implements Google Cloud Text-to-Speech API.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $textToSpeechClient = new TextToSpeechClient();
 * try {
 *     $response = $textToSpeechClient->listVoices();
 * } finally {
 *     $textToSpeechClient->close();
 * }
 * ```
 */
class TextToSpeechGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.texttospeech.v1.TextToSpeech';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'texttospeech.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
    ];

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/text_to_speech_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/text_to_speech_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/text_to_speech_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/text_to_speech_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'texttospeech.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Returns a list of Voice supported for synthesis.
     *
     * Sample code:
     * ```
     * $textToSpeechClient = new TextToSpeechClient();
     * try {
     *     $response = $textToSpeechClient->listVoices();
     * } finally {
     *     $textToSpeechClient->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $languageCode
     *          Optional. Recommended.
     *          [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt) language tag. If
     *          specified, the ListVoices call will only return voices that can be used to
     *          synthesize this language_code. E.g. when specifying "en-NZ", you will get
     *          supported "en-\*" voices; when specifying "no", you will get supported
     *          "no-\*" (Norwegian) and "nb-\*" (Norwegian Bokmal) voices; specifying "zh"
     *          will also get supported "cmn-\*" voices; specifying "zh-hk" will also get
     *          supported "yue-\*" voices.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\TextToSpeech\V1\ListVoicesResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function listVoices(array $optionalArgs = [])
    {
        $request = new ListVoicesRequest();
        if (isset($optionalArgs['languageCode'])) {
            $request->setLanguageCode($optionalArgs['languageCode']);
        }

        return $this->startCall(
            'ListVoices',
            ListVoicesResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Synthesizes speech synchronously: receive results after all text input
     * has been processed.
     *
     * Sample code:
     * ```
     * $textToSpeechClient = new TextToSpeechClient();
     * try {
     *     $input = new SynthesisInput();
     *     $voice = new VoiceSelectionParams();
     *     $audioConfig = new AudioConfig();
     *     $response = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
     * } finally {
     *     $textToSpeechClient->close();
     * }
     * ```
     *
     * @param SynthesisInput       $input        Required. The Synthesizer requires either plain text or SSML as input.
     * @param VoiceSelectionParams $voice        Required. The desired voice of the synthesized audio.
     * @param AudioConfig          $audioConfig  Required. The configuration of the synthesized audio.
     * @param array                $optionalArgs {
     *                                           Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse
     *
     * @throws ApiException if the remote call fails
     */
    public function synthesizeSpeech($input, $voice, $audioConfig, array $optionalArgs = [])
    {
        $request = new SynthesizeSpeechRequest();
        $request->setInput($input);
        $request->setVoice($voice);
        $request->setAudioConfig($audioConfig);

        return $this->startCall(
            'SynthesizeSpeech',
            SynthesizeSpeechResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
