<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use GuzzleHttp\Psr7\CachingStream;

/**
 * A streamWrapper implementation for handling `gs://bucket/path/to/file.jpg`.
 * Note that you can only open a file with mode 'r', 'rb', 'rt', 'w', 'wb', 'wt', 'a', 'ab', or 'at'.
 *
 * See: http://php.net/manual/en/class.streamwrapper.php
 */
class StreamWrapper
{
    const DEFAULT_PROTOCOL = 'gs';

    const FILE_WRITABLE_MODE = 33206; // 100666 in octal
    const FILE_READABLE_MODE = 33060; // 100444 in octal
    const DIRECTORY_WRITABLE_MODE = 16895; // 40777 in octal
    const DIRECTORY_READABLE_MODE = 16676; // 40444 in octal

    const TAIL_NAME_SUFFIX = '~';

    /**
     * @var resource|null Must be public according to the PHP documentation.
     *
     * Contains array of context options in form ['protocol' => ['option' => value]].
     * Options used by StreamWrapper:
     *
     * flush (bool) `true`: fflush() will flush output buffer; `false`: fflush() will do nothing
     */
    public $context;

    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private $stream;

    /**
     * @var string Protocol used to open this stream
     */
    private $protocol;

    /**
     * @var Bucket Reference to the bucket the opened file
     *      lives in or will live in.
     */
    private $bucket;

    /**
     * @var string Name of the file opened by this stream.
     */
    private $file;

    /**
     * @var StorageClient[] $clients The default clients to use if using
     *      global methods such as fopen on a stream wrapper. Keyed by protocol.
     */
    private static $clients = [];

    /**
     * @var ObjectIterator Used for iterating through a directory
     */
    private $directoryIterator;

    /**
     * @var StorageObject
     */
    private $object;

    /**
     * @var array Context options passed to stream_open(), used for append mode and flushing.
     */
    private $options = [];

    /**
     * @var bool `true`: fflush() will flush output buffer and redirect output to the "tail" object.
     */
    private $flushing = false;

    /**
     * @var string|null Content type for composed object. Will be filled on first composing.
     */
    private $contentType = null;

    /**
     * @var bool `true`: writing the "tail" object, next fflush() or fclose() will compose.
     */
    private $composing = false;

    /**
     * @var bool `true`: data has been written to the stream.
     */
    private $dirty = false;

    /**
     * Ensure we close the stream when this StreamWrapper is destroyed.
     */
    public function __destruct()
    {
        $this->stream_close();
    }

    /**
     * This is called when include/require is used on a stream.
     */
    public function stream_set_option()
    {
        return false;
    }

    /**
     * This is called when touch is used on a stream. See:
     * https://www.php.net/manual/en/streamwrapper.stream-metadata.php
     */
    public function stream_metadata($path, $option, $value)
    {
        if ($option == STREAM_META_TOUCH) {
            $this->openPath($path);
            return $this->touch();
        }

        return false;
    }

    /**
     * Creates an empty file if it does not exist.
     * @return bool Returns true if file exists or has been created, false otherwise.
     */
    private function touch()
    {
        $object = $this->bucket->object($this->file);
        try {
            if (!$object->exists()) {
                $this->bucket->upload('', [
                    'name' => $this->file
                ]);
            }
            return true;
        } catch (NotFoundException $e) {
        }
        return false;
    }

    /**
     * Register a StreamWrapper for reading and writing to Google Storage
     *
     * @param StorageClient $client The StorageClient configuration to use.
     * @param string $protocol The name of the protocol to use. **Defaults to**
     *        `gs`.
     * @throws \RuntimeException
     */
    public static function register(StorageClient $client, $protocol = null)
    {
        $protocol = $protocol ?: self::DEFAULT_PROTOCOL;
        if (!in_array($protocol, stream_get_wrappers())) {
            if (!stream_wrapper_register($protocol, StreamWrapper::class, STREAM_IS_URL)) {
                throw new \RuntimeException("Failed to register '$protocol://' protocol");
            }
            self::$clients[$protocol] = $client;
            return true;
        }
        return false;
    }

    /**
     * Unregisters the SteamWrapper
     *
     * @param string $protocol The name of the protocol to unregister. **Defaults
     *        to** `gs`.
     */
    public static function unregister($protocol = null)
    {
        $protocol = $protocol ?: self::DEFAULT_PROTOCOL;
        stream_wrapper_unregister($protocol);
        unset(self::$clients[$protocol]);
    }

