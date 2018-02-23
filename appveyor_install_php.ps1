Add-Type -assembly "system.io.compression.filesystem"

$file = "php-$env:PHP_VERSION.zip"
$archiveUrl = "http://windows.php.net/downloads/releases/archives/$file"
$url = "http://windows.php.net/downloads/releases/$file"
$projectPath = "C:\projects\google-cloud"
$client = New-Object NET.WebClient

try {
    $client.DownloadFile($url, "$projectPath\$file")
    "Downloaded file from $url"
} catch {
    $client.DownloadFile($archiveUrl, "$projectPath\$file")
    "Downloaded file from $archiveUrl"
}

if (![System.IO.File]::Exists("$projectPath\$file")) {
    "File $projectPath\$file does not exist! This is not a good sign for the tests passing."
}

[io.compression.zipfile]::ExtractToDirectory("$projectPath\$file", "C:\tools\php")
