<?php
/**
 * Copyright 2023 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev;

use RuntimeException;

/**
 * @internal
 */
class NewComponent
{
    public string $protoPackage;
    public string $phpNamespace;
    public string $displayName;
    public string $componentName;
    public string $componentPath;
    public string $composerPackage;
    public string $githubRepo;
    public string $gpbMetadataNamespace;
    public string $shortName;
    public string $protoPath;
    public ?string $version;

    public static function fromProto(string $protoContents, string $protoFilename): self
    {
        $new = new self();
        $new->protoPackage = self::extractPackageNameFromProtoContents($protoContents);
        $new->phpNamespace = self::extractPhpNamespaceFromProtoContents($protoContents)
            ?: self::derivePhpNamespaceFromProtoPackage($new->protoPackage);
        $new->displayName = self::getDisplayName($new->phpNamespace);
        $new->componentName = self::getComponentName($new->displayName);
        $new->composerPackage = self::getComposerPackageFromProtoPackage($new->protoPackage);
        $new->githubRepo = self::getGithubRepo($new->composerPackage);
        $new->gpbMetadataNamespace = self::getGpbMetadataNamespace($new->protoPackage);
        $new->shortName = self::extractShortNameFromProtoContents($protoContents);
        $new->version = self::extractVersionFromProtoFilename($protoFilename);
        $new->protoPath = self::getProtoPath($protoFilename, $new->version);

        return $new;
    }

    public function getDocumentationUrl(): string
    {
        return sprintf(
            'https://cloud.google.com/php/docs/reference/%s/latest',
            str_replace('google/', '', $this->composerPackage)
        );
    }

    private static function getGithubRepo(string $composerPackage): string
    {
        return 0 === strpos($composerPackage, 'google/cloud-')
            ? 'googleapis/google-cloud-php-' . substr($composerPackage, 13)
            : 'googleapis/php-' . substr($composerPackage, 7);
    }

    private static function getComponentName(string $displayName): string
    {
        return trim(str_replace(['Google', 'Cloud', ' '], '', $displayName));
    }

    private static function getDisplayName(string $phpNamespace): string
    {
        $nameParts = explode('\\', $phpNamespace);
        foreach ($nameParts as $i => $part) {
            $nameParts[$i] = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', ' $0', $part)));
        }
        return ucwords(implode(' ', $nameParts));
    }

    private static function getGpbMetadataNamespace(string $protoPackage): string
    {
        return 'GPBMetadata\\' . implode('\\', array_map('ucfirst', explode('.', $protoPackage)));
    }

    private static function derivePhpNamespaceFromProtoPackage(string $protoPackage): string
    {
        return implode('\\', array_map('ucfirst', explode('.', $protoPackage)));
    }

    private static function getComposerPackageFromProtoPackage(string $protoPackage): string
    {
        return 'google/' . str_replace(
            ['google.', 'devtools.cloud', '.'],
            ['', 'cloud-', '-'],
            $protoPackage
        );
    }

    private static function getProtoPath(string $protoFilename, ?string $version): string
    {
        $protoPath = dirname($protoFilename);
        if (is_null($version)) {
            return $protoPath;
        }
        $parts = explode('/', $protoPath);
        if ($i = array_search($version, $parts)) {
            $parts[$i] = "($version)";
        }

        return implode('/', $parts);
    }

    private static function extractPackageNameFromProtoContents(string $protoContents): string
    {
        if (!preg_match('/package (.*);/', $protoContents, $matches)) {
            throw new RuntimeException('package name not found in proto file ');
        }
        $parts = explode('.', $matches[1]);
        $version = array_pop($parts);
        if ('v' !== $version[0]) {
            $parts[] = $version;
        }
        return implode('.', $parts);
    }

    private static function extractShortNameFromProtoContents(string $protoContents): string
    {
        if (!preg_match(
            '/option \(google.api.default_host\) =[\n\r\s]+"(.*).googleapis.com";/',
            $protoContents,
            $matches)
        ) {
            throw new RuntimeException('short name not found in proto file');
        }
        return $matches[1];
    }

    private static function extractPhpNamespaceFromProtoContents(string $protoContents): ?string
    {
        if (!preg_match('/option php_namespace = "(.*)";/', $protoContents, $matches)) {
            return null;
        }
        // Remove version from namespace
        $parts = explode('\\\\', $matches[1]);
        $version = array_pop($parts);
        if ('v' !== strtolower($version[0])) {
            $parts[] = $version;
        }

        return implode('\\', $parts);
    }

    private static function extractVersionFromProtoFilename(string $protoFilename): ?string
    {
        // Remove version from namespace
        $parts = explode('/', $protoFilename);
        while (count($parts)) {
            $version = array_pop($parts);
            if (preg_match(Component::VERSION_REGEX . 'i', $version)) {
                return $version;
            }
        }

        return null;
    }
}