    /**
     * Get the default client to use for streams.
     *
     * @param string $protocol The name of the protocol to get the client for.
     *        **Defaults to** `gs`.
     * @return StorageClient
     */
    public static function getClient($protocol = null)
    {
        $protocol = $protocol ?: self::DEFAULT_PROTOCOL;
        return self::$clients[$protocol];
    }

    /**
     * Callback handler for when a stream is opened. For reads, we need to
     * download the file to see if it can be opened.
     *
     * @param string $path The path of the resource to open
     * @param string $mode The fopen mode. Currently supports ('r', 'rb', 'rt', 'w', 'wb', 'wt', 'a', 'ab', 'at')
     * @param int $flags Bitwise options STREAM_USE_PATH|STREAM_REPORT_ERRORS|STREAM_MUST_SEEK
     * @param string $openedPath Will be set to the path on success if STREAM_USE_PATH option is set
     * @return bool
     */
    public function stream_open($path, $mode, $flags, &$openedPath)
    {
        $this->openPath($path);

        // strip off 'b' or 't' from the mode
        $mode = rtrim($mode, 'bt');

        $options = [];
        if ($this->context) {
            $contextOptions = stream_context_get_options($this->context);
            if (array_key_exists($this->protocol, $contextOptions)) {
                $options = $contextOptions[$this->protocol] ?: [];
            }

            if (isset($options['flush'])) {
                $this->flushing = (bool) $options['flush'];
                unset($options['flush']);
            }

            $this->options = $options;
        }

        if ($mode == 'w') {
            $this->stream = new WriteStream(null, $options);
            $this->stream->setUploader(
                $this->bucket->getStreamableUploader(
                    $this->stream,
                    $options + ['name' => $this->file]
                )
            );
        } elseif ($mode == 'a') {
            try {
                $info = $this->bucket->object($this->file)->info();
                $this->composing = ($info['size'] > 0);
            } catch (NotFoundException $e) {
            }

            $this->stream = new WriteStream(null, $options);
            $name = $this->file;
            if ($this->composing) {
                $name .= self::TAIL_NAME_SUFFIX;
            }
            $this->stream->setUploader(
                $this->bucket->getStreamableUploader(
                    $this->stream,
                    $options + ['name' => $name]
                )
            );
        } elseif ($mode == 'r') {
            try {
                // Lazy read from the source
                $options['restOptions']['stream'] = true;
                $this->stream = new ReadStream(
                    $this->bucket->object($this->file)->downloadAsStream($options)
                );

                // Wrap the response in a caching stream to make it seekable
                if (!$this->stream->isSeekable() && ($flags & STREAM_MUST_SEEK)) {
                    $this->stream = new CachingStream($this->stream);
                }
            } catch (ServiceException $ex) {
                return $this->returnError($ex->getMessage(), $flags);
            }
        } else {
            return $this->returnError('Unknown stream_open mode.', $flags);
        }

        if ($flags & STREAM_USE_PATH) {
            $openedPath = $path;
        }
        return true;
    }

    /**
     * Callback handler for when we try to read a certain number of bytes.
     *
     * @param int $count The number of bytes to read.
     *
     * @return string
     */
    public function stream_read($count)
    {
        return $this->stream->read($count);
    }

    /**
     * Callback handler for when we try to write data to the stream.
     *
     * @param string $data The data to write
     *
     * @return int The number of bytes written.
     */
    public function stream_write($data)
    {
        $result = $this->stream->write($data);
        $this->dirty = $this->dirty || (bool) $result;
        return $result;
    }

    /**
     * Callback handler for getting data about the stream.
     *
     * @return array
     */
    public function stream_stat()
    {
        $mode = $this->stream->isWritable()
            ? self::FILE_WRITABLE_MODE
            : self::FILE_READABLE_MODE;
        return $this->makeStatArray([
            'mode'    => $mode,
            'size'    => $this->stream->getSize()
        ]);
    }

    /**
     * Callback handler for checking to see if the stream is at the end of file.
     *
     * @return bool
     */
    public function stream_eof()
    {
        return $this->stream->eof();
    }

