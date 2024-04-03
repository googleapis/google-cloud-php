<?php

namespace Google\Cloud\Datastore\Tests\Snippet;

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\Filter;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class FilterTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;

    private const PROJECT = 'alpha-project';
    private $connection;
    private $datastore;
    private $operation;
    private $query;
    private $filter;
    private $requestHandler;

    public function setUp(): void
    {
        $entityMapper = new EntityMapper(self::PROJECT, false, false);

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->requestHandler = $this->prophesize(RequestHandler::class);

        $this->datastore = TestHelpers::stub(
            DatastoreClient::class,
            [],
            ['operation']
        );

        $this->query = TestHelpers::stub(Query::class, [$entityMapper]);

        $this->filter = Filter::where('CompanyName', '=', 'Google');
    }

    public function testFilter()
    {
        $this->createConnectionProphecy();

        $snippet = $this->snippetFromClass(Filter::class, 0);
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('query', $this->query);
        $snippet->addLocal('filter', $this->filter);
        $snippet->addUse(Filter::class);

        $res = $snippet->invoke('finalResult');
        $this->assertEquals(['Google'], $res->returnVal());
    }

    /**
     * @dataProvider getCompositeFilterTypes
     */
    public function testOrFilter($compositeFilterType)
    {
        $this->createConnectionProphecy();

        $snippet = $this->snippetFromClass(Filter::class, 1);
        $snippet->addLocal('filterType', $compositeFilterType);
        $snippet->addLocal('datastore', $this->datastore);
        $snippet->addLocal('query', $this->query);
        $snippet->addLocal('filter', $this->filter);
        $snippet->addLocal('filters', []);
        $snippet->addUse(Filter::class);

        $res = $snippet->invoke('finalResult');
        $this->assertEquals(['Google'], $res->returnVal());
    }

    public function getCompositeFilterTypes()
    {
        return [
            ['or'],
            ['and']
        ];
    }

    private function createConnectionProphecy()
    {
        $this->mockSendRequest(
            '',
            [],
            [
                'batch' => [
                    'entityResults' => [
                        [
                            'entity' => [
                                'key' => ['path' => []],
                                'properties' => [
                                    'companyName' => [
                                        'stringValue' => 'Google'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'moreResults' => 'no'
                ]
            ],
            0
        );

        $this->refreshOperation($this->datastore, $this->connection->reveal(), $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);
    }
}
