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

namespace Google\Cloud\Debugger;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;
use Google\Cloud\Debugger\Connection\ConnectionInterface;

/**
 * This class represents a debuggee - a service that can handle breakpoints.
 * For more information see
 * [Debugee](https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee)
 */
class Debuggee implements \JsonSerializable
{
    use ArrayTrait;

    /**
     * @var ConnectionInterface $connection Represents a connection to Debugger
     */
    private $connection;

    /**
     * @var string The unique identifier for this Debuggee
     */
    private $id;

    /**
     * @var string
     */
    private $project;

    /**
     * @var string The debuggee uniquifier.
     */
    private $uniquifier;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $isInactive = false;

    /**
     * @var string
     */
    private $agentVersion = DebuggerClient::VERSION;

    private $sourceContexts = [];
    private $extSourceContexts = [];
    private $labels = [];

    /**
     * Instantiate a new Debuggee.
     *
     * @param ConnectionInterface $connection
     * @param array $info [optional]
     *      Configuration options.
     *
     *      @type string $id
     *      @type string $project
     *      @type string $uniquifier
     *      @type string $description
     *      @type string $isInactive
     *      @type string $agentVersion
     *      @type string $status
     *      @type string $sourceContexts
     *      @type string $extSourceContexts
     */
    public function __construct(ConnectionInterface $connection, array $info = [])
    {
        $this->connection = $connection;

        $this->id = $this->pluck('id', $info);
        $this->project = $this->pluck('project', $info);
        $this->uniquifier = $this->pluck('uniquifier', $info, false) ?: 'FIXME';
        $this->description = $this->pluck('description', $info, false) ?: 'FIXME';
        if (array_key_exists('isInactive', $info)) {
            $this->isInactive = $info['isInactive'];
        }
        if (array_key_exists('agentVersion', $info)) {
            $this->agentVersion = $info['agentVersion'];
        }
        $this->status = $this->pluck('status', $info, false);
        $this->sourceContexts = $this->pluck('sourceContexts', $info, false) ?: [];
        $this->extSourceContexts = $this->pluck('extSourceContexts', $info, false) ?: [];
    }

    /**
     * Return the debuggee identifier.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Register this debuggee with the Stackdriver backend.
     *
     * @param array $args [description]
     * @return bool
     */
    public function register(array $args = [])
    {
        $resp = $this->connection->registerDebuggee($this, $args);
        if (array_key_exists('debuggee', $resp)) {
            $this->id = $resp['debuggee']['id'];
            return true;
        }
        return false;
    }

    /**
     * Fetch the list of breakpoints this debugee should try to handle.
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $waitToken A wait token that, if specified, blocks the
     *            method call until the list of active breakpoints has changed,
     *            or a server selected timeout has expired. The value should be
     *            set from the last returned response.
     *      @type bool $successOnTimeout If set to **true**, returns
     *            **google.rpc.Code.OK** status and sets the **waitExpired**
     *            response field to **true** when the server-selected timeout
     *            has expired (recommended). If set to **false**, returns
     *            **google.rpc.Code.ABORTED** status when the server-selected
     *            timeout has expired (deprecated).
     * }
     * @return Breakpoint[]
     */
    public function breakpoints(array $options = [])
    {
        $ret = $this->connection->listBreakpoints($this->id, $options);

        if (array_key_exists('breakpoints', $ret)) {
            $ret['breakpoints'] = array_map(
                function ($data) {
                    return new Breakpoint($data);
                },
                $ret['breakpoints']
            );
        }
        return $ret;
    }

    /**
     * Update the provided, modified breakpoint.
     *
     * @param Breakpoint $breakpoint The modified breakpoint.
     * @return bool
     */
    public function updateBreakpoint(Breakpoint $breakpoint)
    {
        return $this->connection->updateBreakpoint($this->id, $breakpoint);
    }

    /**
     * Update multiple breakpoints.
     *
     * @param Breakpoint[] $breakpoints The modified breakpoints.
     */
    public function updateBreakpointBatch($breakpoints)
    {
        foreach ($breakpoints as $breakpoint) {
            $this->updateBreakpoint($breakpoint);
        }
    }

    /**
     * Returns a JSON serializable array representation of the debuggee.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'project' => $this->project,
            'uniquifier' => $this->uniquifier,
            'description' => $this->description,
            'isInactive' => $this->isInactive,
            'agentVersion' => $this->agentVersion,
            'status' => $this->status,
            'sourceContexts' => array_map(function ($sc) {
                return is_array($sc) ? $sc : $sc->jsonSerialize();
            }, $this->sourceContexts),
            'extSourceContexts' => array_map(function ($esc) {
                return is_array($esc) ? $esc : $esc->jsonSerialize();
            }, $this->extSourceContexts)
        ];
    }
}
