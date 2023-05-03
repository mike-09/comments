<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc as Loc;
Loc::loadMessages(__FILE__);

use Bitrix\Main\Loader; 
Loader::includeModule("highloadblock");
$HLPROJECTLIST_ID = array();
$HLSUBSCRIBE_ID = array();

$res = \Bitrix\Highloadblock\HighloadBlockTable::getList(array(
    'select' => array('*', 'ID' => 'ID'),
    'order' => array('ID' => 'ASC')
));

while ($row = $res->fetch()) {
    $HLSUBSCRIBE_ID[$row['ID']] = "[".$row["ID"]."] ".$row["NAME"];
}

$arComponentParameters = array(
    'GROUPS' => array(
    ),
    'PARAMETERS' => array(
        'HLBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('MAIN_IBLOCK_SUBSCRIBE'),
            'TYPE' => 'LIST',
            'VALUES' => $HLSUBSCRIBE_ID,
            'DEFAULT' => 'news',
            'REFRESH' => 'Y'
        ],

        "CACHE_TIME" => ["DEFAULT"=>360000],
        
        "ROWS_PER_PAGE" => [
            "PARENT" => "FILTER",
            "NAME" => GetMessage("ELEMENTS_COUNT"),
            "TYPE" => "STRING",
            "DEFAULT" => "20"
        ]
    )
);
