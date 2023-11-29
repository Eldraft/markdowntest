<?php

namespace App\Service;

class ArticleEdit
{
    public $fileInfo;

    public function __construct(FileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    public function getData($id): array
    {

        $result = array();

        $rootDir = dirname(getcwd());
        $ds = DIRECTORY_SEPARATOR;
        $folder = 'icecream/articles';

        $file = $rootDir . $ds . $folder . $ds. $id;

        $metadata = $this->fileInfo->getFileMetadata($file);
        $content = $this->fileInfo->getFileContent($file);

        $result['id'] = $id;
        $result['title'] = $metadata['title'];
        $result['content'] = $content;
        $result['words'] = str_word_count($content);
        $result['tables'] = $this->fileInfo->countTables($content);
        $result['images'] = $this->fileInfo->countImages($content);

        return $result;
    }
}