    /**
     * Callback handler for trying to close the stream.
     */
    public function stream_close()
    {
        if (isset($this->stream)) {
            $this->stream->close();
        }

        if ($this->composing) {
            if ($this->dirty) {
                $this->compose();
                $this->dirty = false;
            }
            try {
                $this->bucket->object($this->file . self::TAIL_NAME_SUFFIX)->delete();
            } catch (NotFoundException $e) {
            }
            $this->composing = false;
        }
    }

    /**
     * Callback handler for trying to seek to a certain location in the stream.
     *
     * @param int $offset The stream offset to seek to
     * @param int $whence Flag for what the offset is relative to. See:
     *        http://php.net/manual/en/streamwrapper.stream-seek.php
     * @return bool
     */
    public function stream_seek($offset, $whence = SEEK_SET)
    {
        if ($this->stream->isSeekable()) {
            $this->stream->seek($offset, $whence);
            return true;
        }
        return false;
    }

    /**
     * Callhack handler for inspecting our current position in the stream
     *
     * @return int
     */
    public function stream_tell()
    {
        return $this->stream->tell();
    }

    /**
     * Callback handler for trying to close an opened directory.
     *
     * @return bool
     */
    public function dir_closedir()
    {
        return false;
    }

    /**
     * Callback handler for trying to open a directory.
     *
     * @param string $path The url directory to open
     * @param int $options Whether or not to enforce safe_mode
     * @return bool
     */
    public function dir_opendir($path, $options)
    {
        $this->openPath($path);
        return $this->dir_rewinddir();
    }

    /**
     * Callback handler for reading an entry from a directory handle.
     *
     * @return string|bool
     */
    public function dir_readdir()
    {
        $name = $this->directoryIterator->current();
        if ($name) {
            $this->directoryIterator->next();

            return $name;
        }

        return false;
    }

    /**
     * Callback handler for rewind the directory handle.
     *
     * @return bool
     */
    public function dir_rewinddir()
    {
        try {
            $iterator = $this->bucket->objects([
                'prefix' => $this->file,
                'fields' => 'items/name,nextPageToken'
            ]);

            // The delimiter options do not give us what we need, so instead we
            // list all results matching the given prefix, enumerate the
            // iterator, filter and transform results, and yield a fresh
            // generator containing only the directory listing.
            $this->directoryIterator = call_user_func(function () use ($iterator) {
                $yielded = [];
                $pathLen = strlen($this->makeDirectory($this->file));
                foreach ($iterator as $object) {
                    $name = substr($object->name(), $pathLen);
                    $parts = explode('/', $name);

                    // since the service call returns nested results and we only
                    // want to yield results directly within the requested directory,
                    // check if we've already yielded this value.
                    if ($parts[0] === '' || in_array($parts[0], $yielded)) {
                        continue;
                    }

                    $yielded[] = $parts[0];
                    yield $name => $parts[0];
                }
            });
        } catch (ServiceException $e) {
            return false;
        }
        return true;
    }

    /**
     * Callback handler for trying to create a directory. If no file path is specified,
     * or STREAM_MKDIR_RECURSIVE option is set, then create the bucket if it does not exist.
     *
     * @param string $path The url directory to create
     * @param int $mode The permissions on the directory
     * @param int $options Bitwise mask of options. STREAM_MKDIR_RECURSIVE
     * @return bool
     */
    public function mkdir($path, $mode, $options)
    {
        $path = $this->makeDirectory($path);
        $client = $this->openPath($path);
        $predefinedAcl = $this->determineAclFromMode($mode);

        try {
            if ($options & STREAM_MKDIR_RECURSIVE || $this->file == '') {
                if (!$this->bucket->exists()) {
                    $client->createBucket($this->bucket->name(), [
                        'predefinedAcl' => $predefinedAcl,
                        'predefinedDefaultObjectAcl' => $predefinedAcl
                    ]);
                }
            }

            // If the file name is empty, we were trying to create a bucket. In this case,
            // don't create the placeholder file.
            if ($this->file != '') {
                $bucketInfo = $this->bucket->info();
                $ublEnabled = isset($bucketInfo['iamConfiguration']['uniformBucketLevelAccess']) &&
                    $bucketInfo['iamConfiguration']['uniformBucketLevelAccess']['enabled'] === true;

                // if bucket has uniform bucket level access enabled, don't set ACLs.
                $acl = [];
                if (!$ublEnabled) {
                    $acl = [
                        'predefinedAcl' => $predefinedAcl
                    ];
                }

                // Fake a directory by creating an empty placeholder file whose name ends in '/'
                $this->bucket->upload('', [
                    'name' => $this->file,
                ] + $acl);
            }
        } catch (ServiceException $e) {
            return false;
        }
        return true;
    }

