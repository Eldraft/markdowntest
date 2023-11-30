<?php

namespace App\Service;

class ArticleEdit
{
    private $fileInfo;

    public function __construct(FileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    /**
     * Подготовка данных для формы редактирования
     * $krl - фикс подсчета слов на кириллице
     * @author eldraft
     * @param $id
     * @return array
     */
    public function getData($id): array
    {
        $result = array();

        $path = $this->fileInfo->getPath();
        $file = $path . $id;

        $metadata = $this->fileInfo->getFileMetadata($file);
        $content = $this->fileInfo->getFileContent($file);

        $krl = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';

        $result['id'] = $id;
        $result['title'] = $metadata['title'];
        $result['content'] = $content;
        $result['words'] = str_word_count($content, 0, $krl);
        $result['tables'] = $this->fileInfo->countTables($content);
        $result['images'] = $this->fileInfo->countImages($content);

        return $result;
    }
}