# Stackdriver Monitoring V3 generated client for PHP

### Sample

```php
use Google\Api\Metric;
use Google\Api\MonitoredResource;
use Google\Cloud\Monitoring\V3\MetricServiceClient;
use Google\Cloud\Monitoring\V3\Point;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\TimeSeries;
use Google\Cloud\Monitoring\V3\TypedValue;
use Google\Protobuf\Timestamp;

$metricServiceClient = new MetricServiceClient();
$formattedProjectName = $metricServiceClient->projectName($projectId);
$labels = [
    'instance_id' => $instanceId,
    'zone' => $zone,
];

$m = new Metric();
$m->setType('custom.googleapis.com/my_metric');

$r = new MonitoredResource();
$r->setType('gce_instance');
$r->setLabels($labels);

$value = new TypedValue();
$value->setDoubleValue(3.14);

$timestamp = new Timestamp();
$timestamp->setSeconds(time());

$interval = new TimeInterval();
$interval->setStartTime($timestamp);
$interval->setEndTime($timestamp);

$point = new Point();
$point->setValue($value);
$point->setInterval($interval);
$points = [$point];

$timeSeries = new TimeSeries();
$timeSeries->setMetric($m);
$timeSeries->setResource($r);
$timeSeries->setPoints($points);

try {
    $metricServiceClient->createTimeSeries($formattedProjectName, [$timeSeries]);
    print('Successfully submitted a time series' . PHP_EOL);
} finally {
    $metricServiceClient->close();
}
```
