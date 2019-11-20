<?php

namespace PartnerMarketing\FileSystemBundle\Tests\Unit\Adapter;

use PartnerMarketing\FileSystemBundle\Adapter\LocalStorage;
use PartnerMarketing\FileSystemBundle\Factory\FileSystemFactory;

class LocalStorageTest extends \PHPUnit_Framework_TestCase
{
    private $adapter;

    protected function setUp()
    {
        $this->config = [
            'local_storage' => ['path' => __DIR__, 'url' => 'http://files.test/'],
            'amazon_s3' => ['key' => '', 'secret' => '', 'region' => '', 'bucket' => ''],
        ];
        $this->adapter = (new FileSystemFactory('local_storage', $this->config, '/tmp'))->build();
    }

    public function testRead()
    {
        $content = $this->adapter->read('test.txt');

        $this->assertEquals("hello,\n\nthis is a file.\n", $content);
    }

    public function testGetFileSize()
    {
        $actualSize = $this->adapter->getFileSize('test.txt');
        $expectedSize = strlen("hello,\n\nthis is a file.\n");

        $this->assertEquals($expectedSize, $actualSize);
    }

    public function testGetFiles()
    {
        $result = $this->adapter->getFiles();

        $this->assertCount(3, $result);
        $this->assertContains('sub-dir/test2.txt', $result);
    }
}
