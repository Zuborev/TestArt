'use strict';

function renderOption(regionType, item) {
    regionType.append(`<option value="${item}">${item}</option>`);
}

function getTerritoryList(parent, child, child_ch) {

    const parentName = parent.val();
    const type = child.attr('id');
    const lastSelect = $('select:last');
    const grandparentName = (parent.nextAll('select').length === 1) ? $('select:first').val() : null;

    $.post('/address/get', {'parentName': parentName, 'grandparentName': grandparentName, 'type': type}, data => {
        child.children().not(':first').remove();
        if (lastSelect.children().length > 1) {
            lastSelect.children().not(':first').remove();
        }
        let list = JSON.parse(data);
        $.each(list, (key, value) => {
            renderOption(child, value.ter_name);
        });
        $('select').trigger("chosen:updated");
        (child.children().length === 1) ? child_ch.hide() : child_ch.show();
    });
}

function changeSelect(select1, select2, select2_ch) {
    select1.on('change', () => {
        if (select1.nextAll('select').length === 2) {
            $('#village_chosen').hide();
        }
        (select1.val() === '') ? select2_ch.hide() : getTerritoryList(select1, select2, select2_ch);
    });
}

function renderMessage(inputItem, typeMessage, textMessage) {
    inputItem.before(`<p id="message" class="${typeMessage}">${textMessage}</p>`);
}

function checkInput(fieldItem, regItem) {
    if ((fieldItem.val() === '') && !(fieldItem.is($('select:last')))) {
        renderMessage(fieldItem, 'alert-danger', 'Поле пустое');
        return false;
    } else if (regItem != null && !regItem.test(fieldItem.val())) {
        renderMessage(fieldItem, 'alert-danger', 'Введены некорректные данные');
        return false;
    } else if ((fieldItem.val() === '') && (fieldItem.is($('select:last'))) && (fieldItem.children().length > 1)) {
        renderMessage(fieldItem, 'alert-danger', 'Поле пустое');
        return false;
    } else return true;
}

function checkData(array) {
    let count = 0;
    for (let i=0; i<array.length; i++) {
        if (!checkInput(array[i].field, array[i].regExp)) {
            count++;
            break;
        }
    }
    return count;
}

$(function () {

    $('select').chosen();
    const region = $('#region');
    const city = $('#city');
    const village = $('#village');
    const region_ch = $('#region_chosen');
    const city_ch = $('#city_chosen');
    const village_ch = $('#village_chosen');

    changeSelect(region, city, city_ch);
    changeSelect(city, village, village_ch);

    $("form").on("submit", function (e) {

        e.preventDefault();

        const $form = $(this);
        const login = $form.find('input#login');
        const email = $form.find('input#email');
        const regFIO = /([а-яА-яa-zA-z]+\s)+([а-яА-яa-zA-z]+)/ig;
        const regEmail = /[a-z0-9!$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|edu|gov|mil|ru|biz|info|mobi|name|aero|asia|jobs|museum)\b/i;

        const inputArray = [{field:login, regExp:regFIO},
                            {field:email, regExp:regEmail},
                            {field:region, regExp:null},
                            {field:city, regExp:null},
                            {field:village, regExp:null}];

        $form.find('#message').remove();

        if (checkData(inputArray) > 0) {return false;}

        $('button').prop('disabled', true);

        $.post(
            '/user/add',
            $form.serialize(),
            data => {
                let info = JSON.parse(data);
                console.log(info);
                if ( info.status === 'found') {
                    $(location).attr('href', info.id);
                } else {
                    renderMessage($form, info.class, info.message);
                    $('form').trigger('reset');
                    $('select').trigger("chosen:updated");
                    $('button').prop('disabled', false);
                    setTimeout($(location).attr('href', 'all'), 3000);
                }
            }
        )
            .fail(function () {
            renderMessage($form, 'alert-danger', 'Что-то пошло не так');
        })
            .always(function() {
            $('button').prop('disabled', false);
        });
    });
});
































