<?php

namespace App\Service;

class ArticleList
{
    private $fileInfo;

    public function __construct(FileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    /**
     * Сбор данных для списка
     * @author eldraft
     * @return array
     */
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