<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Upload;

use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Core\JsonTrait;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\LimitStream;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Resumable upload implementation.
 */
class ResumableUploader extends AbstractUploader
{
    use JsonTrait;

    /**
     * @var int
     */
    protected $rangeStart = 0;

    /**
     * @var string
     */
    private $resumeUri;

    /**
     * Gets the resume URI.
     *
     * @return string
     */
    public function getResumeUri()
    {
        if (!$this->resumeUri) {
            return $this->createResumeUri();
        }

        return $this->resumeUri;
    }

    /**
     * Resumes a download using the provided URI.
     *
     * @param string $resumeUri
     * @return array
     * @throws GoogleException
     */
    public function resume($resumeUri)
    {
        if (!$this->data->isSeekable()) {
            throw new GoogleException('Cannot resume upload on a stream which cannot be seeked.');
        }

        $this->resumeUri = $resumeUri;
        $response = $this->getStatusResponse();

        if ($response->getBody()->getSize() > 0) {
            return $this->jsonDecode($response->getBody(), true);
        }

        $this->rangeStart = $this->getRangeStart($response->getHeaderLine('Range'));

        return $this->upload();
    }

    /**
     * Triggers the upload process.
     *
     * @return array
     * @throws GoogleException
     */
    public function upload()
    {
        $rangeStart = $this->rangeStart;
        $response = null;
        $resumeUri = $this->getResumeUri();
        $size = $this->data->getSize() ?: '*';

        do {
            $data = new LimitStream(
                $this->data,
                $this->chunkSize ?: - 1,
                $rangeStart
            );
            $rangeEnd = $rangeStart + ($data->getSize() - 1);
            $headers = [
                'Content-Length' => $data->getSize(),
                'Content-Type' => $this->contentType,
                'Content-Range' => "bytes $rangeStart-$rangeEnd/$size",
            ];

            $request = new Request(
                'PUT',
                $resumeUri,
                $headers,
                $data
            );

            try {
                $response = $this->requestWrapper->send($request, $this->requestOptions);
            } catch (GoogleException $ex) {
                throw new GoogleException(
                    "Upload failed. Please use this URI to resume your upload: $this->resumeUri",
                    $ex->getCode()
                );
            }

            $rangeStart = $this->getRangeStart($response->getHeaderLine('Range'));
        } while ($response->getStatusCode() === 308);

        return $this->jsonDecode($response->getBody(), true);
    }

    /**
     * Creates the resume URI.
     *
     * @return string
     */
    private function createResumeUri()
    {
        $headers = [
            'X-Upload-Content-Type' => $this->contentType,
            'X-Upload-Content-Length' => $this->data->getSize(),
            'Content-Type' => 'application/json'
        ];

        $request = new Request(
            'POST',
            $this->uri,
            $headers,
            $this->jsonEncode($this->metadata)
        );

        $response = $this->requestWrapper->send($request, $this->requestOptions);
        $this->resumeUri = $response->getHeaderLine('Location');

        return $this->resumeUri;
    }

    /**
     * Gets the status of the upload.
     *
     * @return ResponseInterface
     */
    private function getStatusResponse()
    {
        $request = new Request(
            'PUT',
            $this->resumeUri,
            ['Content-Range' => 'bytes */*']
        );

        return $this->requestWrapper->send($request, $this->requestOptions);
    }

    /**
     * Gets the starting range for the upload.
     *
     * @param string $rangeHeader
     * @return int
     */
    private function getRangeStart($rangeHeader)
    {
        if (!$rangeHeader) {
            return null;
        }

        return (int) explode('-', $rangeHeader)[1] + 1;
    }
}
