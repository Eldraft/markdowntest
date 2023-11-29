<?php

namespace App\Service;

class FileInfo
{
    public function getPath(): string
    {
        $rootDir = dirname(getcwd());
        $folder = '/taskFiles/articles/';

        return $rootDir . $folder;
    }


    public function getFilesPath($ext): array
    {
        $path = $this->getPath();

        $files = array();
        foreach(glob($path . "*.$ext") as $file) {
            $files[basename($file)] = $file;
        }

        return $files;
    }

    public function getMetadataBlock($file): string
    {
        $result = '';
        $string = file_get_contents($file);
        $stingBlocks = preg_split("/\-\-\-\s/", $string);

        if (!empty($stingBlocks[1])){
            $result = $stingBlocks[1];
        }

        return $result;
    }

    public function getFileMetadata($file): array
    {
        $result = array();

        if (empty($metaBlock = $this->getMetadataBlock($file))){
            return $result;
        }

        $metaStrings = explode(PHP_EOL, trim($metaBlock));

        foreach ($metaStrings as $meta){
            $position = strpos($meta, ':');
            $key = trim(substr_replace($meta, '', $position), " \n\r\t\v\x00\"\:");
            $value = trim(substr($meta, $position), " \n\r\t\v\x00\"\:");
            $result[$key] = $value;
        }
        return $result;
    }

    public function getFileContent($file): string
    {
        $string = file_get_contents($file);
        $stingBlocks = preg_split("/\-\-\-\s/", $string);

        if (empty($stingBlocks[2])){
            return '';
        }

        return trim($stingBlocks[2]);
    }

    public function countImages($string): int
    {
        $result = 0;
        $pattern = '/!\[[^\n]*\]\([^\n]*\)/';
        preg_match_all($pattern, $string, $matches);

        if (!empty($matches)) {
            $result = count($matches[0]);
        }
        return $result;

    }

    public function countTables($string): int
    {
        $result = 0;
        $pattern = '/(^|\s)\|-[|\-]*\|\s/';
        preg_match_all($pattern, $string, $matches);

        if (!empty($matches)) {
            $result = count($matches[0]);
        }
        return $result;
    }

}