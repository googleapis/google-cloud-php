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
    /**
     * Callback handler for when a stream is opened. For reads, we need to
     * download the file to see if it can be opened.
     *
     * @return bool
     */
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
        if (array_key_exists($name, $this->getOptions())) {
            return $this->getOptions()[$name];
        }
        return null;
    }

    private function getOptions()
    {
        if (!isset($this->options)) {
            $options = stream_context_get_options($this->context);
            if (array_key_exists($this->protocol, $options)) {
                $this->options = $options[$this->protocol] ?: [];
            } else {
                $this->options = [];
            }
        }
        return $this->options;
    }

    private function getStream()
    {
        return $this->stream;
    }

    private function isWriteable()
    {
        return in_array($this->mode, ['w', 'wb', 'wt']);
    }

    private function isReadable()
    {
        return in_array($this->mode, ['r', 'rb', 'rt']);
    }

    // @codingStandardsIgnoreStart
    /**
     * Callback handler for when we try to read a certain number of bytes.
     *
     * @param int $count The number of bytes to read.
     *
     * @return string
     */
    public function stream_read($count)
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->read($count);
    }

    // @codingStandardsIgnoreStart
    /**
     * Callback handler for when we try to write data to the stream.
     *
     * @param string|stream $data The data to write
     *
     * @return int The number of bytes written.
     */
    public function stream_write($data)
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->write($data);
    }

    // @codingStandardsIgnoreStart
    /**
     * Callback handler for getting data about the stream.
     *
     * @return array
     */
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
    /**
     * Callback handler for checking to see if the stream is at the end of file.
     *
     * @return bool
     */
    public function stream_eof()
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->eof();
    }

    // @codingStandardsIgnoreStart
    /**
     * Callback handler for trying to close the stream.
     */
    public function stream_close()
    {
        // @codingStandardsIgnoreEnd
        if (isset($this->stream)) {
            $this->getStream()->close();
        }
    }

    // @codingStandardsIgnoreStart
    /**
     * Callback handler for trying to seek to a certain location in the stream.
     */
    public function stream_seek(int $offset, int $whence)
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->seek($offset, $whence);
    }

    // @codingStandardsIgnoreStart
    /**
     * Callhack handler for inspecting our current position in the stream
     *
     * @return int
     */
    public function stream_tell()
    {
        // @codingStandardsIgnoreEnd
        return $this->getStream()->tell();
    }
}
