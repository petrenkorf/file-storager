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
     */
    public function testShouldThrowExceptionWhenGettingNonFileAttribute()
    {
        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getFileAttributes')
            ->once()
            ->andReturn(1);

        $model->shouldReceive('getStorageFolderMap')
            ->once()
            ->andReturn(1);

        $fileHandler = new ModelFileHandler();
        $fileHandler->setModel($model);
        $fileHandler->persistAllFiles();
    }
}