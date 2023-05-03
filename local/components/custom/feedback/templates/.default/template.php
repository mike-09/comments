<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var CBitrixComponent $component */
$this->setFrameMode(true); ?>

<div class="wrapper" style="position: relative;">
    <div class="writing-button">
        <button class="writing-button__button button" data-modal="comment" <?if (!$USER->IsAuthorized()) { ?> disabled style="background: #a1d063;" <? } ?> >Написать отзыв</button>
        <div class="info-message">
            <p class="info-message__text">Только для зарегистрированных пользователей</p>
        </div>
    </div>

    <? // Add respond modal ?>
    <div class="feedback_block feedback_respond" data-respond-open="modal">
        <div class="feedback_form feedback_respond_form" data-ajax="modal">
            <div class="respond-close" data-respond-close="close">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 8C9.44771 7.44772 8.55228 7.44772 8 8C7.44771 8.55229 7.44771 9.44772 8 10L14 16L7.99999 22C7.44771 22.5523 7.44771 23.4477 7.99999 24C8.55228 24.5523 9.4477 24.5523 9.99999 24L16 18L22 24C22.5523 24.5523 23.4477 24.5523 24 24C24.5523 23.4477 24.5523 22.5523 24 22L18 16L24 9.99999C24.5523 9.44771 24.5523 8.55228 24 7.99999C23.4477 7.44771 22.5523 7.44771 22 7.99999L16 14L10 8Z" fill="#141414">
                    </path>
                </svg>
            </div>
            <h3 class="feedback_form-title">Ответить</h3>    
            <form action="/ajax/ajax_respond.php" method="POST" data-respond-form="send">
                <input type="hidden" name="type" value="RESPOND">
                <input type="hidden" name="USER_NAME" value="<?=$USER->GetFirstName();?>">
                <input type="hidden" name="ID" value="">
                
                <div class="message-block">
                    <span class="message-block-title">Ответ <sup>*</sup></span>
                    <span class="input-field__count">Введено символов 
                        <span data-text-current-count="">0</span> / 
                        <span data-text-limit-max="comment">1000</span>
                    </span>
                </div>

                <textarea id="textarea" name="respond" cols="30" rows="10" placeholder="Ответить"></textarea>
                <button class="feedback-button" type="submit">Ответить</button>
            </form>
        </div>
    </div>

    <? // Add complain modal ?>
    <div class="feedback_block feedback_complaint" data-complaint-open="modal">
        <div class="feedback_form feedback_complaint_form" data-ajax="modal">
            <div class="respond-close" data-complaint-close="close">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 8C9.44771 7.44772 8.55228 7.44772 8 8C7.44771 8.55229 7.44771 9.44772 8 10L14 16L7.99999 22C7.44771 22.5523 7.44771 23.4477 7.99999 24C8.55228 24.5523 9.4477 24.5523 9.99999 24L16 18L22 24C22.5523 24.5523 23.4477 24.5523 24 24C24.5523 23.4477 24.5523 22.5523 24 22L18 16L24 9.99999C24.5523 9.44771 24.5523 8.55228 24 7.99999C23.4477 7.44771 22.5523 7.44771 22 7.99999L16 14L10 8Z" fill="#141414">
                    </path>
                </svg>
            </div>
            <h3 class="feedback_form-title">Пожаловаться <span>&ensp;на отзыв</h3>    
            <form action="<?=$componentPath?>/ajax.php" method="POST" data-respond-form="send">
                <input type="hidden" name="type" value="COMPLAINT">
                <input type="hidden" name="IBLOCK_ID" value="<?=$arResult['IBLOCK_ID']?>">
                <input type="hidden" name="ID" value="">
                
                <div class="message-block">
                    <span class="message-block-title">Пожаловаться <span>&ensp;на отзыв</span> <sup>*</sup></span>
                    <span class="input-field__count">Введено символов 
                        <span data-text-current-count="">0</span> / 
                        <span data-text-limit-max="comment">1000</span>
                    </span>
                </div>

                <textarea id="textarea" name="respond" cols="30" rows="10" placeholder="Напишите причину жалобы"></textarea>
                <button class="feedback-button" type="submit">Ответить</button>
            </form>
        </div>
    </div>

    <? // Add comment modal ?>
    <div class="feedback_block feedback" data-feedback-open="modal">
        <div class="feedback_form" data-ajax="modal">
            <div class="feedback_form--head">
                <h3 class="feedback_form-title">Написать отзыв</h3>  
                <div class="form-send-close" data-feedback-close="close">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 8C9.44771 7.44772 8.55228 7.44772 8 8C7.44771 8.55229 7.44771 9.44772 8 10L14 16L7.99999 22C7.44771 22.5523 7.44771 23.4477 7.99999 24C8.55228 24.5523 9.4477 24.5523 9.99999 24L16 18L22 24C22.5523 24.5523 23.4477 24.5523 24 24C24.5523 23.4477 24.5523 22.5523 24 22L18 16L24 9.99999C24.5523 9.44771 24.5523 8.55228 24 7.99999C23.4477 7.44771 22.5523 7.44771 22 7.99999L16 14L10 8Z" fill="#141414">
                        </path>
                    </svg>
                </div>
            </div>
            <form action="<?=$componentPath?>/ajax.php" method="POST" id="add-comment">
                <div class="rating-block">
                    <div class="rating-block-title">Ваша оценка:</div>
                    <div class="rating rating_set">
                        <div class="rating__body">
                            <div class="rating__active"></div>
                            <div class="rating__items">
                                <input type="radio" class="rating__item" name="rating" value="1">
                                <input type="radio" class="rating__item" name="rating" value="2">
                                <input type="radio" class="rating__item" name="rating" value="3">
                                <input type="radio" class="rating__item" name="rating" value="4">
                                <input type="radio" class="rating__item" name="rating" value="5" checked>
                            </div>
                        </div>
                        <div class="rating__value">5</div>
                    </div>
                </div>

                <input type="hidden" name="user_name" value="<?=$USER->GetFirstName();?>">
                <input type="hidden" name="type" value="ADD_COMMENT">
                <input type="hidden" name="IBLOCK_ID" value="<?=$arResult['IBLOCK_ID']?>">
                <input type="hidden" name="PRODUCT_ID" value="<?=$arParams['PRODUCT_ID']?>">
                
                <div class="message-block">
                    <span class="message-block-title">Отзыв <sup>*</sup></span>
                    <span class="input-field__count">Введено символов 
                        <span data-text-current-count="">0</span> / 
                        <span data-text-limit-max="comment">1000</span>
                    </span>
                </div>
                <textarea id="textarea" name="message" cols="30" rows="10" placeholder="Напишите достоинства и недостатки товара"></textarea>
                <button class="feedback-button" type="submit">Опубликовать отзыв</button>
            </form>
        </div>
    </div>

