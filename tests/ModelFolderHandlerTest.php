<?php

namespace Impacte\FileStorager;

use \File as FileFacade;
use Illuminate\Filesystem\Filesystem;
use Mockery;
use Impacte\FileStorager\Handlers\ModelFolderHandler;

class ModelFolderHandlerTest extends \TestCase
{
    protected $root;

    public function setUp()
    {
    }

    public function tearDown()
    {
        FileFacade::deleteDirectory('public/administracao/modelo/folder1');
    }

    /**
     * @expectedException \UnexpectedValueException
     * @dataProvider invalidFolderProvider
     */
    public function testShouldThrowExceptionOnCreateFolders($folder)
    {
        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getFolder')
            ->once()
            ->andReturn($folder);

        $fs = $this->createApplication()->make(Filesystem::class);

        $storager = new ModelFolderHandler($fs, $model);
        $storager->createFolders();
    }

    public function invalidFolderProvider()
    {
        return [
            [[]],
            [123],
        ];
    }

    /**
     * @dataProvider validFoldersProvider
     */
    public function testShouldCreateFolders($folder)
    {
        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getFolder')
            ->once()
            ->andReturn($folder);

        $fs = $this->createApplication()->make(Filesystem::class);

        $storager = new ModelFolderHandler($fs, $model);
        $storager->createFolders();

        if (!is_array($folder)) {
            $this->assertFileExists('public/'.$folder);
        } else {
            foreach ($folder as $currentFolder) {
                $this->assertFileExists('public/'.$currentFolder);
                FileFacade::deleteDirectory('public/'.$currentFolder, true);
            }
        }
    }

    public function validFoldersProvider()
    {
        return [
            ['folder1'],
            [['folder2']],
            [['folder3', 'folder4']]
        ];
    }

    public function testShouldRemoveAllModelFolders()
    {

    }
    /*public function testShouldStoreAllModelFiles()
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
    }*/
}