<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');
/**
 * @var $arResult array
 */
?>
<div class="sections">
    <?php $paddingLeft = 30; ?>
    <?php $firstDepthLevel = $arResult['SECTIONS'][array_keys($arResult['SECTIONS'])[0]]['DEPTH_LEVEL']; ?>

        <?php foreach($arResult['SECTIONS'] as $key => $section): ?>
           <div class="sections__cell" style="padding-left: <?= $paddingLeft * ($section['DEPTH_LEVEL'] - $firstDepthLevel). 'px' ?>">
               <h3>
                   <span><?= $section['NAME']; ?></span>
               </h3>
           </div>
        <?php endforeach; ?>

</div>

