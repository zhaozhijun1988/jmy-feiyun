<?php

namespace Jmy\FeiYun;

use Jmy\FeiYun\Model\Widget\Table;

class Drawing
{

    /**
     * @var string[] $content
     */
    private $content;


    public function __construct()
    {
        $this->content = [];
    }

    public function addTitle(string  $title)
    {
        $this->content[] = "<CB>{$title}</CB>";
    }

    public function addP(string $text, string $align = 'left')
    {
        if ($align == 'right') {
            $this->content[] = " <RIGHT>{$text}</RIGHT>";
            return;
        }
        if ($align == 'center') {
            $this->content[] = " <C>{$text}</C>";
            return;
        }
        $this->content[] = $text;
    }


    public function addBr()
    {
        $this->content[] = '';
    }

    public function addDivider()
    {
        $this->content[] = '--------------------------------';
    }

    public function addQr(string $text)
    {
        $this->content[] = "<QR>{$text}</QR>";
    }

    public function addTable(array $data, array $style = [])
    {
        $t = new Table();
        if (count($style) > 0) {
            $t->setStyle($style);
        }
        $t->setData($data);
        $t->setData($data);
        $this->content[] = $t->getOutput();
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return implode("<BR>", $this->content);
    }

    public function setContent($content): Drawing
    {
        $this->content = $content;
        return $this;
    }


}
