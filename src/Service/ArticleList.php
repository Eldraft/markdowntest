<?php

namespace App\Service;

class ArticleList
{
    public $fileInfo;

    public function __construct(FileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    public function getData(): array
    {

        $files = $this->fileInfo->getFilesPath('md');

        $metadata = array();
        foreach ($files as $name => $file){
            $data = $this->fileInfo->getFileMetadata($file);

            if (!empty($data)){
                $data['id'] = $name;
                $metadata[$name] = $data;
            }
        }

        return $metadata;
    }
}