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
    use SysvTrait;
    use HandleFailureTrait;

    /* @var BatchRunner */
    private $runner;
    
    /* @var boolean */
    private $shutdown;

    /* @var array */
    private $descriptorSpec;

    /* @var string */
    private $command;

    /**
     * Prepare the descriptor spec and install signal handlers.
     *
     * @param string $entrypoint Daemon's entrypoint script.
     */
    public function __construct($entrypoint)
    {
        if (! $this->isSysvIPCLoaded()) {
            throw new \RuntimeException('SystemV IPC exntensions are missing.');
        }
        $this->runner = new BatchRunner(
            new SysvConfigStorage(),
            new SysvJobSubmitter()
        );
        $this->shutdown = false;
        // Just share the usual descriptors.
        $this->descriptorSpec = array(
            0 => array('file', 'php://stdin', 'r'),
            1 => array('file', 'php://stdout', 'w'),
            2 => array('file', 'php://stderr', 'w')
        );
        // setup signal handlers
        pcntl_signal(SIGTERM, array($this, "sigHandler"));
        pcntl_signal(SIGINT, array($this, "sigHandler"));
        pcntl_signal(SIGHUP, array($this, "sigHandler"));
        $this->command = sprintf('php -d auto_prepend_file="" %s', $entrypoint);
        $this->initFailureFile();
    }

    /**
     * A signal handler for setting the terminate switch.
     * {@see http://php.net/manual/en/function.pcntl-signal.php}
     *
     * @param int $signo The received signal.
     * @param mixed $siginfo [optional] An array representing the signal
     *              information. **Defaults to** null.
     *
     * @return void
     */
    public function sigHandler($signo, $signinfo = null)
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
     *
     * @return void
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
                            $this->descriptorSpec,
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
     * @return void
     */
    public function runChild($idNum)
    {
        // child process
        $sysvKey = $this->getSysvKey($idNum);
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
                if ($type === self::$typeDirect) {
                    $items[] = $message;
                } elseif ($type === self::$typeFile) {
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
                    $this->handleFailure($idNum, $items);
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