    /**
     * Callback handler for trying to move a file or directory.
     *
     * @param string $from The URL to the current file
     * @param string $to The URL of the new file location
     * @return bool
     */
    public function rename($from, $to)
    {
        $this->openPath($from);
        $destination = (array) parse_url($to) + [
            'path' => '',
            'host' => ''
        ];

        $destinationBucket = $destination['host'];
        $destinationPath = substr($destination['path'], 1);

        // loop through to rename file and children, if given path is a directory.
        $objects = $this->bucket->objects([
            'prefix' => $this->file
        ]);

        foreach ($objects as $obj) {
            $oldName = $obj->name();
            $newPath = str_replace($this->file, $destinationPath, $oldName);
            try {
                $obj->rename($newPath, [
                    'destinationBucket' => $destinationBucket
                ]);
            } catch (ServiceException $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * Callback handler for trying to remove a directory or a bucket. If the path is empty
     * or '/', the bucket will be deleted.
     *
     * Note that the STREAM_MKDIR_RECURSIVE flag is ignored because the option cannot
     * be set via the `rmdir()` function.
     *
     * @param string $path The URL directory to remove. If the path is empty or is '/',
     *        This will attempt to destroy the bucket.
     * @param int $options Bitwise mask of options.
     * @return bool
     */
    public function rmdir($path, $options)
    {
        $path = $this->makeDirectory($path);
        $this->openPath($path);

        try {
            if ($this->file == '') {
                $this->bucket->delete();
                return true;
            } else {
                return $this->unlink($path);
            }
        } catch (ServiceException $e) {
            return false;
        }
    }

    /**
     * Callback handler for retrieving the underlaying resource
     *
     * @param int $castAs STREAM_CAST_FOR_SELECT|STREAM_CAST_AS_STREAM
     * @return resource|bool
     */
    public function stream_cast($castAs)
    {
        return false;
    }

    /**
     * Callback handler for deleting a file
     *
     * @param string $path The URL of the file to delete
     * @return bool
     */
    public function unlink($path)
    {
        $client = $this->openPath($path);
        $object = $this->bucket->object($this->file);

        try {
            $object->delete();
            return true;
        } catch (ServiceException $e) {
            return false;
        }
    }

    /**
     * Callback handler for retrieving information about a file
     *
     * @param string $path The URI to the file
     * @param int $flags Bitwise mask of options
     * @return array|bool
     */
    public function url_stat($path, $flags)
    {
        $client = $this->openPath($path);

        // if directory
        $dir = $this->getDirectoryInfo($this->file);
        if ($dir) {
            return $this->urlStatDirectory($dir);
        }

        return $this->urlStatFile();
    }

    /**
     * Callback handler for fflush() function.
     *
     * @return bool
     */
    public function stream_flush()
    {
        if (!$this->flushing) {
            return false;
        }

        if (!$this->dirty) {
            return true;
        }

        if (isset($this->stream)) {
            $this->stream->close();
        }

        if ($this->composing) {
            $this->compose();
        }

        $options = $this->options;
        $this->stream = new WriteStream(null, $options);
        $this->stream->setUploader(
            $this->bucket->getStreamableUploader(
                $this->stream,
                $options + ['name' => $this->file . self::TAIL_NAME_SUFFIX]
            )
        );
        $this->composing = true;
        $this->dirty = false;

        return true;
    }

    /**
     * Parse the URL and set protocol, filename and bucket.
     *
     * @param  string $path URL to open
     * @return StorageClient
     */
    private function openPath($path)
    {
        $url = (array) parse_url($path) + [
            'scheme' => '',
            'path' => '',
            'host' => ''
        ];
        $this->protocol = $url['scheme'];
        $this->file = ltrim($url['path'], '/');
        $client = self::getClient($this->protocol);
        $this->bucket = $client->bucket($url['host']);
        return $client;
    }

    /**
     * Given a path, ensure that we return a path that looks like a directory
     *
     * @param  string $path
     * @return string
     */
    private function makeDirectory($path)
    {
        if ($path == '' or $path == '/') {
            return '';
        }

        if (substr($path, -1) == '/') {
            return $path;
        }

        return $path . '/';
    }

    /**
     * Calculate the `url_stat` response for a directory
     *
     * @return array|bool
     */
    private function urlStatDirectory(StorageObject $object)
    {
        $stats = [];
        $info = $object->info();

        // equivalent to 40777 and 40444 in octal
        $stats['mode'] = $this->bucket->isWritable()
            ? self::DIRECTORY_WRITABLE_MODE
            : self::DIRECTORY_READABLE_MODE;
        $this->statsFromFileInfo($info, $stats);

        return $this->makeStatArray($stats);
    }

    /**
     * Calculate the `url_stat` response for a file
     *
     * @return array|bool
     */
    private function urlStatFile()
    {
        try {
            $this->object = $this->bucket->object($this->file);
            $info = $this->object->info();
        } catch (ServiceException $e) {
            // couldn't stat file
            return false;
        }

        // equivalent to 100666 and 100444 in octal
        $stats = [
            'mode' => $this->bucket->isWritable()
                ? self::FILE_WRITABLE_MODE
                : self::FILE_READABLE_MODE
        ];
        $this->statsFromFileInfo($info, $stats);
        return $this->makeStatArray($stats);
    }

    /**
     * Given a `StorageObject` info array, extract the available fields into the
     * provided `$stats` array.
     *
     * @param array $info Array provided from a `StorageObject`.
     * @param array $stats Array to put the calculated stats into.
     */
    private function statsFromFileInfo(array &$info, array &$stats)
    {
        $stats['size'] = (isset($info['size']))
            ? (int) $info['size']
            : null;

        $stats['mtime'] = (isset($info['updated']))
            ? strtotime($info['updated'])
            : null;

        $stats['ctime'] = (isset($info['timeCreated']))
            ? strtotime($info['timeCreated'])
            : null;
    }

    /**
     * Get the given path as a directory.
     *
     * In list objects calls, directories are returned with a trailing slash. By
     * providing the given path with a trailing slash as a list prefix, we can
     * check whether the given path exists as a directory.
     *
     * If the path does not exist or is not a directory, return null.
     *
     * @param  string $path
     * @return StorageObject|null
     */
    private function getDirectoryInfo($path)
    {
        $scan = $this->bucket->objects([
            'prefix' => $this->makeDirectory($path),
            'resultLimit' => 1,
            'fields' => 'items/name,items/size,items/updated,items/timeCreated,nextPageToken'
        ]);

        return $scan->current();
    }

    /**
     * Returns the associative array that a `stat()` response expects using the
     * provided stats. Defaults the remaining fields to 0.
     *
     * @param  array $stats Sparse stats entries to set.
     * @return array
     */
    private function makeStatArray($stats)
    {
        return array_merge(
            array_fill_keys([
                'dev',
                'ino',
                'mode',
                'nlink',
                'uid',
                'gid',
                'rdev',
                'size',
                'atime',
                'mtime',
                'ctime',
                'blksize',
                'blocks'
            ], 0),
            $stats
        );
    }

    /**
     * Helper for whether or not to trigger an error or just return false on an error.
     *
     * @param  string $message The PHP error message to emit.
     * @param  int $flags Bitwise mask of options (STREAM_REPORT_ERRORS)
     * @return bool Returns false
     */
    private function returnError($message, $flags)
    {
        if ($flags & STREAM_REPORT_ERRORS) {
            trigger_error($message, E_USER_WARNING);
        }
        return false;
    }

    /**
     * Helper for determining which predefinedAcl to use given a mode.
     *
     * @param  int $mode Decimal representation of the file system permissions
     * @return string
     */
    private function determineAclFromMode($mode)
    {
        if ($mode & 0004) {
            // If any user can read, assume it should be publicRead.
            return 'publicRead';
        } elseif ($mode & 0040) {
            // If any group user can read, assume it should be projectPrivate.
            return 'projectPrivate';
        }

        // Otherwise, assume only the project/bucket owner can use the bucket.
        return 'private';
    }

    private function compose()
    {
        if (!isset($this->contentType)) {
            $info = $this->bucket->object($this->file)->info();
            $this->contentType = $info['contentType'] ?: 'application/octet-stream';
        }
        $options = ['destination' => ['contentType' => $this->contentType]];
        $this->bucket->compose([$this->file, $this->file . self::TAIL_NAME_SUFFIX], $this->file, $options);
    }
}
