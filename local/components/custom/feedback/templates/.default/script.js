$(document).ready(function() {

    // Strinng count on typing message 
    $('#textarea').bind('input', function(){
        $('[data-text-current-count]').html($(this).val().length);
    });

    // Strinng count on typing message 
    if ($('#textarea').val().length > 0) {
        $('[data-text-current-count]').html($('#textarea').val().length);
    }
    
    // Click comment button
    $(document).on('click', '.commnent-like-js', function(){
        likeButtonEvent($(this));
    });

    // Ответить на коммментарии 
    $('[data-respond-form="send"]').submit(function (event) {
        event.preventDefault();

        let formBlock = $(this).closest('[data-ajax="modal"]');

        console.log($(formBlock));

        // Получаем данные формы
        var respondData = $(this).serialize();
        var url = $(this).attr('action');
    
        // Отправляем запрос на сервер через BX.ajax
        BX.ajax({
            method: 'POST',
            url: url,
            data: respondData,
            processData: false,
            start: true,
            onsuccess: function(response) {
                $(formBlock).find('form').remove();
                var successMessage = '<div class="success">Форма успешно добавлена</div>';
                $(formBlock).append(successMessage);
            },
            onfailure: function() {
                $(formBlock).find('form').remove();
                var successMessage = '<div class="success" style="font-size: 20px; line-height: 30px; text-align: center;">Ошибка сервера</div>';
                $(formBlock).append(successMessage);
            }
        });
    });


    // Добавление комментарий 
    $("#add-comment").submit(function (event) {
        // Отключаем стандартное поведение браузера на сабмит формы
        event.preventDefault();
        let formBlock = $(this).closest('[data-ajax="modal"]');

        // Получаем данные формы
        var formData = $(this).serialize();
        
        // Отправляем запрос на сервер через BX.ajax
        BX.ajax({
            method: 'POST',
            url: "/ajax/ajax.php",
            data: formData,
            processData: false,
            start: true,
            onsuccess: function(response) {
                $(formBlock).find('form').remove();
                var successMessage = '<div class="success" style="font-size: 20px; line-height: 30px; text-align: center;">Форма успешно добавлена</div>';
                $(formBlock).append(successMessage);
            },
            onfailure: function() {
                $(formBlock).find('form').remove();
                var successMessage = '<div class="success" style="font-size: 20px; line-height: 30px; text-align: center;">Ошибка сервера</div>';
                $(formBlock).append(successMessage);
            }
        });
    });

    // Active delete button
    $('[data-modal="delete-comment"]').click(function (event) { 
        deleteComment($(this));
    });

    // Close respond modal 
    $('[data-respond-close="close"]').click(function () { 
        $('[data-respond-open="modal"]').removeClass('active');
        $('.overlay').removeClass('active');
    });

    // Open respond modal
    $('[data-respond="open"]').click(function () { 
        let elementId = $(this).closest('.user-comments-list').attr('data-comment-id');
        $('[data-respond-open="modal"]').addClass('active');
        $('[data-respond-open="modal"]').find('input[name="ID"]').val(elementId);
        $('.overlay').addClass('active');
    });

    // Close complaint modal
    $('[data-complaint-close="close"]').click(function () { 
        $('[data-complaint-open="modal"]').removeClass('active');
        $('.overlay').removeClass('active');
    });

    // Open complaint modal
    $('[data-modal="complaint"]').click(function () { 
        let elementId = $(this).closest('.user-comments-list').attr('data-comment-id');
        $('[data-complaint-open="modal"]').addClass('active');
        $('[data-complaint-open="modal"]').find('input[name="ID"]').val(elementId);
        $('.overlay').addClass('active');
    });

    // Open feedback modal 
    $('[data-modal="comment"]').click(function () { 
        $('[data-feedback-open="modal"]').addClass('active');
        $('.overlay').addClass('active');
    });

    // Close complaint modal
    $('[data-feedback-close="close"]').click(function () { 
        $('[data-feedback-open="modal"]').removeClass('active');
        $('.overlay').removeClass('active');
    });

    // Open comment answer
    $('[data-comment-button="open"]').click(function () {
        $(this).closest('[data-comment-parent="parent"]').find('[data-comment="open"]').addClass('open');
        $(this).closest('[data-comment-parent="parent"]').find('[data-comment-button="open"]').css('display', 'none');
        $(this).closest('[data-comment-parent="parent"]').find('[data-comment-button="close"]').css('display', 'block');
    });

    // Close comment answer
    $('[data-comment-button="close"]').click(function () { 
        $(this).closest('[data-comment-parent="parent"]').find('[data-comment="open"]').removeClass('open');
        $(this).closest('[data-comment-parent="parent"]').find('[data-comment-button="open"]').css('display', 'block');
        $(this).closest('[data-comment-parent="parent"]').find('[data-comment-button="close"]').css('display', 'none');
    });

    // On load comment button events
    if ($('[data-comment-parent="parent"]')) {
        $('[data-comment="open"]').each(function(index, el) {
            var fixedHeight = parseInt($(el).css('line-height')) * 4;
    
            if ($(el).height() <= fixedHeight) {
                $(el).closest('[data-comment-parent="parent"]').find('[data-comment-button="close"]').css('display', 'none');
            }
            
            if ($(el).height() < fixedHeight) {
                $(el).closest('[data-comment-parent="parent"]').find('[data-comment-button="parent"]').css('display', 'none');
            }
        }); 
    }

    // $('[data-sort-value]').click(function () { 
    //     sortCommentsEvent($(this))
    // });
});

