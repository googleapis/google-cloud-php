<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Core\Upload;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Upload data to Cloud Storage using a Signed URL
 */
class SignedUrlUploader extends ResumableUploader
{
    /**
     * Creates the resume URI.
     *
     * @return string
     */
    protected function createResumeUri()
    {
        $headers = [
            'Content-Type' => $this->contentType,
            'Content-Length' => 0,
            'x-goog-resumable' => 'start'
        ];

        $request = new Request(
            'POST',
            $this->uri,
            $headers
        );

        $response = $this->requestWrapper->send($request, $this->requestOptions);
        return $this->resumeUri = $response->getHeaderLine('Location');
    }

    /**
     * Decode the response body
     *
     * @param ReponseInterface $response
     * @return string
     */
    protected function decodeResponse(ResponseInterface $response)
    {
        return $response->getBody();
    }
}
