<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may ob`tain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Upload;

use GuzzleHttp\Psr7\BufferStream;
use GuzzleHttp\Psr7\Request;

/**
 * Uploader that is a special case of the ResumableUploader where we can write
 * the file contents in a streaming manner.
 */
class StreamableUploader extends ResumableUploader
{
    const DEFAULT_WRITE_CHUNK_SIZE = 262144;

    /**
     * @param RequestWrapper $requestWrapper
     * @param string|resource|StreamInterface $data
     * @param string $uri
     * @param array $options [optional] {
     *     Optional configuration.
     *
     *     @type array $metadata Metadata on the resource.
     *     @type int $chunkSize Size of the chunks to send incrementally during
     *           a resumable upload. Must be in multiples of 262144 bytes.
     *     @type array $httpOptions HTTP client specific configuration options.
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type string $contentType Content type of the resource.
     * }
     */
    public function __construct()
    {
        call_user_func_array(array($this, 'parent::__construct'), func_get_args());
        $this->resetBuffer($this->data);
        $this->chunkSize = $this->chunkSize ?: self::DEFAULT_WRITE_CHUNK_SIZE;
    }

    /**
     * Ensure we close the stream when this uploader is destroyed.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Write some partial data. If there's enough data to send a chunk,
     * then we will send a chunk. Any remaining data is sent on close.
     *
     * @param mixed $data The data being written. Can be a string or stream.
     * @return int The number of bytes written.
     */
    public function write($data)
    {
        // append data onto buffer
        $this->buffer->write($data);
        $this->upload(false);
        return strlen($data);
    }

    /**
     * Triggers the upload process.
     *
     * @param bool $remainder If true, send the all the remaining data and close
     *        the file. Otherwise, only write data if we have enough to send a
     *        chucked set.
     * @return array
     * @throws GoogleException
     */
    public function upload($remainder = true)
    {
        // determine how much data to write
        $writeSize = $this->getChunkedWriteSize($remainder);
        if ($writeSize == 0) {
            return [];
        }

        // find or create the resumeUri
        $resumeUri = $this->getResumeUri();

        $rangeStart = $this->rangeStart;
        $rangeEnd = $remainder ? "*" : $rangeStart + $writeSize - 1;

        $data = $this->buffer->read($writeSize);

        // do the streaming write
        $headers = [
            'Content-Length'    => $writeSize,
            'Content-Type'      => $this->contentType,
            'Content-Range'     => "bytes $rangeStart-$rangeEnd/*"
        ];
        $request = new Request(
            'PUT',
            $resumeUri,
            $headers,
            $data
        );

        try {
            $response = $this->requestWrapper->send($request, $this->requestOptions);
        } catch (Google\Cloud\Exception\ServiceException $ex) {
            throw new GoogleException(
                "Upload failed. Please use this URI to resume your upload: $resumeUri",
                $ex->getCode()
            );
        }

        // reset the buffer with the remaining contents
        $this->resetBuffer($this->buffer->getContents());
        $this->rangeStart += $writeSize;

        return json_decode($response->getBody(), true);
    }

    /**
     * Determines the length of content to write
     *
     * @return int
     */
    private function getChunkedWriteSize($remainder)
    {
        $bufferSize = $this->buffer->getSize();
        if ($remainder) {
            return $bufferSize;
        } else {
            return floor($bufferSize / $this->chunkSize) * $this->chunkSize;
        }
    }

    /**
     * Finish writing the rest of the file.
     */
    public function close()
    {
        $this->upload();
    }

    /**
     * After we've sent data, create a new buffer with the remaining data.
     *
     * @param string $data The data to store.
     */
    private function resetBuffer($data = "")
    {
        $this->buffer = new BufferStream($this->chunkSize);
        $this->buffer->write($data);
    }
}
