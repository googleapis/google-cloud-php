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

require 'vendor/autoload.php';
require_once('createLogEntry.php');
use Google\Cloud\Logging\LoggingClient;
use Google\Logging\V2\WriteLogEntriesRequest;
use Google\Logging\V2\DeleteLogRequest;
use Google\Logging\V2\ListLogEntriesRequest;
use Google\Logging\V2\LoggingServiceV2GrpcClient;
use Google\Cloud\Logging\Logger;
use Google\Cloud\Logging\Entry;
use Google\Logging\V2\LogEntry;
use Google\Cloud\Logging\PsrLogger;

function listlogs($stub, $metadata, $call_options, $project_id){
        $request = new \Google\Logging\V2\ListLogsRequest();
        $request->setParent('projects/'.$project_id);
        list($reply, $status) = $stub->ListLogs($request, $metadata, $call_options)->wait();
        hardAssertIfGRPCStatusOk($status);
        $iter = $reply->getLogNames()->getIterator();
        while ($iter->valid()){
                print_r($iter->current());
                echo "\n";
                $iter->next();
        }
}

function deletelogs($stub, $metadata, $call_options, $project_id){
        $request = new DeleteLogRequest();
        $request->setLogName('projects/'.$project_id.'/logs/perf-rest');
        list($reply, $status) = $stub->DeleteLog($request, $metadata, $call_options)->wait();
        hardAssertIfGRPCStatusOk($status);
        print_r($reply);
}

function listLogEntries($stub, $metadata, $call_options, $project_id){
        $request = new ListLogEntriesRequest();
        $request->setResourceNames(['projects/'.$project_id]);
        $request->setFilter('logName = projects/'.$project_id.'/logs/perf-rest');
        list($reply, $status) = $stub->ListLogEntries($request, $metadata, $call_options)->wait();
        hardAssertIfGRPCStatusOk($status);
        $iter = $reply->getEntries()->getIterator();
        while($iter->valid()){
                $cur = $iter->current();
                print_r($cur->getJsonPayload()->getFields()->getIterator()->current()->getStringValue());
                $iter->next();
        }
}

function createGrpcRequest($grpc, $entry_gen, $message, $project_id){
        $new_entry = $entry_gen->entry(['message' => $message], ['severity' => 200]);
        $args = [$new_entry];
        foreach ($args as &$entry) {
                $entry = $entry->info();
        }
        $pbEntries = [];
        foreach ($args as $entry) {
                $pbEntries[] = $grpc->buildEntry($entry);
        }
        $request = new WriteLogEntriesRequest();
        $request->setEntries($pbEntries);
        $request->setLogName('projects'.$project_id.'logs/perf-rest');
        return $request;
}

function createRestRequest($entry_gen, $message, $project_id) {
        $new_entry = $entry_gen->entry(['message' => $message], ['severity' => 200]);
        $args = [$new_entry];
        foreach ($args as &$entry) {
                $entry = $entry->info();
        }
        $entries = ['entries' => $args,
                'logName' => 'projects'.$project_id.'logs/perf-rest'
        ];
        $fields = json_encode($entries);
        return $fields;
}

function hardAssertIfGRPCStatusOk($status) {
            if ($status->code !== Grpc\STATUS_OK) {
                    var_dump($status);
            }
}

function hardAssertIfRESTStatusOk($status) {
        if ((int)$status != 200){
                var_dump($status);
        }
}

// Two value should be set before the benchmark. Credential file path and API key which is for pure REST.
$keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
$keyAPI = getenv('GOOGLE_CLOUD_PHP_TESTS_API_KEY');
$scopes = ['https://www.googleapis.com/auth/logging.admin'];
$keyFile = json_decode(file_get_contents($keyFilePath), true);
$project_ID = $keyFile['project_id'];
// buildEntry is used to convert Entry to LogEntry. It does the same thing Veneer gRPC does converting Entryi,
// which makes the comparison more fair.
$buildEntry = new createLogEntry();

