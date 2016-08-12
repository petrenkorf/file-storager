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

    public function testeShouldValidateInterfaceProperties()
    {
        $model = Mockery::mock('Impacte\FileStorager\HasFiles');
        
        $model->shouldReceive('getStorageFolderMap')
            ->once()
            ->andReturn([
                'folder' => 'image1'
            ]);

        $model->shouldReceive('getFileAttributesToArray')
            ->once()
            ->andReturn(['image1']);

        $model->shouldReceive('getFileAttribute')
            ->once()
            ->with('image1')
            ->andReturn('lol');


        $modelHandler = new ModelFileHandler($model);
        $result = $modelHandler->isValid();

        $this->assertTrue($result);
    }

    /**
     * @dataProvider moveFileDataProvider
     */
    public function testShouldMoveModelFileToFilesystem($extension, $folder)
    {
        $image = Mockery::mock(\Symfony\Component\HttpFoundation\File\UploadedFile::class);

        $image->shouldReceive('getExtension')
            ->once()
            ->andReturn($extension);

        $image->shouldReceive('move')
            ->once();

        $model = Mockery::mock('Impacte\FileStorager\HasFiles');

        $model->shouldReceive('getStorageFolderMap')
            ->once()
            ->andReturn([
                $folder => 'image1'
            ]);

        $model->shouldReceive('getFile')
            ->once()
            ->with('image1')
            ->andReturn($image);

        $modelHandler = new ModelFileHandler($model);
        $modelHandler->saveFile('image1');

        $this->assertRegExp("/([a-z1-9\/]*)\/(([a-z0-9]*)\.([a-z]{3,4}))/i", $model->image1);
    }

    public function moveFileDataProvider()
    {
        return [
            ['png', 'folder1'],
            ['xlsx', 'folder2/13/']
        ];
    }
}
