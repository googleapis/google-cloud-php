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
 * This class represents a debuggee - a service that can handle breakpoints. For more information see
 * [Debugee](https://cloud.google.com/debugger/api/reference/rest/v2/Debuggee)
 */
class Debuggee implements \JsonSerializable
{
    use ArrayTrait;

    /**
     * @var ConnectionInterface $connection Represents a connection to Debugger
     */
    private $connection;

    private $id;
    private $project;
    private $uniquifier;
    private $description;
    private $isInactive = false;
    private $agentVersion = DebuggerClient::VERSION;
    private $sourceContexts = [];
    private $extSourceContexts = [];
    private $labels = [];

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

    public function id()
    {
        return $this->id;
    }

    public function register(array $args = [])
    {
        $resp = $this->connection->registerDebuggee($this->jsonSerialize());
        if (array_key_exists('debuggee', $resp)) {
            $this->id = $resp['debuggee']['id'];
        }
    }

    public function sourceContexts()
    {
        return $this->sourceContexts;
    }

    /**
     * Fetch the list of breakpoints this debugee should try to handle.
     *
     * @param array $options [optional] {
     *      Configuration options.
     *
     *      @type string $waitToken A wait token that, if specified, blocks the method call until the
     *            list of active breakpoints has changed, or a server selected timeout has expired.
     *            The value should be set from the last returned response.
     *      @type bool $successOnTimeout If set to **true**, returns **google.rpc.Code.OK** status and
     *            sets the **waitExpired** response field to **true** when the server-selected timeout
     *            has expired (recommended). If set to **false**, returns **google.rpc.Code.ABORTED**
     *            status when the server-selected timeout has expired (deprecated).
     * }
     * @return Breakpoint[]
     */
    public function breakpoints(array $options = [])
    {
        $ret = $this->connection->listBreakpoints([
            'debuggeeId' => $this->id
        ] + $options);

        if (array_key_exists('breakpoints', $ret)) {
            $ret['breakpoints'] = array_map(function ($bp) {
                return new Breakpoint($bp);
            }, $ret['breakpoints']);
        }
        return $ret;
    }

    public function breakpoint($breakpointId)
    {

    }

    public function updateBreakpoint(Breakpoint $breakpoint)
    {
        $data = [
            'debuggeeId' => $this->id,
            'id' => $breakpoint->id(),
            'breakpoint' => $breakpoint->jsonSerialize()
        ];
        return $this->connection->updateBreakpoint($data);
    }

    public function updateBreakpointBatch($breakpoints)
    {
        // var_dump($breakpoints);
        foreach ($breakpoints as $breakpoint) {
            $this->updateBreakpoint($breakpoint);
        }
    }

    public function deleteBreakpoint(Breakpoint $breakpoint)
    {

    }

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
