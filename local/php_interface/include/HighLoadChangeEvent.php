<?php
use Bitrix\Main, Bitrix\Main\Loader, Bitrix\Main\Entity;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
Loader::includeModule("highloadblock");

function OnAfterUpdate(Entity\Event $event) {
    $arResult = [];
    $UF_RATING = [];
    $MY_HL_BLOCK_ID = 5;
    $PROPERTY_RATING_CODE = "PRODUCT_RATING_CNT";
    $PROPERTY_REVIEW_CODE = "PRODUCT_COMMENTS_CNT";

    // получаем массив полей хайлоад блока
    $arFields = $event->getParameter("fields");

    // Получаем id товара из highload block
    $UF_PRODUCT_ID = $arFields['UF_PRODUCT_ID']['VALUE'];

    // Получаем все отзывы которые относиться к конкретным товарам!
    CModule::IncludeModule('highloadblock');
    $entity_update_class = GetEntityDataClass($MY_HL_BLOCK_ID);
    $rsData = $entity_update_class::getList(array(
        'select' => array('*'),
        'filter' => array('UF_ACTIVE' => '1', 'UF_PRODUCT_ID' => $UF_PRODUCT_ID),
    ));

    while($elements = $rsData->fetch()) {
        $UF_RATING[] = $elements['UF_RATING'];
        $arResult[$elements['ID']] = $elements;
    }

    $reviews_count = count($arResult);
    $rating = array_sum($UF_RATING);

    if($reviews_count == 0) {
        $rating_sum = 0;
    } else {
        $rating_sum = substr($rating / $reviews_count, 0, 3);
    }


    CIBlockElement::SetPropertyValueCode($UF_PRODUCT_ID, $PROPERTY_REVIEW_CODE, $reviews_count);
    CIBlockElement::SetPropertyValueCode($UF_PRODUCT_ID, $PROPERTY_RATING_CODE, $rating_sum);

}

function OnBeforeDelete(\Bitrix\Main\Entity\Event $event) {
    $MY_HL_BLOCK_ID = 5;
    $arResult = [];
    $UF_PRODUCT_ID = [];
    $UF_RATING = [];
    $PROPERTY_RATING_CODE = "PRODUCT_RATING_CNT";
    $PROPERTY_REVIEW_CODE = "PRODUCT_COMMENTS_CNT";


    //id удаляемого элемента
    $id = $event->getParameter("id");
    $id = $id["ID"];

    // Получаем удаляемый отзыв
    CModule::IncludeModule('highloadblock');
    $entity_delete_class = GetEntityDataClass($MY_HL_BLOCK_ID);
    $rsData = $entity_delete_class::getList(array(
        'select' => array('*'),
        'filter' => array('UF_ACTIVE' => '1', 'ID' => $id),
    ));

    while($elements = $rsData->fetch()) {
        $UF_PRODUCT_ID = $elements['UF_PRODUCT_ID'];
    }

    // Получаем все отзывы кроме удаляемый
    $entity_all_element = GetEntityDataClass($MY_HL_BLOCK_ID);
    $rsData = $entity_all_element::getList( array(
        'select' => array('*'),
        'filter' => array('UF_ACTIVE' => '1', '!ID' => $id, 'UF_PRODUCT_ID' => $UF_PRODUCT_ID),
    ));

    while($elements = $rsData->fetch()) {
        $UF_RATING[] = $elements['UF_RATING'];
        $arResult[$elements['ID']] = $elements;
    }

    $reviews_count = count($arResult);
    $rating = array_sum($UF_RATING);

    if($reviews_count == 0) {
        $rating_sum = 0;
    } else {
        $rating_sum = substr($rating / $reviews_count, 0, 3);
    }

    CIBlockElement::SetPropertyValueCode($UF_PRODUCT_ID, $PROPERTY_REVIEW_CODE, $reviews_count);
    CIBlockElement::SetPropertyValueCode($UF_PRODUCT_ID, $PROPERTY_RATING_CODE, $rating_sum);
}
