<?php
namespace Google\Cloud\Samples\Spanner;
use Google\Cloud\Spanner\SpannerClient;
# Include the autoloader for libraries installed with composer
require __DIR__ . '/vendor/autoload.php';
/*
Uasge:
php ycsb.php 
  --operationcount={number of operations} \
  --instance=[gcloud instance] \
  --database={database name} \
  --table={table to use} \
  --workload={workload file} 
 
Note: all arguments above are mandatory 
Note: This bnchmark script assumes that the table has a PK field named "id".
 
*/

$msg = "";
$arrKEYS = [];
$arrOPERATIONS = ['readproportion', 'updateproportion', 'scanproportion', 'insertproportion'];


// Was going to try to multi thread, but Thread class is considered very dangerous in a CLI
// environment.  To multi-thread, please incorporate class into a PHP web page and make multiple
// calls to the same page.
//class WorkloadThread extends Thread {
class WorkloadThread {    
    public $_database;
    public $_arrParameters;
    public $_fltTotalWeight;
    public $_arrWeights;
    public $_arrOperations;
    public $_arrLatency;

    public function __construct($database, $arrParameters, $fltTotalWeight, $arrWeights, $arrOperations) {
        $this->_database = $database;
        $this->_arrParameters = $arrParameters;
        $this->_fltTotalWeight = $fltTotalWeight;
        $this->_arrWeights = $arrWeights;
        $this->_arrOperations = $arrOperations;
        $this->_arrLatency = [];
        }

    public function run() {
        // Run a single thread of the workload
        $i = 0;
        $intOperationCount = (int)$this->_arrParameters['operationcount'];
        while ($i < $intOperationCount) {
            $i += 1;
            $fltWeight = (float)rand(0, $this->_fltTotalWeight*10000)/10000.0;
            //print "Randomizer is $fltWeight out of {$this->_fltTotalWeight} \n";
            for ($j=0;$j<count($this->_arrWeights);$j++) {
                if ($fltWeight <= $this->_arrWeights[$j]) {
                    $this->DoOperation($this->_database, $this->_arrParameters['table'], $this->_arrOperations[$j]);
                    break;
                    }
                }
            }
        }

    public function PerformRead($database, $table, $key) {
        //Changed named to PerformRead because Read is a reserved keyword.
	      $time_start = microtime(true);
        // Kind of assuming that id is ubiquitous...
        $results = $database->execute("SELECT * FROM $table where id = '$key'");
        foreach ($results as $row) {
            $key = $row;
            }
	      return microtime(true) - $time_start;
        }

    public function Update($database, $table, $key) {
        // Does a single update operation.
        $field = rand(0,9);
        $time_start = microtime(true);
        $operation = $database->transaction(['singleUse' => false])
            ->updateBatch($table, [
                ['id' => $key, "field".$field => $this->randString(false, 100)],
                ])
            ->commit();
        return microtime(true) - $time_start;
        }

    public function Insert($database, $table) {
        $arrBatch = [];  //array of $arrFields
        $arrFields = [];
        $arrFields["id"] = "user4" . $this->randString(true, 17);
        for ($f = 0; $f < 10; $f++) {
            $arrFields["field".$f] = $this->randString(false, 100);
            }
        $arrbatch[] = $arrFields;
        array_multisort($arrBatch);
        $time_start = microtime(true);
        $operation = $database->transaction(['singleUse' => true])->insertBatch($table, $arrBatch)->commit();
        return microtime(true) - $time_start;
        }

    public function Scan($database, $table, $key) {

        }

    public function DoOperation($database, $table, $operation) {
        global $arrKEYS;
        global $arrLatency;
        $key = $arrKEYS[array_rand($arrKEYS)];
        switch ($operation) {
            case 'read':
                $optime = $this->PerformRead($database, $table, $key);
                break;
            case 'update':
                $optime = $this->Update($database, $table, $key);
                break;
            case 'insert':
                $optime = $this>Insert($database, $table);
                break;
            case 'scan':
                $optime = $this->Scan($database, $table, $key);
                break;
            default:
                break;
            }
        //ReportSwitch("--- $operation performed in $optime seconds.\n");
        $arrLatency[$operation][] = $optime;
        }

    public function randString($num, $len) {
        $strRand = "";
        if ($num == true)
            $characters = '0123456789';
        else
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charlen = strlen($characters);
        for ($i = 0; $i < $len; $i++) {
            $strRand .= $characters[rand(0, $charlen - 1)];
            }
        return $strRand;
        }
    }


//Lives outside the class because it will only potentially be called once.
function parseCliOptions() {
    global $arrOPERATIONS;

    $longopts = array(
        "operationcount:",
        "instance:",
        "database:",
        "table:",
        "numworkers::",
        "workload:",
        );
    $arrParameters = getopt("", $longopts);
    // Now we have things like $arrParameters["num_worker"]

	  $myfile = fopen($arrParameters['workload'], "r") or die("Unable to open file!");
    while ($line = fgets($myfile)) {
        $parts = explode("=", $line);
	      $key = trim($parts[0]);
		    if (in_array($key, $arrOPERATIONS)) {
            $arrParameters[$key] = trim($parts[1]);
            }
        }
    fclose($myfile);
    return $arrParameters;
    }

function average($arrParam) {
    return array_sum($arrParam)/count($arrParam);
    }

