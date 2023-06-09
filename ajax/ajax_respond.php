<?php 
use Bitrix\Main\Loader;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Loader::includeModule("highloadblock");
/** @global CUser $USER */
use Bitrix\Highloadblock as HL;
$getQuery = htmlspecialcharsEx($_POST);

// ID HLBOCk Respond
$IBLOCK_ID = 14;

if(!empty($getQuery)) {
    $hlblock = HL\HighloadBlockTable::getById($IBLOCK_ID)->fetch(); //где ID - id highloadblock блока из которого будем получать данные
    $entity = HL\HighloadBlockTable::compileEntity($hlblock); 
    
    if ($getQuery['type'] === 'RESPOND') {
        $addCommentClass = $entity->getDataClass(); 

        // Данные нового элемента
        $newComment = [
            'UF_USER_ID' => $USER->GetID(),
            'UF_USER_NAME' => $getQuery['USER_NAME'],
            'UF_ID_COMMENT' => $getQuery['ID'],
            'UF_RESPOND' => $getQuery['respond'],
        ];

        // Добавление нового элемента в HighLoad блок
        $result = $addCommentClass::add($newComment);

        // ID нового элемента
        $newCommentId = $result->getId();
        
        if ($newCommentId) {
            echo 'Ответь успешно добавлено';
        }
    } 

} 