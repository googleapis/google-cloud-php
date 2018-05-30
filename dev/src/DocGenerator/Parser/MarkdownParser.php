<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Dev\DocGenerator\Parser;

use Parsedown;
use DOMDocument;
use DOMElement;

class MarkdownParser implements ParserInterface
{
    /**
     * A trigger to determine if the file being parsed is the README in the
     * component root
     */
    const ROOT_README_TRIGGER = 'Latest Stable Version';

    private $currentFile;
    private $content;
    private $markdown;
    private $id;

    public function __construct($currentFile, $content, $id)
    {
        $this->currentFile = $currentFile;
        $this->content = $content;
        $this->markdown = Parsedown::instance();
        $this->id = $id;

        set_error_handler(function($number, $error){
            if (preg_match('/^DOMDocument::loadHTML\(\): (.+)$/', $error, $m) === 1) {
                throw new \Exception($m[1]);
            }
        });
    }

    public function parse()
    {
        ini_set('xdebug.var_display_max_depth', -1);
        ini_set('xdebug.var_display_max_children', -1);
        ini_set('xdebug.var_display_max_data', -1);
        $html = $this->markdown->parse($this->content);

        try {
            $doc = new DOMDocument;
            $doc->preserveWhiteSpace = false;
            $doc->loadHTML($html);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage() .' ('. $this->currentFile .')');
        }

        $headings = $doc->getElementsByTagName('h1');
        $heading = $headings->item(0);
        if (!$heading) {
            throw new \RuntimeException('Missing h1 tag ('. $this->currentFile .')');
        }
        $heading->parentNode->removeChild($heading);

        $this->pruneGitSpecificData($doc);
        $body = $doc->getElementsByTagName('body')->item(0);

        return [
            'id' => $this->id,
            'type' => 'guide',
            'title' => $heading->textContent,
            'name' => $heading->textContent,
            'description' => $doc->saveHTML($body),
            'methods' => []
        ];
    }

    /**
     * @todo If the README isn't in a specific format, things can go south. Make
     *       this less fragile.
     * @param DOMDocument $doc
     */
    private function pruneGitSpecificData($doc)
    {
        $img = $doc->getElementsByTagName('img')
            ->item(0);
        if (!$img) {
            return;
        }
        $alt = $img->attributes->getNamedItem('alt');
        if (!$alt) {
            return;
        }
        if (strpos($alt->textContent, self::ROOT_README_TRIGGER) === false) {
            return;
        }

        $blockquotes = $doc->getElementsByTagName('blockquote');
        $blockquote = $blockquotes->item(0);

        if ($blockquote) {
            $blockquote->parentNode->removeChild($blockquote);
        }

        $lists = $doc->getElementsByTagName('ul');
        $list = $lists->item(0);
        $list->parentNode->removeChild($list);

        $paragraphs = $doc->getElementsByTagName('p');
        $p0 = $paragraphs->item(0);
        $p1 = $paragraphs->item(1);
        $p0->parentNode->removeChild($p0);
        $p1->parentNode->removeChild($p1);
    }
}
