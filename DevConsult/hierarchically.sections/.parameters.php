<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arCurrentValues */
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

if(Loader::includeModule('iblock')) {
    $arTypesEx = CIBlockParameters::GetIBlockTypes();

    $arIblocks = array();
    $dbIblock = CIBlock::GetList(
        ['SORT'=>'ASC'],
        [
            'SITE_ID'=>$_REQUEST['site'],
            'TYPE'=> ""
        ]
    );
    while($arRes=$dbIblock->Fetch()) {
        $arIblocks[$arRes['ID']] = "[" . $arRes['ID'] . "]" . $arRes['NAME'];
    }

    if(count($arIblocks)>0) {
        $arFilter = array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'] ? $arCurrentValues['IBLOCK_ID'] : array_keys($arIblocks)[0],
            'GLOBAL_ACTIVE'=>'Y',
        );

        $arSelect = array('IBLOCK_ID','ID','NAME','DEPTH_LEVEL','IBLOCK_SECTION_ID');
        $arOrder = array('DEPTH_LEVEL'=>'ASC','SORT'=>'ASC');
        $rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);

        $sectionLinc = array();
        $arResult['ROOT'] = array();
        $sectionLinc[0] = &$arResult['ROOT'];
        while($arSection = $rsSections->GetNext()) {
            $sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
            $sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
        }

        $ierarhiSections = $sectionLinc[0]['CHILD'];

        $sectionsReadyToOutput = [];
        $sects = getHierarchicallySections($ierarhiSections,$sectionsReadyToOutput);

        $arSections = [];
        foreach ($sects as $key => $singleSection)
        {
            $depthLevel = intval($singleSection['DEPTH_LEVEL']);
            $depthLevelInfo = "";
            for($counter=0; $counter < $depthLevel; $counter ++) {
                $depthLevelInfo .= " - ";
            }
            $arSections['SECTION_CODE_' . $singleSection['ID']] = "[" . $singleSection['ID'] . "]" . $depthLevelInfo . $singleSection['NAME'];
        }

    } else {
        $arSections = [];
    }

    $arComponentParameters = array(
        "PARAMETERS" => array(
            "IBLOCK_ID" => array(
                "PARENT" => "BASE",
                'NAME' => Loc::getMessage('IBLOCK_ID'),
                'TYPE' => 'LIST',
                'VALUES' => $arIblocks,
                'DEFAULT' => "",
                'REFRESH' => "Y"
            ),
            "SECTION_ID" => array(
                "PARENT" => "BASE",
                'NAME' => Loc::getMessage('SECTION_ID'),
                'TYPE' => 'LIST',
                'VALUES' => $arSections,
                'REFRESH' => "Y"
            ),
            "CACHE_TIME" => array("DEFAULT"=>36000000)
        )
    );
}




function getHierarchicallySections($sections, &$sectionsReadyToOutput = []) {
    foreach($sections as $sectionKey => $sectionData) {
        $sectionsReadyToOutput[] = $sectionData;
        if(count($sectionData['CHILD'])>0 && $sectionData['CHILD'] !== NULL) {
            getHierarchicallySections($sectionData['CHILD'],$sectionsReadyToOutput);
        }
    }

    return $sectionsReadyToOutput;
}