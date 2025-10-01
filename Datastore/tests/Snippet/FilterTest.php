<?php

namespace Google\Cloud\Datastore\Tests\Snippet;

use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\Filter;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\Tests\Unit\ProtoEncodeTrait;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicDatastoreClient;
use Google\Cloud\Datastore\V1\QueryResultBatch\MoreResultsType;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class FilterTest extends SnippetTestCase
{
    use DatastoreOperationRefreshTrait;
    use ProphecyTrait;
    use ProtoEncodeTrait;

    private const PROJECT = 'alpha-project';
    private $gapicClient;
    private $datastore;
    private $operation;
    private $query;
    private $filter;

    public function setUp(): void
    {
        $entityMapper = new EntityMapper(self::PROJECT, false, false);

        $this->gapicClient = $this->prophesize(GapicDatastoreClient::class);

        $this->datastore = new DatastoreClient([
            'datastoreClient' => $this->gapicClient->reveal()
        ]);

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
        $this->gapicClient->runQuery(Argument::any(), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, [
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
                    'moreResults' => MoreResultsType::NO_MORE_RESULTS
                ]
            ]));
    }
}
