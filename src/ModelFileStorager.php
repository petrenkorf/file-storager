<?php

namespace Impacte\FileStorager;

use Illuminate\Contracts\Filesystem\Filesystem;

class ModelFileStorager
{
    protected $fileHolder;

    protected $filesystemHandler;

    protected $folder;

    protected $files;

    public function __construct(
        Filesystem $filesystemHandler,
        HasFiles   &$fileHolder
    ) {
        $this->fileHolder        = $fileHolder;
        $this->filesystemHandler = $filesystemHandler;
        $this->folder = $fileHolder->getStorageFolder();
    }

    public function persistAll()
    {
        $newFiles = $this->fileHolder->getFiles();

        $this->createFolderIfDoesntExist($this->folder);

        foreach ($newFiles as $attribute => $file) {
            $this->saveFile($attribute, $file);
        }
    }

    public function persist($attribute)
    {
        $file = $this->fileHolder->$attribute;

        $this->createFolderIfDoesntExists($this->folder);
        $this->saveFile($attribute, $file);
    }

    protected function createFolderIfDoesntExists($folder)
    {
         if (!$this->filesystemHandler->exists($folder)) {
             $this->filesystemHandler->makeDirectory($folder,0777,true);
         }
    }

    protected function saveFile($attribute, $file)
    {
        $filename = $this->generateFilename($file);
        $file->move($this->folder, $filename);
        $this->

        $this->fileHolder->$attribute = "{$this->folder}/{$filename}";
    }

    protected function generateFilename($file)
    {
        return str_random(8).$file->getClientOriginalExtension();
    }

    public function deleteAll()
    {
        $files = $this->fileHolder->getFiles();

        foreach ($files as $currentFile) {
            if ($this->filesystemHandler->exists($currentFile)) {
                $this->filesystemHandler->delete($currentFile);
            }
        }
    }

    public function delete($fieldname)
    {
        $this->delete($fieldname);
    }

    public function deleteFolder()
    {
        $this->filesystemHandler->cleanDirectory();
        $this->filesystemHandler->deleteDirectory();
    }
}