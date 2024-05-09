<?php

namespace Google\Cloud\Datastore\Tests\Snippet;

use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\Filter;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as V1DatastoreClient;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class FilterTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;

    private const PROJECT = 'alpha-project';
    private $datastore;
    private $operation;
    private $query;
    private $filter;
    private $requestHandler;

    public function setUp(): void
    {
        $entityMapper = new EntityMapper(self::PROJECT, false, false);

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
        $this->createRequestHandlerProphecy();

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
        $this->createRequestHandlerProphecy();

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

    private function createRequestHandlerProphecy()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::type(RunQueryRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(
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
            ]
        );

        $this->refreshOperation($this->datastore, $this->requestHandler->reveal(), [
            'projectId' => self::PROJECT
        ]);
    }
}
