<?php

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\Acl;
use Prophecy\Argument;

class AclTest extends \PHPUnit_Framework_TestCase
{
    public $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize('Google\Cloud\Storage\Connection\ConnectionInterface');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionWithInvalidType()
    {
        $acl = new Acl($this->connection->reveal(), 'nope', ['bucket' => 'bucket']);
    }

    public function testDelete()
    {
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertNull($acl->delete('owner'));
    }

    public function testGetAll()
    {
        $accessControls = [
            ['entity' => 'allAuthenticatedUsers']
        ];
        $this->connection->listAcl(Argument::any())->willReturn(['items' => $accessControls]);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControls, $acl->get());
    }

    public function testGetWithSpecifiedEntity()
    {
        $accessControl = [
            'entity' => 'allAuthenticatedUsers'
        ];
        $this->connection->getAcl(Argument::any())->willReturn($accessControl);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControl, $acl->get(['entity' => 'allAuthenticatedUsers']));
    }

    public function testAdd()
    {
        $accessControl = [
            'entity' => 'allAuthenticatedUsers',
            'role' => 'READER'
        ];
        $this->connection->insertAcl(Argument::any())->willReturn($accessControl);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControl, $acl->add('allAuthenticatedUsers', 'READER'));
    }

    public function testUpdate()
    {
        $accessControl = [
            'entity' => 'allAuthenticatedUsers',
            'role' => 'WRITER'
        ];
        $this->connection->patchAcl(Argument::any())->willReturn($accessControl);
        $acl = new Acl($this->connection->reveal(), 'bucketAccessControls', ['bucket' => 'bucket']);

        $this->assertEquals($accessControl, $acl->update('allAuthenticatedUsers', 'WRITER'));
    }
}
