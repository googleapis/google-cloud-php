# Google Stackdriver Debugger V2 generated client for PHP

### Sample

```php
require 'vendor/autoload.php';

use Google\Cloud\Debugger\V2\Debugger2Client;
use Google\Cloud\Dataproc\V2\BreakPoint;

$debugger2Client = new Debugger2Client();
try {
    $debuggeeId = '[DEBUGGEE_ID]';
    $breakpoint = new Breakpoint();
    $clientVersion = '[CLIENT_VERSION]';
    $response = $debugger2Client->setBreakpoint($debuggeeId, $breakpoint, $clientVersion);
} finally {
    $debugger2Client->close();
}
```
