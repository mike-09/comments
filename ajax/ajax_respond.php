<?php 
use Bitrix\Main\Loader;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Loader::includeModule("highloadblock");
/** @global CUser $USER */
use Bitrix\Highloadblock as HL;

// ID HLBOCk Respond
$IBLOCK_ID = 14;

if(!empty($_POST)) {
    $hlblock = HL\HighloadBlockTable::getById($IBLOCK_ID)->fetch(); //где ID - id highloadblock блока из которого будем получать данные
    $entity = HL\HighloadBlockTable::compileEntity($hlblock); 
    
    if ($_POST['type'] === 'RESPOND') {
        $addCommentClass = $entity->getDataClass(); 

        // Данные нового элемента
        $newComment = [
            'UF_USER_ID' => $USER->GetID(),
            'UF_USER_NAME' => $_POST['USER_NAME'],
            'UF_ID_COMMENT' => $_POST['ID'],
            'UF_RESPOND' => $_POST['respond'],
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