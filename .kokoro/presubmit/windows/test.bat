SET SHORT_JOB_NAME=%KOKORO_JOB_NAME:~-5%

RENAME C:\Users\kbuilder\software\%SHORT_JOB_NAME% php

CD github/google-cloud-php
MKDIR %SHORT_JOB_NAME%\unit
CALL php C:\Users\kbuilder\bin\composer self-update
CALL php C:\Users\kbuilder\bin\composer update
CALL vendor/bin/phpunit --log-junit %SHORT_JOB_NAME%\unit\sponge_log.xml
if %errorlevel% neq 0 exit /b %errorlevel%

RENAME C:\Users\kbuilder\software\php %SHORT_JOB_NAME%
