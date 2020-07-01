<?php

namespace Jmy\FeiYun\Model;

class Response
{
    /**
     * @var $ret integer
     */
    private $ret;

    /**
     * @var $msg string
     */
    private $msg;

    /**
     * @var $data
     */
    private $data;

    /**
     * @var $serverExecutedTime integer
     */
    private $serverExecutedTime;

    /**
     * @return int
     */
    public function getRet(): int
    {
        return $this->ret;
    }

    /**
     * @param int $ret
     * @return Response
     */
    public function setRet(int $ret): Response
    {
        $this->ret = $ret;
        return $this;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @param string $msg
     * @return Response
     */
    public function setMsg(string $msg): Response
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return int
     */
    public function getServerExecutedTime(): int
    {
        return $this->serverExecutedTime;
    }

    /**
     * @param int $serverExecutedTime
     * @return Response
     */
    public function setServerExecutedTime(int $serverExecutedTime): Response
    {
        $this->serverExecutedTime = $serverExecutedTime;
        return $this;
    }

}
