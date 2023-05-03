<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */

use Bitrix\Main\Loader;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Loader::includeModule("highloadblock");
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\SystemException;

$hlblockId = 14;
$cacheTime = 36000;
$cacheId = md5($hlblockId);

if (Loader::includeModule('highloadblock')) {
    try {
        $hlblock = HighloadBlockTable::getById($hlblockId)->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entityDataClass = $entity->getDataClass();

        $cache = \Bitrix\Main\Data\Cache::createInstance();

        if ($cache->initCache($cacheTime, $cacheId)) {
            $result = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            foreach ($arResult['ITEMS'] as $key => $arItem) {
                $arResult['ITEMS'][$key] = getCommentAnswers($arItem, $entityDataClass, $cacheTime);
            }

            if ($arResult['ITEMS']) {
                $result = $arResult['ITEMS']; 
            }

            if ($result) {
                $cache->endDataCache($result);
            } else {
                $cache->abortDataCache();
            }
        }
    } catch (SystemException $exception) {
        echo "Query fiald" . $exception->getMessage();
    }
}

function getCommentAnswers($arItem, $entityDataClass, $cacheTime) {
    $arElements = [];
    $data = $entityDataClass::getList(array(
        "select" => array("*"),
        "order" => array("ID" => "DESC"),
        "filter" => array("UF_ID_COMMENT" => $arItem['ID'], "UF_ACTIVE" => 1), //Фильтрация выборки
        'cache' => [
            'ttl' => $cacheTime,
            'cache_joins' => true,
        ]
    ));

    while($arData = $data->Fetch()) {
        $arElements[$arItem['ID']][$arData['ID']] = $arData;
    }

    $arItem['RESPONDS'] = $arElements[$arItem['ID']];
    return $arItem;
} ?>
