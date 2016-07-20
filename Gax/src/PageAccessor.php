<?php
/*
 * Copyright 2016, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\GAX;

use ArrayObject;
use Iterator;
use InvalidArgumentException;
use RuntimeException;

/**
 * Accessor for paged results from a list API method
 *
 * This is an implementation of Iterator which can be used for iterating resources from the pages
 * of a list method. If necessary it can perform more rpc calls to fetch more pages.
 *
 * @param array $params {
 *     The parameters used to make the API call.
 *     @type object the request object
 *     @type array the metadata
 *     @type array the options of the API call
 * }
 * @param Google\GAX\ApiCallable $callable the callable object that makes the API method calls.
 * @param Google\GAX\PageStreamingDescriptor $pageStreamingDescriptor the descriptor that
 *     contains the field names related to page-streaming.
 */
class PageAccessor implements Iterator
{
    private $parameters;
    private $pageStreamingDescriptor;
    private $initialToken;
    private $currentResponse = null;
    private $currentIterator = null;

    public function __construct($params, $callable, $pageStreamingDescriptor)
    {
        if (empty($params) || !is_object($params[0])) {
            throw new InvalidArgumentException('First argument must be a request object.');
        }
        $this->parameters = $params;
        $this->callable = $callable;
        $this->pageStreamingDescriptor = $pageStreamingDescriptor;

        $requestPageTokenField = $this->pageStreamingDescriptor->getRequestPageTokenField();
        $this->initialToken = $params[0]->$requestPageTokenField;
    }

    /**
     * Returns the token that can be used to fetch the next page.
     */
    public function nextPageToken()
    {
        $responsePageTokenField = $this->pageStreamingDescriptor->getResponsePageTokenField();
        return $this->getResponse()->$responsePageTokenField;
    }

    /**
     * Returns the resources of the current page.
     */
    public function currentPageValues()
    {
        $resourceField = $this->pageStreamingDescriptor->getResourceField();
        return $this->getResponse()->$resourceField;
    }

    public function rewind()
    {
        $request = $this->parameters[0];
        $requestPageTokenField = $this->pageStreamingDescriptor->getRequestPageTokenField();
        $request->$requestPageTokenField = $this->initialToken;
        $this->currentIterator = null;
    }

    public function current()
    {
        return $this->getIterator()->current();
    }

    public function next()
    {
        $iterator = $this->getIterator();
        if (isset($iterator)) {
            $this->getIterator()->next();
        }
    }

    public function valid()
    {
        $iterator = $this->getIterator();
        return isset($iterator);
    }

    public function key()
    {
        // Returns the request object as the key.
        return $this->parameters[0];
    }

    /**
     * Returns the response object of current page.
     */
    private function getResponse()
    {
        if (!isset($this->currentResponse)) {
            $this->currentResponse = call_user_func_array($this->callable, $this->parameters);
        }
        return $this->currentResponse;
    }

    /**
     * Returns a valid iterator of current page. If the current iterator is not valid, fetch next.
     */
    private function getIterator()
    {
        if (!isset($this->currentIterator)) {
            $resourceField = $this->pageStreamingDescriptor->getResourceField();
            $resources = new ArrayObject($this->getResponse()->$resourceField);
            $this->currentIterator = $resources->getIterator();
        } elseif (!$this->currentIterator->valid()) {
            $this->currentIterator = $this->nextIterator();
        }
        return $this->currentIterator;
    }

    private function nextIterator()
    {
        $requestPageTokenField = $this->pageStreamingDescriptor->getRequestPageTokenField();
        $nextPageToken = $this->nextPageToken();
        if (isset($nextPageToken)) {
            $request = $this->parameters[0];
            // Updates the current request to point to the next page.
            $request->$requestPageTokenField = $nextPageToken;
            $this->currentResponse = null;
            $resourceField = $this->pageStreamingDescriptor->getResourceField();
            $resources = new ArrayObject($this->getResponse()->$resourceField);
            return $resources->getIterator();
        } else {
            return null;
        }
    }
}
