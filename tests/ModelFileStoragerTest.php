<?php

namespace Impacte\FileStorager;

use Illuminate\Filesystem\Filesystem;
use Mockery;
use Symfony\Component\HttpFoundation\File\File;
use \File as LaraFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ModelFileStoragerTest extends \TestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {
        LaraFile::deleteDirectory('public/administracao/modelo');
    }

    public function testShouldStoreAllModelFiles()
    {
        $modelFile = Mockery::mock(UploadedFile::class);

        $modelFile->shouldReceive('move')
            ->once()
            ->andReturn(
                Mockery::mock(File::class)
            );

        $modelFile->shouldReceive('getClientOriginalExtension')
            ->once()
            ->andReturn('png');

        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getFiles')
              ->once()
              ->andReturn([$modelFile]);
        
        $model->shouldReceive('getStorageFolder')
            ->once()
            ->andReturn('administracao/modelo');

        $model->shouldReceive('getFileAttributes')
            ->once()
            ->andReturn(['arquivo']);

        $storager = new ModelFileStorager($this->createApplication()->make(Filesystem::class), $model);
        $storager->saveAllFiles();
        
        $this->assertFileExists('public/administracao/modelo');
    }
}