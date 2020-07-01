<?php

namespace Jmy\FeiYun\Model\Widget;

class Text
{
    private $text;

    public function __construct(string $text, bool $bold = false, bool $l = false, bool $w = false, bool $enlarge = false)
    {
        $this->text = $text;
        if ($bold) {
            $this->text = sprintf("<BOLD>%s</BOLD>", $this->text);
        }
        if ($l) {
            $this->text = sprintf("<L>%s</L>", $this->text);
        }
        if ($w) {
            $this->text = sprintf("<W>%s</W>", $this->text);
        }
        if ($enlarge) {
            $this->text = sprintf("<B>%s</B>", $this->text);
        }
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Text
     */
    public function setText(string $text): Text
    {
        $this->text = $text;
        return $this;
    }

    public function __toString()
    {
        return $this->text;
    }

}
