<?php

namespace Impacte\FileStorager\Handlers;

use Impacte\FileStorager\HasFiles;

class ModelFileHandler
{
    protected $model;

    protected $fileMap;

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
        $this->getFileMap();

        if (!$this->isModelAttributesValid()) {
            throw new \UnexpectedValueException('Model attributes must be of type string');
        }
    }

    protected function isModelAttributesValid()
    {
        $validAttributes = true;

        foreach ($this->fileMap as $folder => $attribute) {
            if (!$this->isAttributeOk($attribute)) {
                $validAttributes = false;
            }
        }

        return (is_array($this->fileMap) && count($this->fileMap) > 0) &&
                $validAttributes == true;
    }

    protected function isAttributeOk($attribute)
    {
        return property_exists($this->model, $attribute);
    }

    public function persistFile()
    {
        
    }

    public function deleteFile()
    {

    }

    public function deleteAllFiles()
    {

    }

    protected function getFileMap()
    {
        $this->fileMap = $this->model->getStorageFolderMap();
    }
}
