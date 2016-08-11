<?php

namespace Impacte\FileStorager;

use Illuminate\Filesystem\Filesystem;

class ModelFileStorager
{
    protected $fileHolder;

    protected $filesystemHandler;

    protected $folder;

    const ROOT_FOLDER = 'public/';

    public function __construct(
        Filesystem $filesystemHandler,
        HasFiles   &$fileHolder
    ) {
        $this->fileHolder        = $fileHolder;
        $this->filesystemHandler = $filesystemHandler;
        $this->folder = $fileHolder->getStorageFolder();
    }

    public function saveAllFiles()
    {
        $this->createFolderIfDoesntExist();
    }
    
    protected function createFolderIfDoesntExist()
    {
        if (!$this->filesystemHandler->exists(self::ROOT_FOLDER.$this->folder)) {
            $this->filesystemHandler->makeDirectory(self::ROOT_FOLDER.$this->folder,0755, true);
        }
    }
}