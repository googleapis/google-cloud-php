<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Batch;

/**
 * A trait to assist in handling interrupt signals and gracefully stopping work.
 *
 * @experimental The experimental flag means that while we believe this method
 *      or class is ready for use, it may change before release in backwards-
 *      incompatible ways. Please use with caution, and test thoroughly when
 *      upgrading.
 */
trait InterruptTrait
{
    private $shutdown = false;

    private function setupSignalHandlers()
    {
        // setup signal handlers
        pcntl_signal(SIGTERM, [$this, "sigHandler"]);
        pcntl_signal(SIGINT, [$this, "sigHandler"]);
        pcntl_signal(SIGHUP, [$this, "sigHandler"]);
        pcntl_signal(SIGALRM, [$this, "sigHandler"]);
    }

    /**
     * A signal handler for setting the terminate switch.
     *
     * @see http://php.net/manual/en/function.pcntl-signal.php
     *
     * @param int $signo The received signal.
     * @param mixed $siginfo [optional] An array representing the signal
     *              information. **Defaults to** null.
     *
     * @return void
     */
    public function sigHandler($signo, $siginfo = null)
    {
        switch ($signo) {
            case SIGINT:
            case SIGTERM:
                $this->shutdown = true;
                break;
        }
    }
}
