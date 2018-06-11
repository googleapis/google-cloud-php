# Stackdriver Logging V2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Logging\V2\LoggingServiceV2Client;

$loggingServiceV2Client = new LoggingServiceV2Client();
try {
    $formattedLogName = $loggingServiceV2Client->logName('[PROJECT]', '[LOG]');
    $loggingServiceV2Client->deleteLog($formattedLogName);
} finally {
    $loggingServiceV2Client->close();
}
```
