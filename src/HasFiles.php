<?php

namespace Impacte\FileStorager;

interface HasFiles
{
    public function getFile($attributeName);

    public function getFolder();

    public function getStorageFolderMap();
}