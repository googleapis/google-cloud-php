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

namespace Google\Cloud\Core\Batch;

/**
 * An external daemon script for executing the batch jobs.
 */
class BatchDaemon
{
    /* @var BatchRunner */
    private $runner;
    
    /* @var boolean */
    private $shutdown;

    /* @var array */
    private $descriptorspec;

    /* @var string */
    private $command;

    /* @var string */
    private $failureFile;

    /**
     * Prepare the descriptor spec and install signal handlers.
     *
     * @param string $entrypoint Daemon's entrypoint script.
     */
    public function __construct($entrypoint)
    {
        $this->runner = new BatchRunner();
        $this->shutdown = false;
        // Just share the usual descriptors.
        $this->descriptorspec = array(
            0 => array('file', 'php://stdin', 'r'),
            1 => array('file', 'php://stdout', 'w'),
            1 => array('file', 'php://stderr', 'w')
        );
        // setup signal handlers
        pcntl_signal(SIGTERM, array($this, "sigHandler"));
        pcntl_signal(SIGINT, array($this, "sigHandler"));
        pcntl_signal(SIGHUP, array($this, "sigHandler"));
        $this->command = sprintf('php -d auto_prepend_file="" %s', $entrypoint);
        $this->failureFile = tempnam(
            sys_get_temp_dir(),
            sprintf('batch-daemon-failure-%d', getmypid())
        );
    }

    /**
     * A signal handler for the terminate switch.
     */
    public function sigHandler($signo, $signinfo)
    {
        switch ($signo) {
            case SIGINT:
            case SIGTERM:
                $this->shutdown = true;
                break;
        }
    }

    /**
     * A loop for the parent.
     */
    public function runParent()
    {
        $procs = array();
        while (true) {
            $jobs = $this->runner->getJobs();
            foreach ($jobs as $job) {
                if (! array_key_exists($job->getIdentifier(), $procs)) {
                    echo 'Spawning children' . PHP_EOL;
                    $procs[$job->getIdentifier()] = array();
                    for ($i = 0; $i < $job->getWorkerNum(); $i++) {
                        $procs[$job->getIdentifier()][] = proc_open(
                            sprintf('%s %d', $this->command, $job->getIdNum()),
                            $this->descriptorspec,
                            $pipes
                        );
                    }
                }
            }
            pcntl_signal_dispatch();
            if ($this->shutdown) {
                echo 'Shutting down, waiting for the children' . PHP_EOL;
                foreach ($procs as $k => $v) {
                    foreach ($v as $proc) {
                        @proc_terminate($proc);
                        @proc_close($proc);
                    }
                }
                echo 'BatchDaemon exiting' . PHP_EOL;
                exit;
            }
            sleep(1);
            // Reload the config
            $this->runner->loadConfig();
        }
    }

    /**
     * A loop for the children.
     *
     * @param int $idNum Numeric id for the job.
     */
    public function runChild($idNum)
    {
        // child process
        $sysvKey = SysvUtils::getSysvKey($idNum);
        $q = msg_get_queue($sysvKey);
        $items = array();
        $job = $this->runner->getJobFromIdNum($idNum);
        $period = $job->getCallPeriod();
        $lastInvoked = microtime(true);
        $batchSize = $job->getBatchSize();
        while (true) {
            if (count($items) === 0) {
                $flag = 0;
            } else {
                $flag = MSG_IPC_NOWAIT;
            }
            if (msg_receive(
                $q,
                0,
                $type,
                8192,
                $message,
                true,
                $flag,
                $errorcode
            )) {
                if ($type === SysvUtils::TYPE_DIRECT) {
                    $items[] = $message;
                } elseif ($type === SysvUtils::TYPE_FILE) {
                    $items[] = unserialize(file_get_contents($message));
                    @unlink($message);
                }
            }
            if ((count($items) >= $batchSize)
                || (count($items) !== 0
                    && microtime(true) > $lastInvoked + $period)) {
                printf(
                    'Running the job with %d items' . PHP_EOL,
                    count($items)
                );
                if (! $job->run($items)) {
                    // Try to save the items.
                    $f = @fopen($this->failureFile, 'w');
                    foreach ($items as $item) {
                        @fwrite($f, serialize($item) . PHP_EOL);
                    }
                    @fclose($f);
                }
                $items = array();
                $lastInvoked = microtime(true);
            }
            pcntl_signal_dispatch();
            gc_collect_cycles();
            if ($this->shutdown) {
                exit;
            }
        }
    }
}
