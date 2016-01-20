<?php

namespace Google\Cloud;

use Google\Cloud\Storage\StorageClient;

class Client
{
    const VERSION = '0.0.1';

    /**
     * @var array Configuration details to be used between clients.
     */
    private $config;

    /**
     * Pass in an array of configuration parameters to construct your client.
     *
     * Example:
     * ```
     * $client = new Client([
     *     'keyFilePath' => '/path/to/key/file.json',
     *     'projectId' => 'myAwesomeProject'
     * ]);
     * ```
     *
     * @param array $config Configuration options. {
     *     @type callable $httpHandler Override the default http handler.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developers Console.
     *     @type string $projectId The project ID created in the Google
     *           Developers Console.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @return StorageClient
     */
    public function storage()
    {
        return new StorageClient($this->config);
    }
}
