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
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function persistAllFiles()
    {
        $this->validate();
    }

    public function validate()
    {
        $this->fileMap = $this->model->getStorageFolderMap();

        if (!$this->isValidStorageMap()) {
            throw new \UnexpectedValueException('Model attributes must be of type string');
        }
    }

    protected function isValidStorageMap()
    {
        if (!is_array($this->fileMap) || empty($this->fileMap)) {
            return false;
        }

        return $this->validateEachAttributes();
    }

    protected function validateEachAttributes()
    {
        $valid = true;

        foreach ($this->fileMap as $folder => $attribute) {
            if (!$this->isValidAttribute($folder, $attribute)) {
                $valid = false;
            }
        }

        return $valid;
    }

    protected function isValidAttribute($folder, $attribute)
    {
        return property_exists($this->model, $attribute) &&
               isset($this->model->$attribute) &&
               $this->model->$attribute != null;
    }

    /*public function persistFile()
    {
        
    }

    public function deleteFile()
    {

    }

    public function deleteAllFiles()
    {

    }*/

    /*protected function generateFileName($file)
    {
        return dd($file->getMimeType());
        //return str_random(12).".".$file->getClientOriginalExtension();
    }*/
}
