<?php

namespace Impacte\FileStorager\Handlers;

use Impacte\FileStorager\HasFiles;

class ModelFileHandler
{
    protected $model;

    protected $fileMap = [];

    public function __construct(HasFiles &$model = null)
    {
        $this->model = $model;
        $this->fileMap = $this->model->getStorageFolderMap();
    }

    public function isValid()
    {
        if ( !is_array($this->model->getStorageFolderMap()) ||
            !$this->validateAttributes()) {
            return false;
        }
        
        return true;
    }

    protected function validateAttributes()
    {
        foreach ($this->model->getFileAttributesToArray() as $currentAttribute) {
            if ($this->model->getFileAttribute($currentAttribute) == null) {
                return false;
            }
        }

        return true;
    }

    public function saveFile($attribute)
    {
        $directory = $this->getAttributeFolder($attribute);
        $file = $this->model->getFile($attribute);
        $name = $this->generateName($file);
        $file->move($directory, $name);
        $this->model->$attribute = $directory."/".$name;
    }

    public function getAttributeFolder($attribute)
    {
        $tempFolderMap = array_flip($this->fileMap);
        return $tempFolderMap[$attribute];
    }

    public function generateName($file)
    {
        return str_random(8).".".$file->guessExtension();
    }
}