// Хотел сделать сортировку на ajax, но пока время не хватает. Не удаляю потому что чуть позже буду доделовать 
// Sort comments
// function sortCommentsEvent(param) {
//     let iblock_id = param.closest('[data-sort-block="parent"]').attr('data-iblock-id');
//     let prod_id = param.closest('[data-sort-block="parent"]').attr('data-prod-id');
//     let row_count = param.closest('[data-sort-block="parent"]').attr('data-row-count');
//     let sort_type = param.attr('data-sort-value');
//     let commentBlock = param.closest('[data-comment-block="parent"]');
//     let currentUrl = $(commentBlock).attr('data-current-url');

//     console.log(currentUrl)

//     // Отправляем запрос на сервер через BX.ajax
//     BX.ajax({
//         method: 'POST',
//         url: "/ajax/ajax_sort.php",
//         data: {'IBLOCK_ID':iblock_id, 
//                 'PRODUCT_ID':prod_id, 
//                 'type':sort_type, 
//                 "ROW_PAGE_COUNT":row_count, 
//                 "currentUrl":currentUrl,
//             },
//         processData: false,
//         start: true,
//         onsuccess: function(response) {
//             // Обработка запроса
//         },
//         onfailure: function() {
//             alert('Ошибка сервера');
//         }
//     });
// }

// Function like button
function likeButtonEvent(param) {
    let commentBlock = param.closest('.user-comments-list');
    let isLike = param.attr('data-is-like');
    let elementId = $(commentBlock).attr('data-comment-id');
    let iblock_id = $(commentBlock).attr('data-iblock-id');
    let isData;

    if (param.hasClass('like')) {
        var currentValue = parseInt(param.find('.span__like-value').text());
        param.find('.span__like-value').text(currentValue - 1);
        param.removeClass('like');
    } else {
        var currentValue = parseInt(param.find('.span__like-value').text());
        param.find('.span__like-value').text(currentValue + 1);
        param.addClass('like');
    }
    
    if (param.hasClass('comment-rating__like')) {
        isData = {'LIKE':isLike, "IBLOCK_ID":iblock_id, 'ELEMENT_ID':elementId}
    } else if (param.hasClass('comment-rating__dislike')) {
        isData = {'DISLIKE':isLike, "IBLOCK_ID":iblock_id, 'ELEMENT_ID':elementId}
    }

    // Отправляем запрос на сервер через BX.ajax
    BX.ajax({
        method: 'POST',
        //dataType: 'json',
        url: "/ajax/ajax.php",
        data: isData,
        processData: false,
        start: true,
        onsuccess: function(response) {
            // Обработка запроса
        },
        onfailure: function() {
            alert('Ошибка сервера');
        }
    });
}


// Delete comment
function deleteComment(param) {
    let deleteElement = param.attr('data-modal');
    let commentBlock = param.closest('[data-comments-list="list"]');
    let elementId = $(commentBlock).attr('data-comment-id');
    let iblock_id = $(commentBlock).attr('data-iblock-id');

    BX.ajax({
        method: 'POST',
        url: "/ajax/ajax.php",
        data: {'delete':deleteElement, 'id':elementId, 'IBLOCK_ID':iblock_id},
        processData: false,
        start: true,
        onsuccess: function(response) {
            $(commentBlock).find('div').remove();
            var successMessage = '<div class="delete-comment-success">Комментария успешно добавлена</div>';
            $(commentBlock).append(successMessage);
        },
        onfailure: function() {
            $(commentBlock).find('div').remove();
            var successMessage = '<div class="delete-comment-error">Что-то пошло не так...</div>';
            $(commentBlock).append(successMessage);
        }
    });
}

  // Rating start function //
  const ratings = document.querySelectorAll('.rating');

  if (ratings.length > 0) {
    initRatings()
  }

  // Оснавная функция 
  function initRatings () {
    let ratingActive, ratingValue;
    // "Бегаем" по всем рейтингам на странице 
    for (let index = 0; index < ratings.length; index++) {
        const rating = ratings[index];
        initRating(rating);
    }
  }

  // Инициализируем конкретный рейтинг 
  function initRating(rating) {
    initRatingVars(rating)
   
    setRatingActiveWidth();

    if (rating.classList.contains('rating_set') ) {
        setRating(rating);
    }
  }

  // Инициализируем переменных
  function initRatingVars(rating) {
    ratingActive = rating.querySelector('.rating__active');
    ratingValue = rating.querySelector('.rating__value');
} 

  // Изменяием ширину активных звезд 
  function setRatingActiveWidth(index = ratingValue.innerHTML) {
     const ratinActiveWidth = index / 0.05;
     ratingActive.style.width = `${ratinActiveWidth}%`;
}

  // Возможность указать оценку
function setRating(rating) {
    const ratingItems = rating.querySelectorAll('.rating__item');

    // "Бегаем" по рейтингам 
    for (let index = 0; index < ratingItems.length; index++) {
        const ratingItem = ratingItems[index];
        ratingItem.addEventListener('mouseenter', function (e){
            // Обновление переменных
            initRating(rating);

            // Обновление активных звезд
            setRatingActiveWidth(ratingItem.value)
        });  

        ratingItem.addEventListener('mouseleave', function (e) {
            // Обновление активных звезд
            setRatingActiveWidth();
        }); 
        
        ratingItem.addEventListener('click', function (e) {
            // Обновление переменных
            initRatingVars(rating);

            if (rating.dataset.ajax) {
                // "Отправить" на сервер
                setRatingValue(ratingItem.value, rating)
            } else {
                // Отобразить указанную оценку
                ratingValue.innerHTML = index + 1;
                setRatingActiveWidth();
            }
        }); 
    }
}
// Rating end function //
