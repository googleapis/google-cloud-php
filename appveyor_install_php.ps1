appveyor DownloadFile http://windows.php.net/downloads/releases/php-$env:PHP_VERSION.zip

7z x php-$env:PHP_VERSION.zip -oc:\tools\php
