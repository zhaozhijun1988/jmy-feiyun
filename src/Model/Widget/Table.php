<?php

namespace Jmy\FeiYun\Model\Widget;

class Table
{

    const MAX_WIDTH = 32;

    /**
     * @var string[] $title
     */
    private $title;

    /**
     * @var integer[] $style
     */
    private $style;

    /**
     * @var string[] $data
     */
    private $data;

    public function __construct()
    {
        $this->style = [14, 6, 4, 5];
    }

    /**
     * @return string[]
     */
    public function getTitle(): array
    {
        return $this->title;
    }

    /**
     * @param string[] $title
     * @return Table
     */
    public function setTitle(array $title): Table
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return integer[]
     */
    public function getStyle(): array
    {
        return $this->style;
    }

    /**
     * @param integer[] $style
     * @return Table
     */
    public function setStyle(array $style): Table
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string[] $data
     * @return Table
     */
    public function setData(array $data): Table
    {
        $this->data = $data;
        return $this;
    }

    public function getOutput()
    {
        if (array_sum($this->getStyle()) > self::MAX_WIDTH) {
            throw new \LogicException('max width 32 bytes');
        }

        $output = [];
        foreach ($this->getData() as $index => $line) {
            if (count($line) !== count($this->getStyle())) {
                throw new \LogicException('cell quantity not match style quantity');
            }
            $tr = [];
            foreach ($line as $k => $v) {
                $tr[] = $this->breakLine($v, $this->style[$k]);
            }
            $output[] = $this->formatTr($tr);
        }
        return implode("<BR>", $output);
    }

    public function formatTr(array $tds)
    {
        $max = max(array_map(function ($item) {
            return count($item);
        }, $tds));

        $result = [];
        for ($i = 0; $i < $max; $i++) {
            $temp = [];
            foreach ($tds as $index => $td) {
                $text = array_key_exists($i, $td) ? $td[$i] : '';
                $len = strlen(iconv("UTF-8", "GBK//IGNORE", $text));
                $temp[] =  $len >= $this->style[$index] ? $text : $this->strPad($text, $this->style[$index], $index == 0);
            }
            $result[] = implode(' ', $temp);
        }
        return implode("<BR>", $result);
    }

    public function strPad(string $str, int $max, bool $alignLeft = true)
    {
        for ($i = 0; $i < $max; $i++) {
            $len = strlen(iconv("UTF-8", "GBK//IGNORE", $str));
            if ($len >= $max) {
                return $str;
            }
            $alignLeft ? $str.=' ' : ($str = ' '.$str);
        }
        return $str;
    }

    public function breakLine(string $text, int $len)
    {
        $result = [];
        $s = '';
        $j = 0;
        for ($i = 1; $i <= mb_strlen($text); $i++) {
            $str = mb_substr($text, $j, $i - $j);
            if (strlen(iconv("UTF-8", "GBK//IGNORE", $str)) > $len) {
                $result[] = mb_substr($text, $j, $i - $j -1);;
                $j = $i - 1;
            } elseif (strlen(iconv("UTF-8", "GBK//IGNORE", $str)) == $len) {
                $result[] = $str;
                $j = $i;
            } elseif (mb_strlen($text) === $i) {
                $result[] = $str;
            }
        }
        return $result;
    }

}
