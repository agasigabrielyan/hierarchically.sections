<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Loader;
Loader::includeModule('iblock');

class HierarhicallySections extends \CBitrixComponent {
    private $chosenSectionId;

    private function getSectionsOfChoosedSection() {
        $this->chosenSectionId = str_ireplace('SECTION_CODE_','',$this->arParams['SECTION_ID']);

        $rsParentSection = CIBlockSection::GetByID($this->chosenSectionId);

        if ($arParentSection = $rsParentSection->GetNext())
        {
            $sectionsData[$this->chosenSectionId] = $arParentSection;
            $sectionsIds[] = $this->chosenSectionId;

            $arFilter = array(
                'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],
                '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],
                '>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
            $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);

            while ($arSect = $rsSect->GetNext())
            {
                $sectionsIds[] = $arSect['ID'];
                $sectionsData[$arSect['ID']] = $arSect;
            }
        }

        
        $sections = [
            'SECTIONS_DATA' => $sectionsData,
            'SECTIONS_IDS'   => $sectionsIds
        ];
        return $sections;
    }

    private function getElementsBySections() {
        $sections = $this->getSectionsOfChoosedSection();

        $dbElements = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID'],'IBLOCK_SECTION_ID' => $sections['SECTIONS_IDS'],'ACTIVE' => 'Y'],
            false,
            false,
            []
        );

        while($element = $dbElements -> GetNextElement()) {
            $rowElement = array_merge(
                $element -> getFields(),
                ['PROPERTIES' => $element -> getProperties()]
            );
            $sections['SECTIONS_DATA'][$rowElement['IBLOCK_SECTION_ID']]['ELEMENTS'][] = $rowElement;
        }

        return $sections['SECTIONS_DATA'];
    }

    public function executeComponent()
    {
        if($this->startResultCache()) {
            $this->arResult['SECTIONS'] = $this->getElementsBySections();
            $this->includeComponentTemplate();
        }
    }
}