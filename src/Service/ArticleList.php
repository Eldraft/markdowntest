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

        $files = $this->fileInfo->getFilesPath('icecream/articles', 'md');

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