function stanDev($arrParam) {
    $mean = average($arrParam);
    foreach($arrParam as $key => $val) {
        $arrParam[$key] = pow($val-$mean, 2);
        }
    return sqrt(average($arrParam));
    }

function percentile($arrParam, $pct) {
    sort($arrParam);
    $i = floor($pct*count($arrParam));
    return $arrParam[$i];
    }

function AggregateMetrics($duration) {
    global $arrLatency;
    $OverallOpCount = 0;
    $arrOpCounts = [];
    foreach ($arrLatency as $opKey => $arrDurations) {
        $arrOpCounts[$opKey] = count($arrDurations);
        $OverallOpCount += $arrOpCounts[$opKey];
        }
    $r = $OverallOpCount/$duration;
    reportSwitch("[OVERALL] Throughput (Ops/sec), $r \n");
    foreach($arrOpCounts as $opKey => $intOpCounts) {
        $strUpperOp = strtoupper($opKey);
        reportSwitch("[$strUpperOp], Operations: $intOpCounts. \n");
        $r = average($arrLatency[$opKey])*1000;
        reportSwitch("[$strUpperOp], AverageLatency(us) $r \n");
        $r = stanDev($arrLatency[$opKey])*1000;
        reportSwitch("[$strUpperOp], LatencyVariance(us) $r \n");
        $r = min($arrLatency[$opKey])*1000;
        reportSwitch("[$strUpperOp], MinLatency(us) $r \n");
        $r = max($arrLatency[$opKey])*1000;
        reportSwitch("[$strUpperOp], MaxLatency(us) $r \n");
        $r = percentile($arrLatency[$opKey], 0.50)*1000;
        reportSwitch("[$strUpperOp], 50thPercentile(us) $r \n");
        $r = percentile($arrLatency[$opKey], 0.95)*1000;
        reportSwitch("[$strUpperOp], 95thPercentile(us) $r \n");
        $r = percentile($arrLatency[$opKey], 0.99)*1000;
        reportSwitch("[$strUpperOp], 99thPercentile(us) $r \n");
        $r = percentile($arrLatency[$opKey], 0.999)*1000;
        reportSwitch("[$strUpperOp], 99.9thPercentile(us) $r \n");
        }
    }

function LoadKeys($database, $arrParameters) {
    global $arrKEYS;
    $arrKEYS = array();
    $time_start = microtime(true);
    $snapshot = $database->snapshot();
    // Kind of assuming that id is always name of PK in whatever table you choose
    $results = $snapshot->execute("SELECT id FROM {$arrParameters['table']}");
    foreach ($results as $row) {
        $arrKEYS[] = $row['id'];
        }
	return microtime(true) - $time_start;
    }

function OpenDatabase($arrParameters) {
    //global $database;
    $spanner = new SpannerClient();
    $instance = $spanner->instance($arrParameters['instance']);
    $database = $instance->database($arrParameters['database']);
    return $database;
    }

function ReportSwitch($strMsg) {
    global $msg;
    if (php_sapi_name() == 'cli') {
        print $strMsg;
        }
    else {
        // Otherwise, if it is being called from a browser, aggregate into a message.
        $msg .= $strMsg;
        }
    }

function RunWorkload($database, $parameters) {
    global $arrOPERATIONS;
    $fltTotalWeight = 0.0;
    $arrWeights = [];
    $arrOperations = [];
    $arrLatency = [];
    foreach($arrOPERATIONS as $operation) {
        //print "Setting Weight of $operation to {$parameters[$operation]} \n";
        $weight = (float)$parameters[$operation];
        if ($weight <= 0.0) continue;
        $fltTotalWeight += $weight;
        $op_code = explode('proportion', $operation);
        $arrOperations[] = $op_code[0];
        $arrWeights[] = $fltTotalWeight;
        $arrLatency[$op_code[0]] = [];
        }
	  $time_start = microtime(true);
	  $testOp = new WorkloadThread($database, $parameters, $fltTotalWeight, $arrWeights, $arrOperations);
    $testOp->run();
    $time_end = microtime(true) - $time_start;
    // Unfortunately, latencies not stored and reported like in the original script.
    // AggregateMetrics(arrLatency, (end - start) * 1000.0, parameters['num_bucket']);
    reportSwitch("[OVERALL] Operation run time: $time_end s\n");
    AggregateMetrics($time_end);

    }



// Allow for calling from a webserver
if (php_sapi_name() == 'cli') {
    $arrParameters = parseCliOptions();
//    reportSwitch("Called from command line.\n");
    }
else {
    $arrParameters = parseQueryStringOptions();
//    reportSwitch("Called from web browser.\n");
    }

//reportSwitch("Connecting to " . $arrParameters['database'] . "\n");

// Initial connection
$time_start = microtime(true);
$database = OpenDatabase($arrParameters);
$time_exec = microtime(true) - $time_start;
//reportSwitch("Connected to " . $arrParameters['database'] . " in $time_exec seconds\n");
$LoadKeysTime = LoadKeys($database, $arrParameters);
//reportSwitch("Loaded keys in $LoadKeysTime seconds\n");

RunWorkload($database, $arrParameters);

// Uncomment if script accidentally thinks it is in a web environmnt.
//if ($msg !="") print $msg;

?>
