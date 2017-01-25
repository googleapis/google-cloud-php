<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Storage;

use Google\Cloud\Exception\GoogleException;

/**
 * A streamWrapper implementation for handling `gs://bucket/path/to/file.jpg`
 *
 * See: http://php.net/manual/en/class.streamwrapper.php
 */
class StreamWrapper
{
    // Must be public according to the PHP documentation
    public $context;

    // a GuzzleHttp\Psr7\StreamInterface instance
    private $stream;

    private $protocol;
    private $bucket;
    private $file;
    private $mode;
    private $options;

    /**
     * @var StorageClient $defaultClient The default client to use if using
     *      global methods such as fopen on a stream wrapper.
     */
    private static $client;

    /**
     * Ensure we close the stream when this StreamWrapper is destroyed.
     */
    public function __destruct()
    {
        $this->stream_close();
    }

    /**
     * Register a StreamWrapper for reading and writing to Google Storage
     *
     * @param string $protocol The name of the protocol to use. Defaults to
     *        'gs'.
     * @throws \RuntimeException
     */
    public static function register(string $protocol = null)
    {
        $protocol = $protocol ?: 'gs';
        if (!in_array($protocol, stream_get_wrappers())) {
            if (!stream_wrapper_register($protocol, StreamWrapper::class)) {
                throw new RuntimeException("Failed to register '$protocol://' protocol");
            }
            return true;
        }
        return false;
    }

    /**
     * Unregisters the SteamWrapper
     *
     * @param string $protocol The name of the protocol to unregister. Defaults
     *        to 'gs'.
     */
    public static function unregister(string $protocol = null)
    {
        stream_wrapper_unregister($protocol ?: 'gs');
    }

    /**
     * Get the default client to use for streams.
     *
     * @return StorageClient
     */
    public static function getClient()
    {
        return self::$client;
    }

    /**
     * Set the default client to use for streams.
     *
     * @param StorageClient $client
     */
    public static function setClient($client)
    {
        self::$client = $client;
    }

    // @codingStandardsIgnoreStart
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        // @codingStandardsIgnoreEnd
        $url = parse_url($path);
        $this->protocol = $url['scheme'];
        $this->file = substr($url['path'], 1);
        $this->mode = $mode;

        $client = $this->getOption('client') ?: self::getClient();
        $this->bucket = $client->bucket($url['host']);

        if ($this->isWriteable()) {
            $this->stream = $this->bucket->getStreamableUploader(
                '',
                ['name' => $this->file] + $this->getOptions()
            );
        } elseif ($this->isReadable()) {
            try {
                $this->stream = $this->bucket->object($this->file)->downloadAsStream($this->getOptions());
            } catch (GoogleException $ex) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    private function getOption($name, $default = null)
    {
        return $this->getOptions()[$name] ?: null;
    }

    private function getOptions()
    {
        if (!isset($this->options)) {
            $this->options = stream_context_get_options($this->context)[$this->protocol] ?: [];
        }
        return $this->options;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function isWriteable()
    {
        return in_array($this->mode, ['w', 'wb', 'wt']);
    }

    public function isReadable()
    {
        return in_array($this->mode, ['r', 'rb', 'rt']);
    }

    // @codingStandardsIgnoreStart
    public function stream_read($count)
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->read($count);
    }

    // @codingStandardsIgnoreStart
    public function stream_write($data)
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->write($data);
    }

    // @codingStandardsIgnoreStart
    public function stream_stat()
    {
        // @codingStandardsIgnoreEnd
        return [
            'dev'     => 0,
            'ino'     => 0,
            'mode'    => $this->isWriteable() ? 33188 : 33060, // equivalent to 10644 and 10444 in octal
            'nlink'   => 0,
            'uid'     => 0,
            'gid'     => 0,
            'rdev'    => 0,
            'size'    => $this->getStream()->getSize(),
            'atime'   => 0,
            'mtime'   => 0,
            'ctime'   => 0,
            'blksize' => 0,
            'blocks'  => 0
        ];
    }

    // @codingStandardsIgnoreStart
    public function stream_eof()
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->eof();
    }

    // @codingStandardsIgnoreStart
    public function stream_close()
    {
        // @codingStandardsIgnoreEnd
        if (isset($this->stream)) {
            $this->getStream()->close();
        }
    }

    // @codingStandardsIgnoreStart
    public function stream_seek(...$args)
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->seek(...$args);
    }

    // @codingStandardsIgnoreStart
    public function stream_tell()
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->tell();
    }
}
