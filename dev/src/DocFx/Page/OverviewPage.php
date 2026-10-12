<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Dev\DocFx\Page;

/**
 * Class to output the Overview Page
 * @internal
 */
class OverviewPage
{
    public function __construct(private string $contents, private bool $isBeta)
    {
        // Prune out API documentation link as it will redirect back to itself
        // on cloud site.
        $contents = preg_replace('/\* \[API documentation\].*\n\n/', '', $contents);

        if ($isBeta) {
            // If the README starts with a H1
            if (0 === strpos($contents, '#')) {
                // Get the first newline to insert the notice after the H1
                if ($newlinePos = strpos($contents, "\n")) {
                    $betaNotice = $this->getMarkdownBetaNotice();
                    $contents = substr($contents, 0, $newlinePos) . "\n\n" . $betaNotice .
                        substr($contents, $newlinePos + 1);
                }
            }
        }

        $this->contents = $contents;
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getFilename(): string
    {
        return 'index.md';
    }

    public function getTocItem(): array
    {
        $tocItem = [
            'name' => 'Overview',
            'href' => 'index.md'
        ];

        return $tocItem;
    }

    private function getMarkdownBetaNotice(): string
    {
        $betaNotice = '<aside class="beta"><p><strong>Beta</strong></p><p>' .
            'This library is covered by the <a href="/terms/service-terms#1">Pre-GA Offerings Terms</a> ' .
            'of the  Terms of Service. Pre-GA libraries might have limited support, ' .
            'and changes to pre-GA libraries might not be compatible with other pre-GA versions. ' .
            'For more information, see the ' .
            '<a href="/products#product-launch-stages">launch stage descriptions</a>.' .
            '</p></aside>' . PHP_EOL;

        return $betaNotice;
    }
}
