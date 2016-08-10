<?php

namespace Impacte\FileStorager;

interface HasFiles
{
    public function getFiles();

    public function getFileFields();

    public function getStorageFolder();
}