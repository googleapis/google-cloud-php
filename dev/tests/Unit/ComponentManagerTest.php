<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Dev\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Dev\ComponentManager;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group dev
 */
class ComponentManagerTest extends TestCase
{
    const ROOT_PATH = '/var/www';

    private $cm;

    public function set_up()
    {
        $this->cm = TestHelpers::stub(ComponentManager::class, [
            self::ROOT_PATH
        ], [
            'components',
            'manifest'
        ]);

        $this->cm->___setProperty('components', $this->components);
        $this->cm->___setProperty('manifest', $this->manifest);
    }

    public function testComponents()
    {
        $this->assertEquals(array_keys($this->components), $this->cm->components());
    }

    public function testComponentsExtra()
    {
        $components = $this->components;
        foreach ($components as &$component) {
            $name = $component['composer']['name'];
            $component = $component['composer']['extra']['component'];
            $component['displayName'] = $name;
        };

        $this->assertEquals($components, $this->cm->componentsExtra());
    }

    public function testComponentsExtraSingleComponent()
    {
        $components = $this->components;
        array_walk($components, function (&$component) {
            $name = $component['composer']['name'];
            $component = $component['composer']['extra']['component'];
            $component['displayName'] = $name;
        });

        $componentId = array_keys($this->components)[0];
        $component = $components[$componentId];

        $this->assertEquals([$componentId => $component], $this->cm->componentsExtra($componentId));
    }

    public function testComponentsManifest()
    {
        $this->assertEquals($this->manifest['modules'], $this->cm->componentsManifest());
    }

    public function testComponentsManifestSingleComponent()
    {
        $componentId = array_keys($this->components)[0];

        $modules = array_filter($this->manifest['modules'], function ($module) use ($componentId) {
            return $componentId === $module['id'];
        });

        $res = $this->cm->componentsManifest($componentId);
        $this->assertEquals($modules, $res);
    }

    public function testComponentsVersion()
    {
        $versions = [];
        foreach ($this->manifest['modules'] as $module) {
            $versions[$module['id']] = $module['versions'][0];
        }

        $this->assertEquals($versions, $this->cm->componentsVersion());
    }

    public function testComponentsSingleVersion()
    {
        $componentId = array_keys($this->components)[0];

        $versions = [];
        foreach ($this->manifest['modules'] as $module) {
            if ($module['id'] !== $componentId) {
                continue;
            }

            $versions[$module['id']] = $module['versions'][0];
        }

        $this->assertEquals($versions, $this->cm->componentsVersion($componentId));
    }

    public function testLoadManifestAndComposers()
    {
        $fixturesDir = __DIR__ . '/../fixtures/component-manager';
        $cm = TestHelpers::stub(ComponentManager::class, [
            $fixturesDir,
            $fixturesDir . '/manifest.json',
        ], [
            'manifest',
            'components'
        ]);

        $cm->components();

        $manifest = $cm->___getProperty('manifest');
        $components = $cm->___getProperty('components');

        $this->assertEquals(count($manifest['modules']), count($components));
    }

    private $components = [
        'component-a' => [
            'composer' => [
                'name' => 'test/component-a',
                'extra' => [
                    'component' => [
                        'id' => 'component-a'
                    ]
                ]
            ],
            'version' => 'v0.1.0'
        ],
        'component-b' => [
            'composer' => [
                'name' => 'test/component-a',
                'extra' => [
                    'component' => [
                        'id' => 'component-b'
                    ]
                ]
            ],
            'version' => 'v1.0.0'
        ]
    ];

    private $manifest = [
        'modules' => [
            [
                'id' => 'component-a',
                'versions' => [
                    'v0.1.0',
                    'main'
                ]
            ], [
                'id' => 'component-b',
                'versions' => [
                    'v1.0.0',
                    'main'
                ]
            ]
        ]
    ];
}
