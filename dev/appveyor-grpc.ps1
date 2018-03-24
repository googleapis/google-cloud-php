$currentFolder = $(get-location).Path
cd c:\tools\php

Add-Content php.ini "`nextension_dir=ext"
Add-Content php.ini "`nextension=php_openssl.dll"

if (Test-Path 'env:GRPC_SRC') {
    "Downloading $env:GRPC_SRC as grpc.zip"
    Invoke-WebRequest -Uri $env:GRPC_SRC -OutFile .\grpc.zip

    "Unzipping grpc.zip"
    Expand-Archive grpc.zip -DestinationPath .\ext-grpc

    "Copying grpc dll to php extension folder"
    copy ext-grpc\php_grpc.dll ext\php_grpc.dll

    "Adding extension to php.ini"
    Add-Content php.ini "`nextension=php_grpc.dll"
} else {
    "`n`n"
    "gRPC source URI not specified."
    "`n`n"
}

cd $currentFolder
