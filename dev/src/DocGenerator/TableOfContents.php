<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Dev\DocGenerator;

class TableOfContents
{
    private $template;
    private $componentId;
    private $componentVersion;
    private $contentsPath;
    private $outputPath;
    private $release;

    public function __construct(array $template, $componentId, $componentVersion, $contentsPath, $outputPath, $release = false)
    {
        $this->template = $template;
        $this->componentId = $componentId;
        $this->componentVersion = $componentVersion;
        $this->contentsPath = $contentsPath;
        $this->outputPath = $outputPath;
        $this->release = $release;
    }

    public function generate($pretty = false)
    {
        $toc = $this->getToc($this->componentId);

        $tpl = $this->template;
        $tpl['services'] = $this->services($toc);
        $tpl['tagName'] = $this->release
            ? $this->componentVersion
            : 'master';

        $writer = new Writer($tpl, $this->outputPath, $pretty);
        $writer->write('toc.json');
    }

    private function services(array $toc)
    {
        $services = $toc['services'];

        if (isset($toc['includes'])) {
            foreach ($toc['includes'] as $include) {
                $toc = $this->getToc($include);
                $nested = $toc['services'];
                $firstService = array_shift($nested);

                $service = [
                    'title' => $toc['title'],
                    'type' => $firstService['type'],
                    'nav' => $nested
                ];

                if (isset($toc['pattern'])) {
                    $service['patterns'] = [$toc['pattern']];
                }

                $services[] = $service;
            }
        }

        return $services;
    }

    private function getToc($componentId)
    {
        return json_decode(file_get_contents($this->contentsPath .'/'. $componentId .'.json'), true);
    }
}
