<?php

namespace Jmy\FeiYun;

use Jmy\FeiYun\Exception\FeiYunException;
use Jmy\FeiYun\Model\TaskResponse;

/**
 * http://www.feieyun.com/open/index.html?name=1
 * Class Client
 * @package Jmy\FeiYun
 */
class Client
{

    const BASE_URI = 'http://api.feieyun.cn/Api/Open/';

    private $guzzle;

    private $username;

    private $key;

    public function __construct(string $username, string $key, \GuzzleHttp\Client $guzzle)
    {
        $this->username = $username;
        $this->key = $key;
        $this->guzzle = $guzzle;
    }

    /**
     * @param string $sn
     * @param string $key
     * @param string|null $remark
     * @param string|null $phone
     * @return bool
     * @throws FeiYunException
     */
    public function addDevice(string $sn, string $key, string $remark = null, string $phone = null)
    {
        $data = $this->request([
            'apiname' => 'Open_printerAddlist',
            'printerContent' => implode('#', [$sn, $key, $remark, $phone])
        ]);
        if (count($data['no']) > 0) {
            throw new FeiYunException($data['no'][0]);
        }
        return count($data['ok']) > 0;
    }

    /**
     * @param string $sn
     * @param string $name
     * @param string|null $phone
     * @return bool
     * @throws FeiYunException
     */
    public function updateDevice(string $sn, string $name, string $phone = null)
    {
        return $this->request(array_filter([
            'apiname' => 'Open_printerEdit',
            'sn' => $sn,
            'name' => $name,
            'phonenum' => $phone
        ]));
    }

    /**
     * @param string $sn
     * @return bool
     * @throws FeiYunException
     */
    public function deleteDevice(string $sn)
    {
        $data = $this->request([
            'apiname' => 'Open_printerDelList',
            'snlist' => implode('-', [$sn])
        ]);
        if (count($data['no']) > 0) {
            throw new FeiYunException($data['no'][0]);
        }
        return count($data['ok']) > 0;
    }

    /**
     * @param string $sn
     * @param string $content
     * @param int $times
     * @return string $orderId
     * @throws FeiYunException
     */
    public function print(string $sn, string $content, int $times = 1)
    {
        return $this->request([
            'sn' => $sn,
            'content' => $content,
            'times' => $times,
            'apiname' => 'Open_printMsg'
        ]);
    }

    /**
     * @param string $orderId
     * @return bool
     * @throws FeiYunException
     */
    public function checkPrintStatus(string $orderId)
    {
        return $this->request([
            'apiname' => 'Open_queryOrderState',
            'orderid' => $orderId
        ]);
    }

    /**
     * @param string $sn
     * @return bool
     * @throws FeiYunException
     */
    public function clearPrint(string $sn)
    {
        return $this->request([
            'apiname' => 'Open_delPrinterSqs',
            'sn' => $sn
        ]);
    }

    /**
     * @param string $sn
     * @param \DateTimeImmutable $time
     * @return TaskResponse
     * @throws FeiYunException
     */
    public function findPrintQuantity(string $sn, \DateTimeImmutable $time)
    {
        $data =  $this->request([
            'apiname' => 'Open_queryOrderInfoByDate',
            'sn' => $sn,
            'date' => $time->format('Y-m-d')
        ]);
        return (new TaskResponse())->setPrint($data['print'])->setWaiting($data['waiting']);
    }

    /**
     * @param string $sn
     * @return string
     * @throws FeiYunException
     */
    public function checkStatus(string $sn)
    {
        return $this->request([
            'sn' => $sn,
            'apiname' => 'Open_queryPrinterStatus'
        ]);
    }

    public function request(array $params = [])
    {
        $time = time();
        $response = $this->guzzle->request('post', '', [
            'form_params' => array_merge([
                'user' => $this->username,
                'stime' => $time,
                'sig' => strtolower(sha1(implode([
                    $this->username, $this->key, $time
                ])))
            ], $params)
        ]);

        $data = json_decode($response->getBody()->getContents(), 1);
        if ($data['ret'] !== 0) {
            throw new FeiYunException($data['msg']);
        }
        return $data['data'];
    }
}
