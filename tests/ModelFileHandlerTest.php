<?php

use Impacte\FileStorager\Handlers\ModelFileHandler;

class ModelFileHandlerTest extends TestCase
{
    public function setUp()
    {
        
    }
    
    public function tearDown()
    {
        
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider invalidFileAttributeProvider
     */
    public function testShouldValidateModelReturn($map)
    {
        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getFileAttributes')
            ->once()
            ->andReturn(1);

        $model->shouldReceive('getStorageFolderMap')
            ->once()
            ->andReturn($map);

        $fileHandler = new ModelFileHandler();
        $fileHandler->setModel($model);
        $fileHandler->validate();
    }

    public function invalidFileAttributeProvider()
    {
        return [
            [1],
            [[]],
            [''],
        ];
    }

    /**
     * @expectedException UnexpectedValueException
     * @dataProvider invalidFileAttributeProvider
     */
    public function testShouldThrowExceptionWhenAttributeDoesntExists()
    {
        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getFileAttributes')
            ->once()
            ->andReturn(1);

        $model->shouldReceive('getStorageFolderMap')
            ->once()
            ->andReturn(['folder' => 2]);

        $fileHandler = new ModelFileHandler();
        $fileHandler->setModel($model);
        $fileHandler->validate();
    }
}