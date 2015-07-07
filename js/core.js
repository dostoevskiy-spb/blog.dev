/**
 * Created by Mota on 02.04.14.
 */
$(document).ready(function () {
    if ($('.login')[0])
        $('.login').fancybox();

    if ($('.fancy')[0]) {
        $('.fancy').each(function (i, o) {
            var rel = $(o).attr('rel');
            $('[rel=' + rel + ']').fancybox({
                helpers: {
                    title: {
                        type: 'outside'
                    },
                    thumbs: {
                        width: 50,
                        height: 50
                    },
                    overlay: {
                        css: {
                            //'background' : 'red'
                        }
                    }
                }
            });
        });
    }
});