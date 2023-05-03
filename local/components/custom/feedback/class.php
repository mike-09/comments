<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader;
Loader::includeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpRequest;

class MyReviewsListComponent extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        // задаем значения по умолчанию
        $arParams["CACHE_TIME"] = intval($arParams["CACHE_TIME"]) > 0 ? intval($arParams["CACHE_TIME"]) : 3600;
        $arParams["HLBLOCK_ID"] = intval($arParams["HLBLOCK_ID"]);
        $arParams["ROWS_PER_PAGE"] = intval($arParams["ROWS_PER_PAGE"]) > 0 ? intval($arParams["ROWS_PER_PAGE"]) : 10;
        return $arParams;
    }
 
    public function executeComponent()
    {
        try {
            Loc::loadMessages(__FILE__);
 
            // проверяем, что требуется HLBLOCK_ID
            if (!$this->arParams['HLBLOCK_ID'])
                throw new \Exception(Loc::getMessage('HLBLOCK_NOT_DEFINED'));
 
            // проверяем, что такой HLBLOCK_ID существует
            if (!($hlblock = HighloadBlockTable::getById($this->arParams['HLBLOCK_ID'])->fetch()))
                throw new \Exception(Loc::getMessage('HLBLOCK_NOT_FOUND'));
 
            $this->arResult = $this->getReviews();
            $this->arResult["NAV_STRING"] = $this->getNavString();
            $this->includeComponentTemplate();
        } catch (\Exception $e) {
            ShowError($e->getMessage());
        }
    }
 
    private function getReviews()
    {
        // создаем сущность Highload блока
        $hlblock = HighloadBlockTable::getById($this->arParams['HLBLOCK_ID'])->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        
        // задаем пагинацию
        $page = $this->request->getQuery("page") ?: 1;
        $limit = $this->arParams["ROWS_PER_PAGE"];
        $offset = ($page - 1) * $limit;
 
        // задаем кэширование
        $cache_time = $this->arParams["CACHE_TIME"];
        $cache_id = 'reviews_list_' . $this->arParams["HLBLOCK_ID"] . '_' . $page;
        $cache_dir = '/reviews_list/' . $this->arParams["HLBLOCK_ID"];
        $cache = \Bitrix\Main\Data\Cache::createInstance();
 
        // проверяем, есть ли закэшированные данные
        if ($cache->initCache($cache_time, $cache_id, $cache_dir)) {
            $result = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $arOrder = array();

            // Сортировка по дате, оценке и по полезности 
            $sort = $this->request->getQuery('sort');

            if (!empty($sort) && $sort === 'date') {
                $arOrder = array("UF_DATE_CREATE" => "ASC");
            } elseif (!empty($sort) && $sort === 'rating') {
                $arOrder = array("UF_RATING" => "DESC");
            } elseif (!empty($sort) && $sort === 'utility') {
                $arOrder = array("UF_LIKE" => "ASC");
            } elseif (empty($sort)) {
                $arOrder = array("UF_DATE_CREATE" => "ASC");
            }

            // делаем запрос к БД, если данных в кэше не было
            $data = $entity_data_class::getList(
                [
                    'select' => ['*'],
                    "order" => $arOrder,
                    'filter' => ['UF_PRODUCT_ID' => $this->arParams['PRODUCT_ID'], 'UF_ACTIVE' => 1],
                    'limit' => $limit,
                    'offset' => $offset
                ]
            )->fetchAll();

            foreach ($data as &$arItem) {
                // изменяем формат даты
                $arDate = ParseDateTime($arItem['UF_DATE_CREATE'], FORMAT_DATETIME);
                $arItem['DATE'] = $arDate["DD"]." ".ToLower(GetMessage("MONTH_".intval($arDate["MM"])."_S"))." ".$arDate["YYYY"]. ", " . $arDate['HH'] . ':' . $arDate['MI'];
            }
            unset($arItem);
 
            $result = [
                'items' => [
                    'IBLOCK_ID' => $this->arParams['HLBLOCK_ID'],
                    'ITEMS' => $data,
                ],

                'nav_params' => [
                    'count' => $this->arParams['ROWS_PER_PAGE'],
                    'limit' => $limit,
                    'offset' => $offset
                ]
            ];
            // кэшируем данные
            $cache->endDataCache($result);
        }
 
        return $result["items"];
    }
 
    private function getNavString()
    {
        // делаем запрос к БД для получения кол-ва записей, чтобы правильно обработать пагинацию
        $hlblock = HighloadBlockTable::getById($this->arParams["HLBLOCK_ID"])->fetch();
        $entity = HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $cnt_res = $entity_data_class::getList([
            'select' => [new \Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)')],
            'filter' => [
                'UF_PRODUCT_ID' => $this->arParams['PRODUCT_ID'],
                'UF_ACTIVE' => 1,
            ],
        ])->fetch();


        $cnt = $cnt_res['CNT'];
        $nav = new \Bitrix\Main\UI\PageNavigation('page');
        $nav->allowAllRecords(false)
            ->setPageSize($this->arParams['ROWS_PER_PAGE'])
            ->setRecordCount($cnt)
            ->setCurrentPage($this->request->getQuery("page") ?: 1);
        return $nav;
    }
}