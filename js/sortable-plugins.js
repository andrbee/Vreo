
$(document).ready()
{
    $('.sortFiles').on('click', function () {
        var sorttType = $(this).data('sort');
        var butSort = $(this);
        if (sorttType === "size" || sorttType === "version") {
            if (butSort.hasClass('usort')) {
                $(".sortable tr").sort(function (a, b) { // сортируем
                        return +$(b).find('[data-sort=' + sorttType + ']').attr('data-value') - +$(a).find('[data-sort=' + sorttType + ']').attr('data-value');
                    })
                    .appendTo(".sortable");// возвращаем в контейнер
                $('.sortFiles').removeClass('usort');
            } else {
                $(".sortable tr").sort(function (a, b) { // сортируем
                        return +$(a).find('[data-sort=' + sorttType + ']').attr('data-value') - +$(b).find('[data-sort=' + sorttType + ']').attr('data-value');
                    })
                    .appendTo(".sortable");// возвращаем в контейнер
                butSort.addClass('usort');
            }
        }
        else {
            if (butSort.hasClass('usort')) {
                $(".sortable tr").sort(function (a, b) {
                    return $(b).find('[data-sort=' + sorttType + ']').attr('data-value').toLowerCase().localeCompare($(a).find('[data-sort=' + sorttType + ']').attr('data-value'));

                }).appendTo(".sortable");// возвращаем в контейнер
                $('.sortFiles').removeClass('usort');
            } else {
                $(".sortable tr").sort(function (a, b) {
                    return $(a).find('[data-sort=' + sorttType + ']').attr('data-value').toLowerCase().localeCompare($(b).find('[data-sort=' + sorttType + ']').attr('data-value'));

                }).appendTo(".sortable");// возвращаем в контейнер
                butSort.addClass('usort');
            }
        }
    });

}
