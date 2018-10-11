SET SHORT_JOB_NAME=%KOKORO_JOB_NAME:~-5%

MKDIR %SHORT_JOB_NAME%\unit
RENAME C:\Users\kbuilder\software\%SHORT_JOB_NAME% php

CALL php C:\Users\kbuilder\bin\composer update
CALL vendor/bin/phpunit --log-junit %SHORT_JOB_NAME%\unit\sponge_log.xml

RENAME C:\Users\kbuilder\software\php %SHORT_JOB_NAME%
