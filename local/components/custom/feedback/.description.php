<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
    "NAME" => GetMessage("NEWS_COMPONENT"),
    "DESCRIPTION" => GetMessage("NEWS_COMPONENT_DESCRIPTION"),
    "SORT" => 20,
    "PATH" => array(
        "ID" => "subscribeHighLoadBlock",
        "CHILD" => array(
            "ID" => "subscribeList",
            "NAME" => GetMessage("NEWS_COMPONENT"),
            "SORT" => 10,
        )
    ),
);