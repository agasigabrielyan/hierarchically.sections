<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;

$arComponentDescription = [
    "NAME" => Loc::getMessage("HIERARCHICALLY_SECTIONS_COMPONENT_NAME"),
    "DESCRIPTION" => Loc::getMessage("HIERARCHICALLY_SECTIONS_COMPONENT_DESCRIPTION"),
    "PATH" => [
        'ID' => "DevConsult",
        "NAME" => Loc::getMessage('DEV_CONSULT_COMPANY_NAME')
    ]
];