<?php

namespace Impacte\FileStorager;

interface HasFiles
{
    public function getFile($attributeName);

    public function getFileAttributesToArray();

    public function getFileAttribute($attributeName);

    public function getFolder();

    public function getStorageFolderMap();
}