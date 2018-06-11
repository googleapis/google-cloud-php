# Stackdriver Error Reporting V1beta1 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\ErrorReporting\V1beta1\ReportErrorsServiceClient;
use Google\Cloud\ErrorReporting\\V1beta1\ReportedErrorEvent;

$reportErrorsServiceClient = new ReportErrorsServiceClient();
$formattedProjectName = $reportErrorsServiceClient->projectName('[PROJECT]');
$event = new ReportedErrorEvent();

try {
    $response = $reportErrorsServiceClient->reportErrorEvent($formattedProjectName, $event);
} finally {
    $reportErrorsServiceClient->close();
}
```
