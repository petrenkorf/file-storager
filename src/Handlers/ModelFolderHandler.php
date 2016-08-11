<?php

namespace Impacte\FileStorager\Handlers;

use Impacte\FileStorager\HasFiles;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class ModelFolderHandler
{
    protected $fileHolder;

    protected $filesystem;

    const ROOT_FOLDER = 'public/';

    public function __construct(
        Filesystem $filesystem,
        HasFiles   $fileHolder
    ) {
        $this->fileHolder = $fileHolder;
        $this->filesystem = $filesystem;
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
        $folder = self::ROOT_FOLDER.$folder;

        if (!$this->filesystem->exists($folder)) {
            $this->filesystem->makeDirectory($folder, 0777, true);
        }
    }

    protected function createMultipleFolders($folders)
    {
        foreach ($folders as $currentFolder) {
            $this->makeDirectory($currentFolder);
        }
    }
}