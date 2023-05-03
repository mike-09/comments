<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponent $component */

CModule::IncludeModule("iblock");
?>

<div class="container">
    <?php $APPLICATION->IncludeComponent(
        "custom:feedback",
        "",
        Array(
            "CACHE_TIME" => "3600000",
            "CACHE_TYPE" => "A",
            "HLBLOCK_ID" => "13",
            "ROWS_PER_PAGE" => "10",
            "PRODUCT_ID" => $arResult['ID'],
        )
    );?>
</div>