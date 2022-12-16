<?php
/*
 * Copyright 2018 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Dev\Docs;

use RuntimeException;
use Doctum\Doctum;
use Doctum\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

/**
 * @internal
 */
class DoctumConfigBuilder
{
    public static function checkPhpVersion()
    {
        // Verify that we are running PHP 7 or above
        if (version_compare(phpversion(), '7.1', '<')) {
            throw new RuntimeException('PHP must be >= 7.1 to build docs, found version ' . phpversion());
        }
    }

    public static function buildConfigForVersion($version)
    {
        $gaxRootDir = realpath(__DIR__ . '/../../..');
        $iterator = Finder::create()
            ->files()
            ->name('*.php')
            ->exclude('GPBMetadata')
            ->in("$gaxRootDir/src")
        ;

        return new Doctum($iterator, [
            'title'                => "Google ApiCore - $version",
            'version'              => $version,
            'build_dir'            => "$gaxRootDir/tmp_gh-pages/%version%",
            'cache_dir'            => "$gaxRootDir/cache/%version%",
            'remote_repository'    => new GitHubRemoteRepository('googleapis/gax-php', $gaxRootDir),
            'default_opened_level' => 1,
        ]);
    }

    public static function buildProtobufConfigForVersion($version)
    {
        $gaxRootDir = realpath(__DIR__ . '/../../..');
        $protobufRootDir = realpath(__DIR__ . '/../../../vendor/google/protobuf');
        $iterator = Finder::create()
            ->files()
            ->name('*.php')
            ->exclude('GPBMetadata')
            ->in("$protobufRootDir/src")
        ;

        return new Doctum($iterator, [
            'title'                => "Google Protobuf - $version",
            'version'              => $version,
            'build_dir'            => "$gaxRootDir/api-docs",
            'cache_dir'            => "$gaxRootDir/cache/%version%",
            'remote_repository'    => new GitHubRemoteRepository('protocolbuffers/protobuf-php', $protobufRootDir),
            'default_opened_level' => 1,
        ]);
    }
}
