### 飞鹅云 api

#### demo

```
$guzzle = new GuzzleHttp\Client(['base_uri' => 'http://api.feieyun.cn/Api/Open/']);

$client = new Client('usernmae', 'password', $guzzle);
$d = new Drawing();
$d->addTitle('测试标题');

$d->addTable([[ '名称', '单价', '数量', '金额'],]);

$d->addDivider();

$d->addTable([
    [ '酸菜鱼', '100.4', '3', '1000',],
    [ '可乐鸡翅+蒜蓉蒸扇贝', '100.4', '3', '1000',],
    [ '紫苏焖鹅+梅菜肉饼+椒盐虾+北京烤鸭', '100.4', '3', '1000'],
]);

$d->addDivider();

$d->addP('合计 18.00', 'right');

$d->addP('合计 18.00', 'center');

$d->addP('合计 18.00');

$d->addP('备注：'. (new Text('多方辣酱多方蓝鲸', true)));
$d->addP('备注：'. (new Text('多方辣酱多方蓝鲸', false, true)));
$d->addP('备注：'. (new Text('多方辣酱多方蓝鲸', false, false, false, true)));

$client->print('sn', $d->getContent());

```
