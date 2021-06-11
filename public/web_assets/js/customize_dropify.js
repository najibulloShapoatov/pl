
$(document).ready(function(){
    $('.dropify-my').dropify({
        messages: {
            'default': 'Переташите изображение или кликните',
            'replace': 'Переташите изображение или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат изображения недопустим (только {{value}})'
        }
    });
    $('.dropify-cover-course').dropify({
        messages: {
            'default': 'Загрузите оболочку для видеокурса',
            'replace': 'Переташите изображение или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат изображения недопустим (только {{value}})'
        }
    });
    $('.dropify-book').dropify({
        messages: {
            'default': 'Загрузите книгу (FB2,EPUB,PDF)',
            'replace': 'Переташите файл или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'fileFormat': 'Формат файла недопустим (только {{value}})'
        }
    });
    $('.dropify-audio-book').dropify({
        messages: {
            'default': 'Загрузите аудиокнигу (VAW,MP3)',
            'replace': 'Переташите файл или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'fileFormat': 'Формат файла недопустим (только {{value}})'
        }
    });

    $('.dropify-file-sharing').dropify({
        messages: {
            'default': 'Переташите файл или кликните',
            'replace': 'Переташите файл или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'fileFormat': 'Формат файла недопустим (только {{value}})'
        }
    });

    //elon
    $('.dropify-elon-img').dropify({
        messages: {
            'default': 'Переташите изображение или кликните',
            'replace': 'Переташите изображение или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат изображения/видео недопустим (только {{value}})'
        }
    });
    //elon
    $('.dropify-comm-img').dropify({
        messages: {
            'default': 'Переташите изображение или кликните',
            'replace': 'Переташите изображение или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат изображения недопустим (только {{value}})'
        }
    });
    $('.dropify-img-edit-test').dropify({
        messages: {
            'default': 'Переташите изображение или кликните',
            'replace': 'Переташите изображение или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат изображения недопустим (только {{value}})'
        }
    });




    $('.dropify-comm-video').dropify({
        messages: {
            'default': 'Переташите  видео или кликните',
            'replace': 'Переташите видео или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат видео недопустим (только {{value}})'
        }
    });


    $('.dropify-course-image').dropify({
        messages: {
            'default': 'Загрузите оболочку для видео',
            'replace': 'Переташите изображение или кликните что бы заменить',
            'remove':  'Удалить',
            'error':   'Что то пошло не так'
        },
        tpl: {
            clearButton:     '<span class="dropify-clear"><i class="ti-close"><i></span>'
        },
        error: {
            'fileSize': 'Размер файла перевышает ({{ value }}  максимум).',
            'minWidth': 'Ширина картинки менще ({{ value }}}пикс ).',
            'maxWidth': 'Ширина картинки больще ({{ value }}}пикс).',
            'minHeight': 'Высота картинки больще ({{ value }}}пикс).',
            'maxHeight': 'Высота картинки больще ({{ value }}}пикс).).',
            'imageFormat': 'Формат изображения недопустим (только {{value}})'
        }
    });


});
