<?php

namespace App\Service;

class ArticleSave
{
    public $fileInfo;
    private $articleData;
    private $statistic;

    public function __construct(FileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    public function saveHandler($request): bool
    {
        $this->articleData = array(
            'id'      => $request->get('id'),
            'words'   => $request->get('words'),
            'tables'  => $request->get('tables'),
            'images'  => $request->get('images'),
            'content' => $request->get('content')
        );

        $this->setStatistic();
        $result = $this->saveFile();
        if ($result){
            $this->logToFile();
        }

        return $result;
    }

    private function setStatistic()
    {
        $krl = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';

        $this->statistic = array(
            'words'  => str_word_count($this->articleData['content'], 0, $krl) - $this->articleData['words'],
            'tables' => $this->fileInfo->countTables($this->articleData['content']) - $this->articleData['tables'],
            'images' => $this->fileInfo->countImages($this->articleData['content']) - $this->articleData['images'],
            );
    }

    private function saveFile(): bool
    {
        $path = $this->fileInfo->getPath();
        $file = $path . $this->articleData['id'];

        $metadata  = '---' . "\r";
        $metadata .= $this->fileInfo->getMetadataBlock($file);
        $metadata .= '---' . "\n\n";

        try {
            file_put_contents($file, $metadata . $this->articleData['content']);
            return true;
        } catch (\Exception $e){
            return false;
        }
    }

    private function logToFile(){

        $rootDir = dirname(getcwd());
        $file = $rootDir . '/audit.log';
        $msg = "------ ПРАВКА -------\n";
        file_put_contents($file, $msg, FILE_APPEND);
        file_put_contents($file, print_r($this->statistic, true), FILE_APPEND);
    }

}