<div class="feedback-block" data-comment-block="parent">

    <? // Sort block ?>
    <section class="sort-order" data-sort-block="parent" data-row-count="<?=$arParams["ROWS_PER_PAGE"]?>" data-iblock-id="<?=$arResult['IBLOCK_ID'];?>" data-prod-id="<?=$arParams['PRODUCT_ID']?>">
        <div class="sort-order__wrapper">
        <h2 class="sort-order__title">Сортировать по:
            <svg width="20" height="14" aria-hidden="true">
                <use xlink:href="#icon-sort"></use>
            </svg>
        </h2>
        <a href="?sort=date" class="sort-order__button sort-date <?if($_GET['sort'] === 'date' || empty($_GET['sort'])):?> active <?endif;?>" data-sort-value="date">
            Дате
        </a>
        <a href="?sort=rating" class="sort-order__button sort-rate <?if($_GET['sort'] === 'rating'):?> active <?endif;?>" data-sort-value="rating">
            Оценке
        </a>
        <a href="?sort=utility" class="sort-order__button sort-usefull <?if($_GET['sort'] === 'utility'):?> active <?endif;?>" data-sort-value="utility">
            Полезности
        </a>
        </div>
    </section>

    <? // Comment list ?>
    <ul class="feedback-block-comments">
        <?php foreach ($arResult['ITEMS'] as $arItem):?>
            <li class="user-comments-list" data-comment-id="<?=$arItem['ID']?>" data-iblock-id="<?=$arResult['IBLOCK_ID'];?>" data-comments-list="list">
            
            <?php $userData = \Bitrix\Main\UserTable::getList(array(
                'select' => ['NAME','PERSONAL_PHOTO'],
                'filter' => ['ID' => $arItem['UF_USER_ID']]))->fetch();?>

                <div class="user-comment__img">
                    <img src="<?=CFile::GetPath($userData["PERSONAL_PHOTO"])?>" alt="user-name">
                </div>

                <div class="user-comment-content">
                    <div class="user-comment__inner">
                        <div class="user-comment__header">
                            <span class="user-comment__name-autor"><?=$userData['NAME'];?></span>
                            <time class="user-comment__date" datetime="<?=$arItem['DATE'];?>"><?=$arItem['DATE'];?></time>
                            <div class="rating">
                                <div class="rating__body">
                                    <div class="rating__active"></div>
                                    <div class="rating__items">
                                        <input type="radio" class="rating__item" name="rating" value="1">
                                        <input type="radio" class="rating__item" name="rating" value="2">
                                        <input type="radio" class="rating__item" name="rating" value="3">
                                        <input type="radio" class="rating__item" name="rating" value="4">
                                        <input type="radio" class="rating__item" name="rating" value="5">
                                    </div>
                                </div>
                                <div class="rating__value"><?=$arItem['UF_RATING'];?></div>
                            </div>
                        </div>
                        <div class="user-comment__content-text" data-comment-parent="parent">
                            <p class="user-comment__text" data-comment="open">
                                <?=$arItem['UF_MESSAGE'];?>
                            </p>
                            <div class="user-comment__buttons" data-comment-button="parent">
                                <button class="user-comment__button" type="button" data-comment-button="open">Читать далее</button>
                                <button class="user-comment__button" type="button" data-comment-button="close">Свернуть</button>
                            </div>
                            <?php if (!empty($arItem['RESPONDS'])):?>
                                <div class="user-comment__answer-block">
                                    <div class="user-comment__answer-title">Ответы на Комментария</div>
                                    <?php foreach ($arItem['RESPONDS'] as $arRespond):
                                        $userRespondData = \Bitrix\Main\UserTable::getList(array(
                                            'select' => ['NAME','PERSONAL_PHOTO'],
                                            'filter' => ['ID' => $arRespond['UF_USER_ID']]
                                        ))->fetch();?>
                                        <div class="user-comment__answer">
                                            <div class="user-comment__answer-head">
                                                <img src="<?=CFile::GetPath($userRespondData["PERSONAL_PHOTO"])?>" alt="<?=$userRespondData['NAME'];?>">
                                            </div>
                                            <div class="user-comment__answer-content">
                                                <p class="user-comment__answer-author"><?=$userRespondData['NAME'];?></p>
                                                <p class="user-comment__answer-text"><?=$arRespond['UF_RESPOND'];?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif;?>
                        </div>

                        <div class="user-comment__footer"> 

                            <?if ($USER->IsAuthorized()) { ?>
                                <?php if ($arItem['UF_USER_ID'] === $USER->GetID()):?>
                                    <button class="user-comment__remove comment-footer-btn" type="button" data-modal="delete-comment">
                                        <span>
                                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.29289 2.29289C7.48043 2.10536 7.73478 2 8 2H12C12.2652 2 12.5196 2.10536 12.7071 2.29289C12.8946 2.48043 13 2.73478 13 3V4H7V3C7 2.73478 7.10536 2.48043 7.29289 2.29289ZM5 4V3C5 2.20435 5.31607 1.44129 5.87868 0.87868C6.44129 0.31607 7.20435 0 8 0H12C12.7956 0 13.5587 0.31607 14.1213 0.87868C14.6839 1.44129 15 2.20435 15 3V4H17H19C19.5523 4 20 4.44772 20 5C20 5.55228 19.5523 6 19 6H18V19C18 19.7957 17.6839 20.5587 17.1213 21.1213C16.5587 21.6839 15.7957 22 15 22H5C4.20435 22 3.44129 21.6839 2.87868 21.1213C2.31607 20.5587 2 19.7957 2 19V6H1C0.447715 6 0 5.55228 0 5C0 4.44772 0.447715 4 1 4H3H5ZM4 6V19C4 19.2652 4.10536 19.5196 4.29289 19.7071C4.48043 19.8946 4.73478 20 5 20H15C15.2652 20 15.5196 19.8946 15.7071 19.7071C15.8946 19.5196 16 19.2652 16 19V6H4Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <span>
                                            Удалить отзыв
                                        </span>
                                    </button>
                                <?php endif;?>
                            <? } ?>

                            <? if ($USER->IsAuthorized() && $USER->GetID() != $arItem['UF_USER_ID']) { ?>
                                <button class="user-comment__reply comment-footer-btn" type="button" data-respond="open">
                                    Ответить
                                </button>
                            <? } ?>

                            <? if ($USER->IsAuthorized() && $USER->GetID() != $arItem['UF_USER_ID']) { ?>
                                <button class="user-comment__report comment-footer-btn" type="button" data-modal="complaint">
                                    Пожаловаться <span>&ensp;на отзыв</span>
                                </button>
                            <? } ?>

                            <? if ($USER->IsAuthorized()) { ?>
                                <div class="comment-rating">
                                    <button class="comment-rating__like commnent-like-js <?if (array_search($USER->GetID(), $arItem['UF_LIKE']) !== false):?> like <?php endif;?>" type="button" data-is-like="LIKE">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.21918 0.593858C9.38203 0.232732 9.74539 0 10.1464 0C11.2228 0 12.2551 0.421425 13.0162 1.17157C13.7773 1.92171 14.2049 2.93912 14.2049 3.99998V6.99996H18.9279C19.367 6.99595 19.8018 7.08563 20.2025 7.26285C20.605 7.44092 20.9635 7.70312 21.253 8.03129C21.5426 8.35946 21.7563 8.74574 21.8793 9.16339C22.0023 9.58103 22.0317 10.02 21.9655 10.45L20.5654 19.4498C20.5653 19.4501 20.5654 19.4496 20.5654 19.4498C20.4551 20.1649 20.0864 20.8174 19.5272 21.2858C18.9695 21.7531 18.2595 22.0066 17.5277 21.9999H3.04391C2.23661 21.9999 1.46238 21.6838 0.89154 21.1212C0.320697 20.5586 0 19.7955 0 18.9999V11.9999C0 11.2043 0.320697 10.4412 0.89154 9.87862C1.46238 9.31602 2.23661 8.99995 3.04391 8.99995H5.42843L9.21918 0.593858ZM7.10245 10.2122L10.7631 2.09459C11.0689 2.19074 11.3501 2.35793 11.5813 2.58577C11.9618 2.96084 12.1756 3.46955 12.1756 3.99998V7.99995C12.1756 8.55223 12.6299 8.99995 13.1903 8.99995H18.9331L18.9446 8.99988C19.0917 8.99824 19.2374 9.02813 19.3715 9.08749C19.5057 9.14685 19.6252 9.23425 19.7217 9.34364C19.8183 9.45303 19.8895 9.58179 19.9305 9.721C19.9715 9.86009 19.9813 10.0063 19.9593 10.1495C19.9593 10.1493 19.9593 10.1496 19.9593 10.1495L18.559 19.15C18.5223 19.3884 18.3994 19.6058 18.213 19.7619C18.0265 19.9181 17.7891 20.0027 17.5444 19.9999L7.10245 19.9999V10.2122ZM5.07318 19.9999V10.9999H3.04391C2.77481 10.9999 2.51673 11.1053 2.32645 11.2928C2.13617 11.4804 2.02927 11.7347 2.02927 11.9999V18.9999C2.02927 19.2651 2.13617 19.5195 2.32645 19.707C2.51673 19.8945 2.77481 19.9999 3.04391 19.9999H5.07318Z" fill="currentColor" />
                                        </svg>
                                        <span class="span__like-value"><?php if(empty($arItem['UF_LIKE']) && !isset($arItem['UF_LIKE'])): echo 0; else: echo count($arItem['UF_LIKE']); endif;?></span>
                                    </button>

                                    <button class="comment-rating__dislike commnent-like-js <?if (array_search($USER->GetID(), $arItem['UF_DISLIKE']) !== false):?> like <?php endif;?>" type="button" data-is-like="DISLIKE">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5284 2.31594C19.2813 2.10686 18.9649 1.9945 18.6392 2.00017L18.6213 2.00033H16.9268V11.0002H18.6213L18.6392 11.0003C18.9649 11.006 19.2813 10.8936 19.5284 10.6846C19.7607 10.4881 19.9166 10.219 19.9707 9.92333V3.07718C19.9166 2.78146 19.7607 2.51242 19.5284 2.31594ZM14.8975 11.788L11.2369 19.9054C10.9311 19.8093 10.6499 19.6421 10.4187 19.4143C10.0382 19.0392 9.82437 18.5305 9.82437 18.0001V14.0001C9.82437 13.4479 9.3701 13.0001 8.80973 13.0001H3.06689L3.0554 13.0002C2.90832 13.0019 2.76264 12.972 2.62845 12.9126C2.49426 12.8532 2.37477 12.7658 2.27826 12.6565C2.18175 12.5471 2.11052 12.4183 2.06951 12.2791C2.02855 12.1401 2.01872 11.9939 2.04067 11.8508C2.04064 11.851 2.0407 11.8506 2.04067 11.8508L3.44098 2.85025C3.47767 2.6118 3.60057 2.39445 3.78702 2.23826C3.97347 2.08206 4.21092 1.99754 4.45562 2.00026L14.8975 2.00033V11.788ZM18.6131 0.000361632C19.4325 -0.0115716 20.2282 0.272184 20.8502 0.79837C21.4746 1.32665 21.8805 2.06251 21.9908 2.86627C21.9969 2.9107 22 2.95548 22 3.00031V10.0002C22 10.045 21.9969 10.0898 21.9908 10.1342C21.8805 10.938 21.4746 11.6739 20.8502 12.2021C20.2282 12.7283 19.4325 13.0121 18.6131 13.0001H16.5716L12.7808 21.4061C12.618 21.7673 12.2546 22 11.8536 22C10.7772 22 9.74494 21.5786 8.98381 20.8284C8.22269 20.0783 7.79509 19.0609 7.79509 18.0001V15.0001H3.07208C2.63299 15.0041 2.1982 14.9144 1.79754 14.7372C1.39498 14.5592 1.0365 14.297 0.746959 13.9688C0.457416 13.6406 0.243729 13.2543 0.120703 12.8367C-0.00232333 12.4191 -0.0317481 11.9801 0.0344685 11.5501L1.43465 2.55038C1.43469 2.55008 1.4346 2.55068 1.43465 2.55038C1.54489 1.83539 1.91364 1.1828 2.47276 0.714404C3.03052 0.247157 3.74039 -0.00629771 4.47224 0.000361632H18.6131Z" fill="currentColor" />
                                        </svg>
                                        <span class="span__like-value"><?php if(empty($arItem['UF_DISLIKE']) && !isset($arItem['UF_DISLIKE'])): echo 0; else: echo count($arItem['UF_DISLIKE']); endif;?></span>
                                    </button>
                                </div>
                            <? } ?>

                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach;?>

        <?php 
        if ($arParams['ROWS_PER_PAGE'] > 0):
            $APPLICATION->IncludeComponent(
                'bitrix:main.pagenavigation',
                '.default',
                array(
                    'NAV_OBJECT' => $arResult['NAV_STRING'],
                    'SEF_MODE' => 'N',
                ),  false 
            );
        endif;?>

    </ul>
</div>

<div class="overlay"></div>