// create pure gRPC stub
$fetcher = Google\Auth\CredentialsLoader::makeCredentials($scopes, $keyFile);
$authCache = new Google\Auth\Cache\MemoryCacheItemPool();
$credentialsLoader = new Google\Auth\FetchAuthTokenCache($fetcher, [], $authCache);
$callback = function () use ($credentialsLoader) {
        $token = $credentialsLoader->fetchAuthToken();
        return ['authorization' => array('Bearer ' . $token['access_token'])];
};
$credentials = Grpc\ChannelCredentials::createSsl();
$call_credentials = Grpc\CallCredentials::createFromPlugin($callback);
$cred = Grpc\ChannelCredentials::createComposite($credentials,$call_credentials);
$stub = new LoggingServiceV2GrpcClient('logging.googleapis.com:443', [
        'credentials' => $cred,
        'grpc.ssl_target_name_override' => 'logging.googleapis.com:443'
]);
$get_auth = $callback();
$Bearer = $get_auth['authorization'][0];
$metadata = ['x-goog-api-client' => ['gl-php/7.0.22-0ubuntu0.17.04.1 gccl/1.5.0 gapic/1.5.0 gax/0.24.0 grpc/1.6.0']];
$call_options = ['timeout' => 30000000];
// create Veneer gRPC; batchSize = 1 to disable the batch so that writing each log entry
// will be an unary ping-pong
$grpcLogger = LoggingClient::psrBatchLogger(
        'perf-rest',
        [
                'clientConfig' => [
                        'keyFilePath' => $keyFilePath,
                        'transport' => 'grpc'
                ],
                'batchOptions' => ['batchSize' => 1]
        ]
);
// create Veneer REST
$restLogger = LoggingClient::psrBatchLogger(
        'perf-rest',
        [
                'clientConfig' => [
                        'keyFilePath' => $keyFilePath,
                        'transport' => 'rest'
                ],
                'batchOptions' => ['batchSize' => 1]
        ]
);
// entry_gen is used to generate log entry with timestamp
$entry_gen = new Logger(new Google\Cloud\Logging\Connection\Rest(), 'perf-rest', $project_ID, [], []);
// create pure REST client
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://logging.googleapis.com/v2/entries:write?key=".$keyAPI);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$headers = array();
$headers[] = "Authorization: ".$Bearer;
$headers[] = "Content-Type: application/json";
$headers[] = "User-Agent: gcloud-php/1.5.0";
$headers[] = "x-goog-api-client: gl-php/7.0.22-0ubuntu0.17.04.1 gccl/1.5.0";
$headers[] = "Host: logging.googleapis.com" ;
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, TRUE);
$warmup_num = 30;
$num = 1000;
deletelogs($stub, $metadata, $call_options, $project_ID);
sleep(1);
echo "start warmup";
for ($i=0; $i<$warmup_num; $i++){
        $grpcLogger->info('b');
        $request = createGrpcRequest($buildEntry, $entry_gen, 'a', $project_ID);
        list($reply, $status) = $stub->WriteLogEntries($request, $metadata, $call_options, $project_ID)->wait();
        hardAssertIfGRPCStatusOk($status);
        $fields = createRestRequest($entry_gen, 'c', $project_ID);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $restLogger->info('d');
        $data = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        hardAssertIfRESTStatusOk($status);
}
// listLogEntries should list entries order as ‘bacdbacdbacd…’
sleep(1);
listLogEntries($stub, $metadata, $call_options, $project_ID);
$pure_grpc_time = 0;
$vene_grpc_time = 0;
$pure_rest_time = 0;
$vene_rest_time = 0;
$start = microtime(true);
echo "start benchmark";
listlogs($stub, $metadata, $call_options, $project_ID);
for($i=0; $i<$num; $i++){
        echo "$i ";
        $start = microtime(true);
        $request = createGrpcRequest($buildEntry, $entry_gen, 'x', $project_ID);
        $stub->WriteLogEntries($request, $metadata, $call_options, $project_ID)->wait();
        $end = microtime(true);
        $pure_grpc_time += ($end - $start);

        $start = microtime(true);
        $grpcLogger->info('x');
        $end = microtime(true);
        $vene_grpc_time += ($end - $start);

        $start = microtime(true);
        $fields = createRestRequest($entry_gen, 'x', $project_ID);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
         curl_exec($ch);
        $end = microtime(true);
        $pure_rest_time += ($end - $start);

        $start = microtime(true);
        $restLogger->info('x');
        $end = microtime(true);
        $vene_rest_time += ($end - $start);
}
echo PHP_EOL . 'pure_grpc took ' . $pure_grpc_time . ' seconds for sending '.
        $num . ' logs';

echo PHP_EOL . 'vene_grpc took ' . $vene_grpc_time . ' seconds for sending '.
        $num . ' logs';

echo PHP_EOL . 'pure_rest took ' . $pure_rest_time . ' seconds for sending '.
        $num . ' logs';

echo PHP_EOL . 'vene_rest took ' . $vene_rest_time . ' seconds for sending '.
        $num . ' logs';

