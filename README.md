# Vika

[Vika](https://vika.cn) PHP SDK [WIP]

## 环境要求

php 5.6.0+

## 安装

```shell
composer require vikadata/vika
```



## 获取 api_token

访问维格表的工作台，点击左下角的个人头像，进入「用户中心 > 开发者配置」。点击生成Token(首次使用需要绑定邮箱)。

## 使用
```php
<?php
require_once './vendor/autoload.php';
use Vika\Vika;

echo '<pre>';

Vika::auth('your api token');
//$datasheet = Vika::datasheet('dst0Yj5aNeoHldqvf6');

$all = Vika::datasheet('your dstId')->all([
    "fieldKey" => 'id'
]);
var_dump(json_encode($all->getData()->getRecords()));

$page = Vika::datasheet('dst0Yj5aNeoHldqvf6')->get(['pageNum' => 2, 'pageSize' => 2]);
var_dump(json_encode($page->getData()->getRecords()));

$attach = Vika::datasheet('dst0Yj5aNeoHldqvf6')->upload(__DIR__.'/image.png');
var_dump($attach);

$insertArr = [
    [
        'fields' => ['数字ID' => 88],
    ],
    [
        'fields' => ['数字ID' => 99],
    ]
];
$insert = Vika::datasheet('dst0Yj5aNeoHldqvf6')->add($insertArr, 'name');
var_dump('insert message ' . $insert->getMessage());

$insertRecords = $insert->getData()->getRecords();
$updateArr = [
    [
        'recordId' => $insertRecords[0]['recordId'],
        'fields' => ['数字ID' => 100],
    ],
    [
        'recordId' => $insertRecords[1]['recordId'],
        'fields' => ['数字ID' => 101],
    ]
];
$update = Vika::datasheet('dst0Yj5aNeoHldqvf6')->update($updateArr, 'name');
var_dump('update message ' . $update->getMessage());

$delete = Vika::datasheet('dst0Yj5aNeoHldqvf6')->del([$insertRecords[0]['recordId'], $insertRecords[1]['recordId'],]);
var_dump('delete message ' . $delete->getMessage());
echo '</pre>';
```