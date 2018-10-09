SET SHORT_JOB_NAME=%KOKORO_JOB_NAME:~0,5%

MKDIR %SHORT_JOB_NAME%\unit
RENAME %HOME%\software\%SHORT_JOB_NAME% php

CALL php %HOME%\bin\composer update
CALL vendor/bin/phpunit --log-junit %SHORT_JOB_NAME%\unit\sponge_log.xml

RENAME %HOME%\software\php %SHORT_JOB_NAME%
