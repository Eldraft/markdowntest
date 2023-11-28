<?php

namespace App\Service;

class FileInfo
{
    public function getList(): array
    {
        $files = $this->getFilesPath('icecream/articles', 'md');

        $metadata = array();
        foreach ($files as $name => $file){
            $data = $this->getFileMetadata($file);
            $data['id'] = $name;
            $metadata[$name] = $data;
        }

        return $metadata;
    }

    public function getFilesPath($folder, $ext): array
    {

        $rootDir = dirname(getcwd());
        $ds = DIRECTORY_SEPARATOR;

        $path = $rootDir . $ds . $folder;

        $files = array();
        foreach(glob($path . "$ds*.$ext") as $file) {
            $files[basename($file)] = $file;
        }

        return $files;
    }

    public function getFileMetadata($file): array
    {
        $result = array();
        $string = file_get_contents($file);
        $stingBlocks = explode("---", $string);

        if (empty($stingBlocks[1])){
            return $result;
        }

        $metaStrings = explode(PHP_EOL, trim($stingBlocks[1]));

        foreach ($metaStrings as $meta){
            $position = strpos($meta, ':');
            $key = trim(substr_replace($meta, '', $position), " \n\r\t\v\x00\"\:");
            $value = trim(substr($meta, $position), " \n\r\t\v\x00\"\:");
            $result[$key] = $value;
        }
        return $result;
    }

}