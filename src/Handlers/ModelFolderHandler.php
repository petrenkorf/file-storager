<?php

namespace Impacte\FileStorager\Handlers;

use Impacte\FileStorager\HasFiles;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class ModelFolderHandler
{
    protected $fileHolder;

    protected $filesystem;

    // TODO move to config file
    const ROOT_FOLDER = '';

    public function __construct(
        Filesystem $filesystem,
        HasFiles   $fileHolder = null
    ) {
        $this->filesystem = $filesystem;
        $this->fileHolder = $fileHolder;
    }

    public function setModel($model)
    {
        $this->fileHolder = $model;
    }

    public function createFolders()
    {
        $folder = $this->getFolderOrFail();
        (is_string($folder)) ? $this->makeDirectory($folder) :$this->createMultipleFolders($folder);
    }

    protected function getFolderOrFail()
    {
        $folderArr = $this->fileHolder->getFolder();

        if (!$this->validFolder($folderArr)) {
            throw new \UnexpectedValueException('Folder must be a string or array of strings and cannot be empty');
        }

        return $folderArr;
    }

    protected function validFolder($folderArr)
    {
        return (is_array($folderArr) && count($folderArr) != 0) ||
               (is_string($folderArr));
    }

    protected function makeDirectory($folder)
    {
        $folder = $this->getFolderPath($folder);

        echo $folder."\n";
        if (!$this->filesystem->exists($folder)) {
            $this->filesystem->makeDirectory($folder, 0755, true);
        }
    }

    protected function getFolderPath($folder)
    {
        return self::ROOT_FOLDER.$folder;
    }

    protected function createMultipleFolders($folders)
    {
        foreach ($folders as $currentFolder) {
            $this->makeDirectory($currentFolder);
        }
    }

    public function deleteFolders()
    {
        $folder = $this->getFolderOrFail();
        (is_string($folder)) ? $this->deleteSingleDirectory($folder) :$this->deleteMultipleDirectories($folder);
    }

    protected function deleteSingleDirectory($folder)
    {
        $folder = $this->getFolderPath($folder);

        if ($this->filesystem->exists($folder)) {
            $this->filesystem->deleteDirectory($folder);
        }
    }
}