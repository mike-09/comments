<?php 
use Bitrix\Main\Loader;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Loader::includeModule("highloadblock");
use Bitrix\Highloadblock as HL;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

if(!empty($_POST)) {
    $hlblock = HL\HighloadBlockTable::getById($_POST['IBLOCK_ID'])->fetch(); //где ID - id highloadblock блока из которого будем получать данные
    $entity = HL\HighloadBlockTable::compileEntity($hlblock); 
    // Add new comment to product 
    if ($_POST['type'] === 'ADD_COMMENT') {
        $addCommentClass = $entity->getDataClass(); 
        // Values of new element  
        $newComment = [
            'UF_USER_ID' => $USER->GetID(),
            'UF_USER_NAME' => $_POST['user_name'],
            'UF_MESSAGE' => $_POST['message'],
            'UF_RATING' => $_POST['rating'],
            'UF_PRODUCT_ID' => $_POST['PRODUCT_ID']
        ];

        // adding new element to HighLoad блок
        $result = $addCommentClass::add($newComment);

        // ID new element  
        $newCommentId = $result->getId();
        
        if ($newCommentId) {
            echo 'Комментария успешно добавлено';
        }
    } 

    // Add like and dislike to comment
    if ($_POST['LIKE'] === 'LIKE' || $_POST['DISLIKE'] === 'DISLIKE') {
        $hasElement = false;
        $hasElementId = null;
        $arValues = array();
        $arSelect = array();
        $isLike = false;
        $isDisLike = false;

        if ($_POST['LIKE'] === 'LIKE') {
            $arSelect = array("UF_LIKE", "ID");
            $isLike = true;
        } else if ($_POST['DISLIKE'] === 'DISLIKE') {
            $arSelect = array("UF_DISLIKE", "ID");
            $isDisLike = true;
        }

        $addLikeClass = $entity->getDataClass(); 
        $arLikeProps = $addLikeClass::getList(array(
            "select" => $arSelect,
            "filter" => array("ID" => $_POST['ELEMENT_ID']) //Фильтрация выборки
        ))->fetch();

        if ($isLike === true && $isDisLike === false) {
            if (empty($arLikeProps['UF_LIKE']) || $arLikeProps['UF_LIKE'] == 0) {
                $arLikeProps['UF_LIKE'][] = $USER->GetID();
                $newValueLike = ['UF_LIKE' => $arLikeProps['UF_LIKE']];
                if ($arLikeProps['UF_LIKE']) {
                    $result = $addLikeClass::update($arLikeProps['ID'], $newValueLike);

                    if ($result->isSuccess()) {
                        echo 'Like успешно обновлено';
                    } else {
                        echo 'Ошибка при обновлении Like: '.$result->getErrorMessages();
                    }
                }
            } else {
                if (!in_array($USER->GetID(), $arLikeProps['UF_LIKE'])) {
                    // добавляем идентификатор пользователя в конец массива
                    $arLikeProps['UF_LIKE'][] = $USER->GetID();
                } else {
                    // удаляем идентификатор пользователя из массива
                    $arLikeProps['UF_LIKE'] = array_diff($arLikeProps['UF_LIKE'], array($USER->GetID()));
                }

                $likeValue = ['UF_LIKE' => $arLikeProps['UF_LIKE']];
                $result = $addLikeClass::update($arLikeProps['ID'], $likeValue);
    
                if ($result->isSuccess()) {
                    echo 'Like успешно обновлено';
                } else {
                    echo 'Ошибка при обновлении Like: '.$result->getErrorMessages();
                }
            }
        } else if ($isLike === false && $isDisLike === true) {
            if (empty($arLikeProps['UF_DISLIKE']) || $arLikeProps['UF_DISLIKE'] == 0) {
                $arLikeProps['UF_DISLIKE'][] = $USER->GetID();
                $newValueDislike = ['UF_DISLIKE' => $arLikeProps['UF_DISLIKE']];

                if ($arLikeProps['UF_DISLIKE']) {
                    // Добавление нового элемента в HighLoad блок
                    $result = $addLikeClass::update($arLikeProps['ID'], $newValueDislike);
            
                    if ($result->isSuccess()) {
                        echo 'DisLike успешно обновлено';
                    } else {
                        echo 'Ошибка при обновлении DisLike: '.$result->getErrorMessages();
                    }
                }
            } else {
                if (!in_array($USER->GetID(), $arLikeProps['UF_DISLIKE'])) {
                    // добавляем идентификатор пользователя в конец массива
                    $arLikeProps['UF_DISLIKE'][] = $USER->GetID();
                } else {
                    // удаляем идентификатор пользователя из массива
                    $arLikeProps['UF_DISLIKE'] = array_diff($arLikeProps['UF_DISLIKE'], array($USER->GetID()));
                }

                $dislikeValue = ['UF_DISLIKE' => $arLikeProps['UF_DISLIKE']];

                $result = $addLikeClass::update($arLikeProps['ID'], $dislikeValue);
    
                if ($result->isSuccess()) {
                    echo 'DisLike успешно обновлено';
                } else {
                    echo 'Ошибка при обновлении DisLike: '.$result->getErrorMessages();
                }
            }
        }
    }

    // Delete comment 
    if ($_POST['delete'] === 'delete-comment' && !empty($_POST['id'])) {
        $deleteElementClass = $entity->getDataClass(); 
        $result = $deleteElementClass::Delete($_POST['id']);

        if ($result->isSuccess()) {
            echo 'Элемент успешно удалено';
        } else {
            echo 'Ошибка при удалении элемент: '.$result->getErrorMessages();
        }
    }

    // Add complaint 
    if ($_POST['type'] === 'COMPLAINT') {
        $arResultClasss = $entity->getDataClass(); 
        $arCompaintValue = [];        
        $arSelect = array();

        $arSelect = array("UF_COMPLAINT", "ID");
        $arProperties = $arResultClasss::getList(array(
            "select" => $arSelect,
            "filter" => array("ID" => $_POST['ID']) //Фильтрация выборки
        ))->fetch();

        if(!empty($arProperties)) {
            $arProperties['UF_COMPLAINT'][] = $_POST['respond'];
            $arCompaintValue = array('UF_COMPLAINT' => $arProperties['UF_COMPLAINT']);
            $result = $arResultClasss::update($arProperties['ID'], $arCompaintValue);

            if ($result->isSuccess()) {
                echo 'Жалоба успешно обновлено';
            } else {
                echo 'Ошибка при обновлении жалобы: '.$result->getErrorMessages();
            }
        }
    }

} 