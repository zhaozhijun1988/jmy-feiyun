<?php

namespace Jmy\FeiYun\Model;

class TaskResponse
{
    /**
     * @var $print integer
     */
    private $print;

    /**
     * @var $waiting integer
     */
    private $waiting;

    /**
     * @return int
     */
    public function getPrint(): int
    {
        return $this->print;
    }

    /**
     * @param int $print
     * @return TaskResponse
     */
    public function setPrint(int $print): TaskResponse
    {
        $this->print = $print;
        return $this;
    }

    /**
     * @return int
     */
    public function getWaiting(): int
    {
        return $this->waiting;
    }

    /**
     * @param int $waiting
     * @return TaskResponse
     */
    public function setWaiting(int $waiting): TaskResponse
    {
        $this->waiting = $waiting;
        return $this;
    }
}
