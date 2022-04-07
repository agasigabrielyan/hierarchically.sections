<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');
/**
 * @var $arResult array
 */
?>
<h3>Иерархическая структура выбранного раздела</h3>

<ul class="hierarchically">
    <?php foreach($arResult['SECTIONS'] as $secKey => $section): ?>
        <?php
            $countedWidth = $section['DEPTH_LEVEL']>1 ? (100 - ($section['DEPTH_LEVEL'] * 10)) : 90;
            $counterMarginLeft  = $section['DEPTH_LEVEL']>1 ? ($section['DEPTH_LEVEL'] * 10) : 10;
            $counterMarginBottom = $section['DEPTH_LEVEL'] === 1 ? '30px' : '0px';
        ?>
        <li style="margin-bottom:<?= $counterMarginBottom; ?>; margin-left:<?= $counterMarginLeft . '%' ?>; width: <?= $countedWidth . '%'?>">
            <div class="alert alert-primary hierarchically__section">
                <?= $section['NAME']; ?>
                <?php if(count($section['ELEMENTS'])>0): ?>
                    <svg width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>
                <?php endif; ?>
            </div>

            <?php if(count($section['ELEMENTS'])>0): ?>
                <ul class="alert alert-info hierarchically__elements">
                    <h3>Элементы раздела</h3>
                    <?php foreach($section['ELEMENTS'] as $elKey => $element): ?>
                        <li class="hierarchically__element">
                            <a href="<?= $element['DETAIL_PAGE_URL'] ?>">
                                - <?= $element['NAME']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </li>
    <?php endforeach; ?>
</ul>


