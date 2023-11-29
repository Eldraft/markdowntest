<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ArticleSave
{
    public $fileInfo;
    private $articleData;
    private $statistic;

    public function __construct(FileInfo $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }

    public function saveHandler($request){

        $this->articleData = array(
            'id'      => $request->get('id'),
            'words'   => $request->get('words'),
            'tables'  => $request->get('tables'),
            'images'  => $request->get('images'),
            'content' => $request->get('content')
        );

        $this->setStatistic();
        return $this->saveFile();
    }

    private function setStatistic()
    {
        $this->statistic = array(
            'words'  => str_word_count($this->articleData['content']) - $this->articleData['words'],
            'tables' => $this->fileInfo->countTables($this->articleData['content']) - $this->articleData['tables'],
            'images' => $this->fileInfo->countImages($this->articleData['content']) - $this->articleData['images'],
            );
    }

    private function saveFile(): bool
    {
        $rootDir = dirname(getcwd());
        $ds = DIRECTORY_SEPARATOR;
        $folder = 'icecream/articles';
        $file = $rootDir . $ds . $folder . $ds. $this->articleData['id'];

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

}