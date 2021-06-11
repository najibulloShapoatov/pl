
(function ($) {
        "use strict";

    var language;

    function getLanguage() {
        (localStorage.getItem('language') == null) ? setLanguage('ru') : false;
        $.ajax({
            url:  '/public/web_assets/js/lang/' +  localStorage.getItem('language') + '.json',
            dataType: 'json',
            async: false,
            //dataType: 'json',
            success: function (lang) { language = lang } });
    }

    function setLanguage(lang) {
        localStorage.setItem('language', lang);
    }

    getLanguage();




    // profile: change password
    $(document).on("click","#changePassword",function(e) {
        e.preventDefault();
        var password = $('#old_pass').val();
        var confirm_password = $('#new_pass').val();

        var form_data = new FormData();
        form_data.append('old_password', password);
        form_data.append('new_password', confirm_password);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/profile/password',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            success: function( data ) {
                //console.log(data);
                if(data.error == 1){
                    $('#passwordResult').fadeIn(500).html('<p class="text-danger">'+data.errorMsg+'</p>');
                }
                else{
                    $('#passwordResult').fadeIn(500).html('<span class="text-success">Пароль успешно изменен!</span>');


                    // clear and focus
                    $('#old_pass').val('').focus();
                    $('#new_pass').val('');
                }
            },
            error: function( data ) {
                console.log(data);
            }
        });
    });

    // profile: change information
    $(document).on("click","#updateInfo",function(e) {
        e.preventDefault();

        var name = $('#name').val();
        var f_id = $('#facultId').val();
        var s_id = $('#specialId').val();
        //var image =  $('#image').prop('files')[0];

        var form_data = new FormData();
        form_data.append('name', name);
        form_data.append('facult_id', f_id);
        form_data.append('special_id', s_id);
        //form_data.append('image', image);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/profile/info',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            success: function( data ) {
                //console.log(data);

                $('#profileResult').fadeIn(500).html('<span class="text-success">Данные успешно изменены!</span>');


                // image
                // if(data.image != ''){
                //     var ava = document.getElementById('myavatar');
                //     ava.src = "/public/uploads/users/"+data.image;
                // }

            },
            error: function( data ) {
                console.log(data);
            }
        });
    });

    // select by year filter
    $(document).on("click", ".select-year", function(e){
        e.preventDefault();

        var page = 0;
        var year = $(this).attr('data-id');

        $('.yearBlk .button').removeClass('button-primary isActive').addClass('button-apple');
        $(this).addClass('button-primary isActive').removeClass('button-apple');

        //console.log(year);
        var form_data = new FormData();
        form_data.append('year', year);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/news/year',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            beforeSend: function(){
               // preloader
            },
            success: function( data ) {
                console.log(data);
                if (data.info.news_qnt == 0) {
                    $('.newsLM').addClass('d-none');
                }
                else {
                    page = parseInt(page) + 1;
                    $('#loadMore').attr('data-page', page);
                    $('#loadMore').html('<span>'+language.load_more+'</span>');
                    $('.resultNews').html(data.html);
                    $('.newsLM').removeClass('d-none');
                }

            },
            error: function( data ) {
                console.log(data);
            }
        });


    });

    // load more news
    $(document).on("click", "#loadMore", function(e){
        e.preventDefault();
        var page = $(this).attr('data-page');
        var year = $('.yearBlk .isActive').attr('data-id');


        var form_data = new FormData();

        form_data.append('year', year);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/news',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            beforeSend: function(){
                $('#loadMore').html('<span>'+language.loading+'</span>');
            },
            success: function( data ) {
                //console.log(data);

                if (data.info.news_qnt == 0) {
                    $('.newsLM').addClass('d-none');
                }
                else{
                    page = parseInt(page) + 1;
                    $('#loadMore').attr('data-page', page);
                    $('#loadMore').html('<span>'+language.load_more+'</span>');
                    $('.resultNews').append(data.html);
                }
            },
            error: function( data ) {
                console.log(data);
            }
        });

    });

    //Add new ticket message
    $(document).on("click", "#ticket_add_msg_btn", function(e){
        e.preventDefault();
        var $content = $('#ticket_add_msg_text').val();
        var ticket_id = $('#ticket_title').attr('data-id');

        if ($content) {
            //ajax
            var form_data = new FormData();
            form_data.append('content', $content);
            form_data.append('t_id', ticket_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/ticket/add-msg',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                success: function( data ) {
                    var dateDB = new Date(data.ticket_msg.created_at);
                    var date = getFormattedDate(dateDB);

                    $('#ticket_detail_list').append('<li class="user">\n' +
                        '                                        <div class="widget-chat your">\n' +
                        '                                            <div class="body">\n' +
                        '                                                <div class="content col-sm-10 ml-0">\n' +
                        '                                                    <p>'+data.ticket_msg.title+'\n' +
                        // '                                                        <span>{{ date(\'d.m.Y  h:i\', strtotime($item->created_at)) }}</span>\n' +
                        '                                                        <span>'+date+'</span>\n' +
                        '                                                    </p>\n' +
                        '                                                </div>\n' +
                        '                                            </div>\n' +
                        '                                        </div>\n' +
                        '                                    </li>');
                    $('#ticket_add_msg_text').val('');
                },
                error: function( data ) {
                    console.log(data);
                }
            });
            function getFormattedDate(date) {
                var day = ((date.getDate()) < 10) ?  '0'  + (date.getDate()).toString() : (date.getDate()).toString();
                var month = ((date.getMonth() + 1) < 10) ?  '0'  + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
                var year = date.getFullYear().toString();
                var hour = ((date.getHours()) < 10) ?  '0'  + (date.getHours()).toString() : (date.getHours()).toString();
                var mint = ((date.getMinutes()) < 10) ?  '0'  + (date.getMinutes()).toString() : (date.getMinutes()).toString();
                return  day + '.' + month+ '.' + year+'  '+hour  +':'+mint;
            }
        }
    });
    //Close ticket
    $(document).on("click", "#ticket_close_btn", function(e){
        e.preventDefault();
        var sts = 3;
        var ticket_id = $('#ticket_title').attr('data-id');

            //ajax
            var form_data = new FormData();
            form_data.append('sts', sts);
            form_data.append('t_id', ticket_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/ticket/close',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                success: function( data ) {
                    //console.log(data);
                    setTimeout("location.href = '/tickets'", 500);
                },
                error: function( data ) {
                    console.log(data);
                }
            });


    });

    //Add new Ticket
    $(document).on("click", "#add_new_ticket", function(e){
        e.preventDefault();
        var content = $('#new_ticket_content').val();
        var ticket = $('#new_ticket_title').val();

        if (content && ticket) {
            //ajax
            var form_data = new FormData();
            form_data.append('content', content);
            form_data.append('ticket', ticket);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/ticket/add-ticket',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                success: function( data ) {
                   //console.log(data);
                    var dateDB = new Date(data.ticket.created_at);
                    var date = getFormattedDate(dateDB);

                    $('#my_tickets_list').prepend('<li class="d-flex justify-content-between align-items-center">\n' +
                        '                                                    <div class="appeal-content d-flex">\n' +
                        '                                                            <div class="appeal-status green  mr-15"></div>\n' +
                        '                                                        <a href="/tickets/'+ data.ticket.id +'">\n'+ data.ticket.title +
                        '                                                        </a>\n' +
                        '                                                    </div>\n' +
                        '                                                    <div class="appeal-time">\n' +
                        '                                                        <span>'+date+'</span>\n' +
                        '                                                    </div>\n' +
                        '                                                </li>');
                    $('#new_ticket_content').val('');
                    $('#new_ticket_title').val('');
                },
                error: function( data ) {
                    console.log(data);
                }
            });
            function getFormattedDate(date) {
                var day = ((date.getDate()) < 10) ?  '0'  + (date.getDate()).toString() : (date.getDate()).toString();
                var month = ((date.getMonth() + 1) < 10) ?  '0'  + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
                var year = date.getFullYear().toString();
                return  day + '.' + month+ '.' + year;
            }
        }
    });

    //load more tickets
    $(document).on("click", "#loadMoreTicket", function(e){
        e.preventDefault();
        var page = $(this).attr('data-page');


        var form_data = new FormData();
        form_data.append('page', page);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/ticket-load',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            beforeSend: function(){
                $('#loadMoreTicket').html('<span>'+language.loading+'</span>');
            },
            success: function( data ) {
                console.log(data.info.ticket_qnt);

                if (data.info.ticket_qnt == 0) {
                    $('#loadMoreTicket').addClass('d-none');
                }
                else{
                    page = parseInt(page) + 1;
                    $('#loadMoreTicket').attr('data-page', page);
                    $('#loadMoreTicket').html('<span>'+language.load_more+'</span>');
                    $('#my_tickets_list').append(data.html);
                }
            },
            error: function( data ) {
                console.log(data);
            }
        });

    });

    //Add new Forum
    $(document).on("click", "#new_forum_add", function(e){
        e.preventDefault();
        var title = $('#new_forum_title').val();
        var category = $('#new_forum_category').val();
        var descr = $('#new_forum_descr').val();

        if (title && category && descr) {
            //ajax
            var form_data = new FormData();
            form_data.append('title', title);
            form_data.append('category', category);
            form_data.append('descr', descr);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/add-new-forum',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                beforeSend: function(){
                    $('#new_forum_add').prop('disabled', true).html(language.in_proc);
                },
                success: function( data ) {
                    //console.log(data);
                    if(data.err != 0){
                        alert(data.msg);
                    }else{
                        location.reload();
                    }
                    //location.href = '/forum'
                    // setTimeout("location.href = '/forum'", 100);




                },
                error: function( data ) {
                    console.log(data);
                }
            });
            function getFormattedDate(date) {
                var day = ((date.getDate()) < 10) ?  '0'  + (date.getDate()).toString() : (date.getDate()).toString();
                var month = ((date.getMonth() + 1) < 10) ?  '0'  + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
                var year = date.getFullYear().toString();
                return  day + '.' + month+ '.' + year;
            }
        }
    });

    //Add new Forum Answer
    $(document).on("click", "#add_forum_answer", function(e){
        e.preventDefault();
        var forum_ans_text = $('#text_forum_answer').val();
        var f_id = $('#forum_single').attr('data-id');
        let pr_id = $('#parent_id_answer').val();

        if (forum_ans_text) {
            //ajax
            var form_data = new FormData();
            form_data.append('forum_answer_text', forum_ans_text);
            form_data.append('forum_id', f_id);
            form_data.append('parent_id', pr_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/add-new-forum-answer',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                beforeSend: function(){
                    $('#add_forum_answer').prop('disabled', true).html(language.in_proc);
                },
                success: function( data ) {
                    //console.log(data);

                     location.reload()
                    // setTimeout('', 3000);




                },
                error: function( data ) {
                    console.log(data);
                }
            });
            function getFormattedDate(date) {
                var day = ((date.getDate()) < 10) ?  '0'  + (date.getDate()).toString() : (date.getDate()).toString();
                var month = ((date.getMonth() + 1) < 10) ?  '0'  + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
                var year = date.getFullYear().toString();
                return  day + '.' + month+ '.' + year;
            }
        }
    });

    //Add new Forum Like
    $(document).on("click", "#forum_like", function(e){
        e.preventDefault();

        var f_id = $('#forum_single').attr('data-id');

        if (f_id) {
            //ajax
            var form_data = new FormData();
            form_data.append('forum_id', f_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/add-new-forum-like',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                success: function( data ) {
                    //console.log(data);
                    $('#forum_like').html('<i class="far fa-thumbs-up pr-10"></i>\n  '+data.formData.countlike);
                    //location.reload()
                    // setTimeout('', 3000);

                },
                error: function( data ) {
                    console.log(data);
                }
            });

        }
    });

    //Add new Forum  Answer Like
    $(document).on("click", "#forum_answer_like", function(e){
        e.preventDefault();
        var f_a_id = $(this).attr('data-id');

        if (f_a_id){
            //ajax
            var form_data = new FormData();
            form_data.append('forum_answer_id', f_a_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/add-new-forum-answer-like',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                success: function( data ) {
                    //console.log(data);
                    $('.forum_answer_'+f_a_id).html('<i class="far fa-thumbs-up pr-10"></i>\n  '+data.formData.countlike);
                    //location.reload()
                    // setTimeout('', 3000);

                },
                error: function( data ) {
                    console.log(data);
                }
            });

        }
    });

    //Update Community info
    $(document).on("click", "#comm_edit", function(e){
        e.preventDefault();

        var comm_id = $('#comm_modal_body').attr('data-id');
        var community_title = $('#comm_single_name').val();
        var community_text = $('#comm_single_descr').val();


        if (comm_id && community_title ) {
            //ajax
            var form_data = new FormData();
            form_data.append('community_id', comm_id);
            form_data.append('community_title', community_title);
            form_data.append('community_text', community_text);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/update-community-info',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType : 'json',
                beforeSend: function(){
                    $('#comm_edit').prop('disabled', true).html(language.in_proc);
                },
                success: function( data ) {
                    //console.log(data);

                    location.reload()
                    // setTimeout('', 3000);




                },
                error: function( data ) {
                    console.log(data);
                }
            });

        }
    });

    //Community Image change
        $('#image_comm').change(function(){

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview_container').attr('src', e.target.result);

                if($('#upload_image_btn').hasClass('d-none')){
                    $('#upload_image_btn').removeClass('d-none');
                }
            }
            reader.readAsDataURL(this.files[0]);
        });
    //Community Image change update
    $('#upload_image_btn').on('click', function(e) {
        e.preventDefault();
        var file_data =  $('#image_comm').prop('files')[0];
        var comm_id = $('#comm_modal_body').attr('data-id');

        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('id', comm_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/update-community-img',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
                $('#upload_image_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function( data ) {
                //console.log(data);
                $('#upload_image_btn').prop('disabled', true).html('<i class="ti-check"></i> '+language.uploaded);
            },
            error: function( data ) {
                //console.log(data);
            }
        });    });


    //Remove community with posts
    $(document).on("click", "#remove_community", function(e) {
        e.preventDefault();

        var comm_id = $('#comm_modal_body').attr('data-id');

        var form_data = new FormData();
        form_data.append('id', comm_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/remove-community',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
                $('#remove_community').prop('disabled', true).html(language.in_proc);
            },
            success: function( data ) {
                console.log(data);
                setTimeout("location.href = '/community'", 1000);

            },
            error: function( data ) {
                //console.log(data);
            }
        });
    });

    // add new community image
    $('#new_comm_image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#image_preview_container').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    //add new community
    $(document).on("click", "#comm_add", function(e) {
        e.preventDefault();

        var title = $('#comm_new_name').val();
        var moderator_id = $('#moderator_community').val();
        var file_data = $('#new_comm_image').prop('files')[0];
        var text = $('#comm_new_descr').val();

        if (title) {
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('title', title);
            form_data.append('text', text);
            form_data.append('moderator_id', moderator_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            $.ajax({
                url: '/add-community',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('#comm_add').prop('disabled', true).html(language.in_proc);
                },
                success: function (data) {
                    //console.log(data);
                    location.reload();

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });

    //change subscribe community
    $(document).on("click", "#subcribe_community", function(e) {
        e.preventDefault();

        var comm_id = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', comm_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/subscribe-community',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
            },
            success: function( data ) {
                console.log(data);
                if(data.err != 0){
                    $('#modal-error-auth').modal('show');
                    $('#error-auth-content').html(data.msg);
                }
                else{
                    var c_p = parseInt($('#c_part_'+comm_id).attr('data-id'));
                    c_p += data.sts;
                    $('#c_part_'+comm_id).html(language.subscribed + c_p);
                    if(data.sts == 0){
                        $('.subs_comm_'+comm_id).prop('disabled', true);
                        $('.subs_comm_'+comm_id+' span').html(language.subscribe);
                    }else {
                        $('.subs_comm_'+comm_id).prop('disabled', true).addClass('subscribed-comm');
                        $('.subs_comm_'+comm_id+' span').html(language.you_subscribed);


                    }
                }

                //location.reload();
            },
            error: function( data ) {
                //console.log(data);
            }
        });
    });

    //change subscribe community
    $(document).on("click", "#subcribe_community_single", function(e) {
        e.preventDefault();

        var comm_id = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', comm_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/subscribe-community',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
            },
            success: function( data ) {
                //console.log(data);
                /*if(data.err != 0){
                    $('#modal-error-auth').modal('show');
                    $('#error-auth-content').html(data.msg);
                }
                else{
                    var c_p = parseInt($('#count_parts').attr('data-id'));
                    c_p += data.sts;

                    if(data.sts == 0){
                        $('#subcribe_community_single span').html('Подписатся');
                    }else {
                        $('#subcribe_community_single span').html('Вы подписаны');
                    }
                    $('#count_parts').html(c_p);
                }*/

                location.reload();
            },
            error: function( data ) {
                //console.log(data);
            }
        });
    });

    //change like community Post
    $(document).on("click", "#c_like", function(e) {
        e.preventDefault();

        var comm_post_id = $(this).attr('data-id');
        var sts = $('#count_like').attr('data-id');
        var form_data = new FormData();
        form_data.append('id', comm_post_id);
        form_data.append('sts', sts);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/like-community',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
            },
            success: function( data ) {
                //console.log(data);
                $('#post-'+comm_post_id+' .post-content .notification #c_like #count_like').html( data.countLike);
                $('#post-'+comm_post_id+' .post-content .notification #c_dislike #count_like').html(data.countDisLike);
                //location.reload();
            },
            error: function( data ) {
                //console.log(data);
            }
        });
    });
    //change like community Post
    $(document).on("click", "#c_dislike", function(e) {
        e.preventDefault();

        var comm_post_id = $(this).attr('data-id');
        var sts = $(' #c_dislike #count_like').attr('data-id');

        var form_data = new FormData();
        form_data.append('id', comm_post_id);
        form_data.append('sts', sts);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/like-community',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
            },
            success: function( data ) {
                console.log(data);
                $('#post-'+comm_post_id+' .post-content .notification #c_like #count_like').html( data.countLike);
                $('#post-'+comm_post_id+' .post-content .notification #c_dislike #count_like').html(data.countDisLike);
                //location.reload();
            },
            error: function( data ) {
                //console.log(data);
            }
        });
    });



    //change book image
    $('#book_image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#image_preview_container').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });


        //add new Elon
    $(document).on("click", "#add_elon_btn", function(e) {
        e.preventDefault();

        var cat_id = $('#elon_cat_id').val();
        var title = $('#new_elon_title').val();
        var price = $('#new_elon_price').val();
        var file_data = $('#input-file-elon-img').prop('files')[0];
        var text = $('#new_elon_descr').val();
        var phone = $('#new_elon_phone_no').val();


            var form_data = new FormData();
            form_data.append('category_id', cat_id);
            form_data.append('title', title);
            form_data.append('price', price);
            form_data.append('file', file_data);
            form_data.append('descr', text);
            form_data.append('phone_no', phone);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            $.ajax({
                url: '/add-elon',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('#add_elon_btn').prop('disabled', true).html(language.in_proc);
                },
                success: function (data) {
                    console.log(data);
                    //location.reload();

                    // error
                    if (data.error_code === 1) {
                        $('#add_elon_btn').prop('disabled', false).html(language.pod_ads);
                        $('.error').addClass('show').fadeIn(1000).html(data.msg);
                    }

                    // success
                    if (data.error_code === 0) {
                        setTimeout("location.href = '/my-elon'", 1000);
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });

    });

    //update  Elon
    $(document).on("click", "#update_elon_btn", function(e) {
        e.preventDefault();

        var e_id = $(this).attr('data-id');
        var cat_id = $('#edit_elon_cat').val();
        var title = $('#edit_elon_title').val();
        var price = $('#edit_elon_price').val();
        var file_data = $('#update-file-elon-img').prop('files')[0];
        var text = $('#edit_elon_descr').val();
        var phone = $('#edit_elon_phone').val();


        var form_data = new FormData();
        form_data.append('id', e_id);
        form_data.append('category_id', cat_id);
        form_data.append('title', title);
        form_data.append('price', price);
        form_data.append('file', file_data);
        form_data.append('descr', text);
        form_data.append('phone_no', phone);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/update-elon',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#update_elon_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                //console.log(data);
                //location.reload();

                // error
                if (data.error_code === 1) {
                    $('#update_elon_btn').prop('disabled', false).html(language.save);
                    $('.error').addClass('show').fadeIn(1000).html(data.msg);               }

                // success
                if (data.error_code === 0) {
                    setTimeout("location.href = '/my-elon'", 1000);
                }

            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    //Remove Elon
    $(document).on("click", "#remove_elon", function(e) {
        e.preventDefault();

        var e_id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', e_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/remove-elon',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){

            },
            success: function( data ) {
               // console.log(data);
                setTimeout("location.href = '/my-elon'", 1000);

            },
            error: function( data ) {
                //console.log(data);
            }
        });
    });

    //search Elon
    $(document).on("click", "#elon_seach_btn", function(e){
        e.preventDefault();

        var cat_id = $(this).attr('data-id');
        $('#elon_select_category').removeClass('active');

        //console.log(cat_id);
        var form_data = new FormData();
        form_data.append('id', cat_id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/load-elon',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            beforeSend: function(){
                // preloader
            },
            success: function( data ) {
                console.log(data);


            },
            error: function( data ) {
                console.log(data);
            }
        });


    });



    //Community post image&video
    $(document).on("click", "#post_add_image", function(e) {
        $('#upload_image_video').toggleClass('d-none');
    });

    //add new post Community
    $(document).on("click", "#add_new_post", function(e) {
        e.preventDefault();

        var options = {
            theme: 'snow'
        };
        var editor = new Quill('.quill', options);


        var com_id = $(this).attr('data-id');
        //var text = $('#new_post_text').val();
        var text = editor.root.innerHTML;
        var file_img = $('#input-file-community-img').prop('files')[0];
        var file_video = $('#input-file-community-video').prop('files')[0];



        var form_data = new FormData();
        form_data.append('id', com_id);
        form_data.append('text', text);
        form_data.append('file', file_video);
        form_data.append('image', file_img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/add-community-post',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                //console.log(data);
                setTimeout("location.reload()", 1000);


            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    //search  Forum
    $(document).on("click", "#search_forum_btn", function(e) {
        e.preventDefault();

        var text = $('#search_forum_text').val();




        var form_data = new FormData();
        form_data.append('text', text);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/search-forum',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                //console.log(data);
                //setTimeout("location.reload()", 1000);
                if(data.html) {
                    $('#forum_main_list').html(data.html);
                }
                else{
                    $('#forum_main_list').html('<p class="mt-30 text-center" style="font-size: 20px;"> '+language.po_req+'<span style="color: #ffa938">'+text+'</span> '+language.not_founded+'</p>\n');
                }


            },
            error: function (data) {
                console.log(data);
            }
        });

    });

    //edit forum modal show
    $(document).on("click", "#edit_modal_show", function(e) {
        e.preventDefault();
        var forum_id = $(this).attr('data-id');
        //console.log(forum_id);
        var form_data = new FormData();
        form_data.append('forum_id', forum_id);



        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/edit-forum',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                //console.log(data);
                $('#editModalForum').html(data.html);
                $('#editModalForum').modal('show');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    //save forum modal show
    $(document).on("click", "#save_edited_modal", function(e) {
        e.preventDefault();
        var forum_id = $(this).attr('data-id');
        var forum_title = $('#edit_forum_title').val();
        var forum_cat = $('#edit_forum_category').val();
        var forum_descr = $('#edit_forum_descr').val();
        //console.log(forum_id);
        if(forum_id && forum_title && forum_cat) {
            var form_data = new FormData();
            form_data.append('forum_id', forum_id);
            form_data.append('forum_title', forum_title);
            form_data.append('forum_cat', forum_cat);
            form_data.append('forum_descr', forum_descr);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            $.ajax({
                url: '/edit-forum-save',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('#save_edited_modal').html(language.in_proc);
                },
                success: function (data) {
                    //console.log(data);
                    location.reload();
                    /* $('#editModalForum').html(data.html);
                     $('#editModalForum').modal('show');*/
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });

    //delete forum modal show
    $(document).on("click", "#remove_forum", function(e) {
        e.preventDefault();
        var forum_id = $(this).attr('data-id');

        //console.log(forum_id);
        if(forum_id ) {
            var form_data = new FormData();
            form_data.append('forum_id', forum_id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            $.ajax({
                url: '/edit-forum-remove',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('#save_edited_modal').html(language.in_proc);
                },
                success: function (data) {
                    //console.log(data);
                    location.href ='/forum';
                    /* $('#editModalForum').html(data.html);
                     $('#editModalForum').modal('show');*/
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });



    //subscribe

    // subscribe
    $(document).on("click", "#footer-newsletter-submit", function(e){
        e.preventDefault();
        var email = $('#footer-newsletter-address').val();

        var form_data_subs = new FormData();
        form_data_subs.append('email', email);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/subscribe',
            data: form_data_subs,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType : 'json',
            success: function( data ) {
                //console.log(data);
                $('#subsResult').html(data.msg);


            },
            error: function( data ) {
                console.log(data);
            }
        });
    });
    $("#footer-newsletter-address").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#footer-newsletter-submit").click();
        }
    });

    // video course categpry btn
    $(document).on("click", "#videocourse_category_btn", function(e){
        e.preventDefault();
        var catID = $('#videocourse_category').val();
        location.href ='/course-cat/'+catID;
    });


    // video course categpry btn
    $(document).on("click", "#videcourse_play_btn", function(e) {
        e.preventDefault();
        var vidID = $(this).attr('data-id');
        var courseID = $('#videocourse').attr('data-id');
        /*console.log(courseID);
        console.log(vidID);
        $('#videcourse_player_modal').modal('show');*/

        if (vidID && courseID) {
            var form_data_subs = new FormData();
            form_data_subs.append('video_id', vidID);
            form_data_subs.append('course_id', courseID);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/video-play',
                data: form_data_subs,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    //$('#subsResult').html(data.msg);
                    if(data.image != null) {
                        $('#videcourse_player').attr('poster', data.image);
                    }else{
                        $('#videcourse_player').attr('poster', "/public/web_assets/images/default-v-course.jpg");
                    }
                    $('#videcourse_player').attr('src', data.video);
                    $('#videcourse_player_modal').modal('show');


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

    });

// video course category btn
    $(document).on("click", "#close_videocourse_player", function(e) {
        e.preventDefault();

        $('#videcourse_player')[0].pause();
        $('#videcourse_player_modal').modal('hide');
    });




    // delete video btn
    $(document).on("click", "#delete_video", function(e) {
        e.preventDefault();
        var vidID = $(this).attr('data-id');
        var courseID = $('#course_editing_page').attr('data-id');


        var form_data_subs = new FormData();
        form_data_subs.append('video_id', vidID);
        form_data_subs.append('course_id', courseID);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/video-delete',
            data: form_data_subs,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#video_edit_'+vidID).remove();
                var time_course = timeConvert(data.duration_course);
                $('#editing_course_duration').val(time_course);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    // video course save btn
    $(document).on("click", "#save_edited_course", function(e) {
        e.preventDefault();

        var categoryID = $('#videocourse_category').val();
        var courseID = $('#course_editing_page').attr('data-id');
        var title = $('#editing_course_title').val();
        var descr = $('#editing_course_descr').val();
        var img = $('#course_cover').prop('files')[0];



        var form_data_subs = new FormData();
        form_data_subs.append('category_id', categoryID);
        form_data_subs.append('course_id', courseID);
        form_data_subs.append('title', title);
        form_data_subs.append('descr', descr);
        form_data_subs.append('file', img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/save-edited-course',
            data: form_data_subs,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                location.href ='/my-course'

            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //add new video on course
    $(document).on("click", "#add_new_video_on_course", function(e) {
        e.preventDefault();

        var file_image, title;

        var course_id = $(this).attr('data-id');
             title = $('#video_title').val();
        var file_video = $('#input-file-corse_video').prop('files')[0];
        var dur_sec = $('#audio').attr('data-id');

         file_image = $('#input-file-course-img').prop('files')[0];

        if(!file_image) {
            var fileIm = $('#imgthumbnail').val();
            file_image = dataURLtoFile(fileIm, 'hello.png');
        }
        if(!title){
            title = file_video.name.slice(0, -4);//clean
        }

        //console.log(file_image);
        if (title && file_video) {
            var form_data = new FormData();
            form_data.append('course_id', course_id);
            form_data.append('title', title);
            form_data.append('file', file_video);
            form_data.append('image', file_image);
            form_data.append('dur_sec', dur_sec);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });

            $.ajax({
                url: '/add-course-video',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    //console.log(data);
                    var srcforImage = "/public/web_assets/images/default-v-course.jpg";
                    if(data.has_image){
                        srcforImage = data.image;
                    }
                    $('#course_editing_page .row .row').append('<div id="video_edit_'+data.video_id+'" class="col-md-2 col-sm-3 col-xs-12 col-lg-2 mb-10">\n' +
                        '                                <div class="v-course-item d-block">\n' +
                        '                                     <img class="mb-10" src="'+srcforImage+'" alt="">\n' +
                        '                                    <span data-id="'+data.video_id+'" id="delete_video" class="delete d-flex justify-content-center align-items-center">\n' +
                        '                                        <i class="zmdi zmdi-close zmdi-hc-fw"></i>\n' +
                        '                                    </span>\n' +
                        '                                </div>\n' +
                        '                            </div>');

                    $('#video_title').val('');

                    $(".dropify-clear").click();
                    $('#editing_course_duration').val(timeConvert(data.duration_course));


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });

    function timeConvert(t){
         var h = Math.floor(t  / 3600);
        var m = Math.floor((t / 60) % 60);
        var s = t % 60;
        return ((h<10)? '0'+h : h)+':'+((m<10)? '0'+m : m)+':'+((s<10)? '0'+s : s)
    }



    // video course save btn
    $(document).on("click", "#save_and_add_video", function(e) {
        e.preventDefault();
        var category = $('#videocourse_category').val();
        var title = $('#editing_course_title').val();
        var duration = $('#editing_course_duration').val();
        var descr = $('#editing_course_descr').val();
        var img = $('#course_cover').prop('files')[0];


        var form_data_subs = new FormData();
        form_data_subs.append('category_id', category);
        form_data_subs.append('title', title);
        form_data_subs.append('duration', duration);
        form_data_subs.append('descr', descr);
        form_data_subs.append('file', img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/add-course',
            data: form_data_subs,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                //location.href ='/my-course'

                $('#save_and_add_video').remove();
                $('#add_video_section').removeClass('d-none');
                $('#save_edited_course').removeClass('d-none');
                $('#course_editing_page').attr('data-id', data.id);
                $('#add_new_video_on_course').attr('data-id', data.id);

            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    // file share
    $(document).on("click", "#file_sharing_btn", function(e) {
        e.preventDefault();

        var file = $('#input-file-now-sharing').prop('files')[0];

        if (file) {
            var form_data = new FormData();
            form_data.append('file', file);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/file-sharing',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    $('#file_sharing_btn').html(language.loading);
                },
                success: function (data) {
                    //console.log(data);
                    $('#file_sharing_btn').remove();
                    $('#succes').removeClass('d-none');
                    $('#link_succes').attr('href', data.file).html( 'https://www.tspu-portal.tj'+data.file);
                    $('#inputClipboard').val('https://www.tspu-portal.tj'+data.file);
                    $('#end-date').html((data.endate.date).substr(0, 16));




                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

    });


    //change active news
    $(document).on("click", "#change_news_active", function(e) {
        e.preventDefault();
        var newsID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('news_id', newsID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-news',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data == 0){
                $('#sts_'+newsID). prop("checked", false);
                    $('#sts_text_'+newsID).html(language.no)
                }else{
                    $('#sts_'+newsID). prop("checked", true);
                    $('#sts_text_'+newsID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //delete news
    $(document).on("click", "#delete_item_news", function(e) {
        e.preventDefault();
        var newsID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('news_id', newsID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/delete-news',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+newsID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //delete news
    $(document).on("click", "#remove_news", function(e) {
        e.preventDefault();
        var newsID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('news_id', newsID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/delete-news',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                location.href='/news-manage'



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //update news news
    $(document).on("click", "#update_news_btn", function(e) {
        e.preventDefault();
        var newsID = $(this).attr('data-id');
        var title = $('#edit_news_title').val();
        var image = $('#update-file-news-img').prop('files')[0];
        var descr  = CKEDITOR.instances['my-editor'].getData();
        var anonce = $('#anonce_text').val();


        var form_data = new FormData();
        form_data.append('news_id', newsID);
        form_data.append('title', title);
        form_data.append('image', image);
        form_data.append('anonce', anonce);
        form_data.append('descr', descr);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/update-news',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#update_news_btn').html(language.in_proc);
            },
            success: function (data) {
                //console.log(data);
                setTimeout(location.href='/news-manage', 1000)



            },
            error: function (data) {
                console.log(data);
            }
        });



    });


    //create news
    $(document).on("click", "#create_news_btn", function(e) {
        e.preventDefault();
        var newsID = $(this).attr('data-id');
        var title = $('#edit_news_title').val();
        var image = $('#update-file-news-img').prop('files')[0];
        var descr = CKEDITOR.instances['my-editor'].getData();
        var anonce = $('#anonce_text').val();

        if(anonce.length > 254){
            anonce = anonce.substr(0, 250);
        }





        var form_data = new FormData();
        form_data.append('news_id', newsID);
        form_data.append('title', title);
        form_data.append('image', image);
        form_data.append('anonce', anonce);
        form_data.append('descr', descr);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/add-news',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#update_news_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                //console.log(data);
                setTimeout(location.href='/news-manage', 1000)



            },
            error: function (data) {
                console.log(data);
            }
        });




    });



    /*================================================*/

    //change active forum
    $(document).on("click", "#change_forum_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('forum_id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-forum',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data == 0){
                    $('#sts_'+ID). prop("checked", false);
                    $('#sts_text_'+ID).html(language.no)
                }else{
                    $('#sts_'+ID). prop("checked", true);
                    $('#sts_text_'+ID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //delete forum
    $(document).on("click", "#delete_item_forum", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('forum_id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/delete-forum',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //edit forum
    $(document).on("click", "#edit_cat_forum", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

         var Catcontent = $('#title_'+ID).text();


        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>\n' +
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="edit-cat-forum-label" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel-edit-cat-forum-label" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });

    //cancel edited category
    $(document).on("click", "#cancel-edit-cat-forum-label", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('forum_cat_id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/forum-cat-cancel',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edited category
    $(document).on("click", "#edit-cat-forum-label", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('forum_cat_id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/forum-cat-save',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove category
    $(document).on("click", "#delete_item_forumCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('forum_cat_id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/forum-cat-remove',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //create category
    $(document).on("click", "#add_f_cat_btn", function(e) {
        e.preventDefault();
        var title =$('#new_f_c_title').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/forum-cat-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#new_f_c_title').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#new_f_c_title').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

/*=============================================================================*/

    //change active commity
    $(document).on("click", "#change_comm_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('comm_id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-comm',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data == 0){
                    $('#sts_'+ID). prop("checked", false);
                    $('#sts_text_'+ID).html(language.no)
                }else{
                    $('#sts_'+ID). prop("checked", true);
                    $('#sts_text_'+ID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //remove community
    $(document).on("click", "#delete_item_comm", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-community',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });





/*=============================================================================*/

    //change active elon
    $(document).on("click", "#change_elon_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('elon_id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-elon',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data == 0){
                    $('#sts_'+ID). prop("checked", false);
                    $('#sts_text_'+ID).html(language.no)
                }else{
                    $('#sts_'+ID). prop("checked", true);
                    $('#sts_text_'+ID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //remove elon
    $(document).on("click", "#delete_item_elon", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-elon-adm',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

/*====================================================================================*/


    //remove faq
    $(document).on("click", "#delete_item_faq", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-faq',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edit faq
    $(document).on("click", "#save_edited_faq", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var cat_id = $('#edited_faq_cat').val();
        var title = $('#edited_faq_que').val();
        var descr = $('#edited_faq_ans').val();


        if(ID && cat_id && title && descr) {
            var form_data = new FormData();
            form_data.append('id', ID);
            form_data.append('cat_id', cat_id);
            form_data.append('title', title);
            form_data.append('descr', descr);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/edit-faq',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    location.href = '/faq-manage'

                },
                error: function (data) {
                    console.log(data);
                }
            });

        }

    });

    //create faq
    $(document).on("click", "#create_faq", function(e) {
        e.preventDefault();
        var cat_id = $('#edited_faq_cat').val();
        var title = $('#edited_faq_que').val();
        var descr = $('#edited_faq_ans').val();


        if( cat_id && title && descr) {
            var form_data = new FormData();
            form_data.append('cat_id', cat_id);
            form_data.append('title', title);
            form_data.append('descr', descr);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/create-faq',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    location.href = '/faq-manage'

                },
                error: function (data) {
                    console.log(data);
                }
            });

        }

    });


    //create category
    $(document).on("click", "#add_faq_cat_btn", function(e) {
        e.preventDefault();
        var title =$('#new_faq_c_title').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/faq-cat-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#new_faq_c_title').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#new_faq_c_title').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove faqCat
    $(document).on("click", "#delete_item_faqCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-faq-cat',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });



    //edit forum
    $(document).on("click", "#edit_cat_faq", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var Catcontent = $('#title_'+ID).text();

        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>\n' +
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="save_edited_faq" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel-edit-cat-faq-label" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });

    //cancel edited category
    $(document).on("click", "#cancel-edit-cat-faq-label", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/faq-cat-cancel',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edited category
    $(document).on("click", "#save_edited_faq", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/faq-cat-save',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    /*======================================================================================*/


    //remove course
    $(document).on("click", "#delete_item_course", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-course',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //change active course
    $(document).on("click", "#change_course_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-course',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data == 0){
                    $('#sts_'+ID). prop("checked", false);
                    $('#sts_text_'+ID).html(language.no)
                }else{
                    $('#sts_'+ID). prop("checked", true);
                    $('#sts_text_'+ID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });




    //remove CourseCat
    $(document).on("click", "#delete_item_course", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-course-cat',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });




    //edit forum
    $(document).on("click", "#edit_cat_course", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var Catcontent = $('#title_'+ID).text();

        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>\n' +
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="save_edited_cat_course" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel_edited_cat_course" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });



    //create category
    $(document).on("click", "#add_course_cat_btn", function(e) {
        e.preventDefault();
        var title =$('#new_course_c_title').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/course-cat-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#new_course_c_title').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#new_course_c_title').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });



        //cancel edited category
        $(document).on("click", "#cancel_edited_cat_course", function(e) {
            e.preventDefault();
            var ID = $(this).attr('data-id');


            var form_data = new FormData();
            form_data.append('id', ID);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/course-cat-cancel',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#adm_table_item_'+ID).html(data);



                },
                error: function (data) {
                    console.log(data);
                }
            });


        });

        //save edited category
        $(document).on("click", "#save_edited_cat_course", function(e) {
            e.preventDefault();
            var ID = $(this).attr('data-id');
            var title =$('#category_edit_'+ID).val();

            var form_data = new FormData();
            form_data.append('id', ID);
            form_data.append('title', title);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/course-cat-save',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#adm_table_item_'+ID).html(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });


        });






        //save edited category
        $(document).on("click", "#search_radel_item", function(e) {
            e.preventDefault();
            var ID = $(this).attr('data-id');
            var text = $(this).text();
            $("#razdel_text").html(text+" ");
            $('#search_cat_id').val(ID);
        });

    //save edited category
    $(document).on("click", "#save_edited_cat_course", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/course-cat-save',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //Search
    $(document).on("click", "#search_g_btn", function(e) {
        e.preventDefault();
        var title =$('#search_g_text').val();
        var cat_id =$('#search_cat_id').val();

        var form_data = new FormData();
        form_data.append('id', cat_id);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/search',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.content-body').html(data.html);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //Search
    $(document).on("click", "#search_tab_item", function(e) {
        e.preventDefault();

        var title =$('#search_value').val();
        var cat_id =$(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', cat_id);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/search',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.content-body').html(data.html);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

/*==================================================================================*/
    //remove About item in single page
    $(document).on("click", "#delete_items_about_single", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-about-item',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                // $('#adm_table_item_'+ID).remove();
                location.href ='/about-manage'
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove About item in single page
    $(document).on("click", "#delete_items_about", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-about-item',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                 $('#adm_table_item_'+ID).remove();
                //location.href ='/about-manage'
            },
            error: function (data) {
                console.log(data);
            }
        });


    });



    /*================================================================================*/
    //remove About item in single page
    $(document).on("click", "#save_edited_site_customize", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        const name = $('#edited_name_site').val(),
            adres = $('#edited_adres_site').val(),
            phone = $('#edited_phone_site').val(),
            email = $('#edited_email_site').val(),
            fl = $('#edited_f_l_site').val(),
            il = $('#edited_i_l_site').val(),
            yl = $('#edited_y_l_site').val();


        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('name', name);
        form_data.append('adres', adres);
        form_data.append('phone', phone);
        form_data.append('email', email);
        form_data.append('fl', fl);
        form_data.append('il', il);
        form_data.append('yl', yl);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/save-edited-site-customize',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                location.href ='/site-customize'
            },
            error: function (data) {
                console.log(data);
            }
        });


    });



/*====================Booker==============================================================================*/
    //create category
    $(document).on("click", "#add_category_book_btn", function(e) {
        e.preventDefault();
        var title =$('#add_category_book_text').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-cat-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#add_category_book_text').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#add_category_book_text').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //create pcategory
    $(document).on("click", "#add_pcategory_book_btn", function(e) {
        e.preventDefault();
        var title = $('#add_pcategory_book_text').val(),
            p_id = $('#book_cat').attr('data-id');

        var form_data = new FormData();
        form_data.append('parent_id', p_id);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-pcat-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#add_pcategory_book_text').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#add_pcategory_book_text').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

//change active bcategory
    $(document).on("click", "#change_bookC_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-bcat',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                if(data == 0){
                    $('#sts_'+ID). prop("checked", false);
                    $('#sts_text_'+ID).html(language.no)
                }else{
                    $('#sts_'+ID). prop("checked", true);
                    $('#sts_text_'+ID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove bCat
    $(document).on("click", "#delete_item_bCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-bcat',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //edit bcat
    $(document).on("click", "#edit_cat_bCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var Catcontent = $('#title_'+ID).text();

        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>' +
            '                               <td></td>'+
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="save_edited_bCat" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel_edited_bCat" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });



    //cancel edited category
    $(document).on("click", "#cancel_edited_bCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/bcat-cancel',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edited category
    $(document).on("click", "#save_edited_bCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/bcat-save',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

/*================================================================================*/
/*================================================================================*/
/*================================================================================*/

/*================================LAngs================================================*/
    //create category
    $(document).on("click", "#add_lang_book_btn", function(e) {
        e.preventDefault();
        var title =$('#add_lang_book_text').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-lang-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#add_lang_book_text').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#add_lang_book_text').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove bCat
    $(document).on("click", "#delete_item_bLang", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-blang',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //edit bcat
    $(document).on("click", "#edit_cat_bLang", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var Catcontent = $('#title_'+ID).text();

        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>' +
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="save_edited_bLang" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel_edited_bLang" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });



    //cancel edited category
    $(document).on("click", "#cancel_edited_bLang", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/cancel-blang',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edited category
    $(document).on("click", "#save_edited_bLang", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/save-blang',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });



/*==============================================================================================*/
/*==============================================================================================*/
/*==============================================================================================*/
/*==============================================================================================*/
    /*================================Genre================================================*/
    //create category
    $(document).on("click", "#add_genre_book_btn", function(e) {
        e.preventDefault();
        var title =$('#add_genre_book_text').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-genre-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#add_genre_book_text').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#add_genre_book_text').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove
    $(document).on("click", "#delete_item_bGenre", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-bgenre',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //edit bcat
    $(document).on("click", "#edit_cat_bGenre", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var Catcontent = $('#title_'+ID).text();

        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>' +
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="save_edited_bGenre" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel_edited_bGenre" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });



    //cancel edited category
    $(document).on("click", "#cancel_edited_bGenre", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/cancel-bgenre',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edited category
    $(document).on("click", "#save_edited_bGenre", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/save-bgenre',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

/*==========================================================================================*/
/*==========================================================================================*/
/*==========================================================================================*/

    //create author
    $(document).on("click", "#add_bAuthor_btn", function(e) {
        e.preventDefault();
        var name =$('#add_bAuthor_name').val();
        var descr =$('#add_bAuthor_descr').val();
        var img =$('#add_bAuthor_img').prop('files')[0];

        var form_data = new FormData();
        form_data.append('name', name);
        form_data.append('descr', descr);
        form_data.append('file', img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-author-add',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
                $('#add_bAuthor_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                console.log(data);
                if (data.sts == 1){
                    $('#error').removeClass('d-none');
                    $('#error > strong').html(data.error);
                    $('#add_bAuthor_btn').prop('disabled', false).html(language.save);
                }
                else{
                    location.href='/manage-book/authors'
                }

            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove
    $(document).on("click", "#delete_item_bAuthor", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-bautor',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //edit author
    $(document).on("click", "#edit_bAuthor_btn", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var name =$('#add_bAuthor_name').val();
        var descr =$('#add_bAuthor_descr').val();
        var img =$('#add_bAuthor_img').prop('files')[0];

        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('name', name);
        form_data.append('descr', descr);
        form_data.append('file', img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-author-edit',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
                $('#add_bAuthor_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                console.log(data);
                if (data.sts == 1){
                    $('#error').removeClass('d-none');
                    $('#error > strong').html(data.error);
                    $('#add_bAuthor_btn').prop('disabled', false).html(language.save);
                }
                else{
                    location.href='/manage-book/authors'
                }

            },
            error: function (data) {
                console.log(data);
            }
        });


    });



/*====================================================================================*/
/*====================================================================================*/
/*===================================License=================================================*/

    //create author
    $(document).on("click", "#add_bLicense_btn", function(e) {
        e.preventDefault();
        var name =$('#add_bLicense_title').val();
        var descr =$('#add_bLicense_descr').val();
        var img =$('#add_bLicense_img').prop('files')[0];

        console.log(img);
        var form_data = new FormData();
        form_data.append('title', name);
        form_data.append('descr', descr);
        form_data.append('file', img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-license-add',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
                $('#add_bAuthor_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                console.log(data);
                if (data.sts == 1){
                    $('#error').removeClass('d-none');
                    $('#error > strong').html(data.error);
                    $('#add_bAuthor_btn').prop('disabled', false).html(language.save);
                }
                else{
                    location.href='/manage-book/licenses'
                }

            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove
    $(document).on("click", "#delete_item_blicense", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-blicense',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //edit author
    $(document).on("click", "#edit_bLicense_btn", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var name =$('#add_bLicense_title').val();
        var descr =$('#add_bLicense_descr').val();
        var img =$('#add_bLicense_img').prop('files')[0];

        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('title', name);
        form_data.append('descr', descr);
        form_data.append('file', img);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/book-license-edit',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function(){
                $('#add_bLicense_btn').prop('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                console.log(data);
                if (data.sts == 1){
                    $('#error').removeClass('d-none');
                    $('#error > strong').html(data.error);
                    $('#add_bLicense_btn').prop('disabled', false).html(language.save);
                }
                else{
                    location.href='/manage-book/licenses'
                }

            },
            error: function (data) {
                console.log(data);
            }
        });


    });




/*===================================ADD Book =========================================*/
    var BookFiles = [];

    $(document).on('click', "#add_pole_pdf_file", function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        id++;
        $('#pdf_files').append('<form id="pdf_file_form_'+id+'"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">\n' +
            '                                            <input\n' +
            '                                                width="100%"\n' +
            '                                                id="input_pdf_file_'+id+'"\n' +
            '                                                class="pdf-file"\n' +
            '                                                type="file"\n' +
            '                                                data-max-file-size="512M"/>\n' +
            '                                            <button data-id="'+id+'" id="upload_pdf_file" class="button button-box button-google-drive">\n' +
            '                                                <i class="zmdi zmdi-cloud-upload {{--done--}}   zmdi-hc-fw"></i>\n' +
            '                                            </button>\n' +
            '                                        </form>');
        $(this).attr('data-id', id);
    });

    $(document).on('click', "#add_pole_epub_file", function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        id++;
        $('#epub_files').append('<form id="epub_file_form_'+id+'"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">\n' +
            '                                            <input\n' +
            '                                                width="100%"\n' +
            '                                                id="input_epub_file_'+id+'"\n' +
            '                                                class="pdf-file"\n' +
            '                                                type="file"\n' +
            '                                                data-max-file-size="512M"/>\n' +
            '                                            <button data-id="'+id+'" id="upload_epub_file" class="button button-box button-google-drive">\n' +
            '                                                <i class="zmdi zmdi-cloud-upload {{--done--}}   zmdi-hc-fw"></i>\n' +
            '                                            </button>\n' +
            '                                        </form>');
        $(this).attr('data-id', id);
    });

    $(document).on('click', "#add_pole_fb2_file", function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        id++;
        $('#fb2_files').append('<form id="fb2_file_form_'+id+'"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">\n' +
            '                                            <input\n' +
            '                                                width="100%"\n' +
            '                                                id="input_fb2_file_'+id+'"\n' +
            '                                                class="pdf-file"\n' +
            '                                                type="file"\n' +
            '                                                data-max-file-size="512M"/>\n' +
            '                                            <button data-id="'+id+'" id="upload_fb2_file" class="button button-box button-google-drive">\n' +
            '                                                <i class="zmdi zmdi-cloud-upload {{--done--}}   zmdi-hc-fw"></i>\n' +
            '                                            </button>\n' +
            '                                        </form>');
        $(this).attr('data-id', id);
    });

    $(document).on('click', "#add_pole_zip_file", function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        id++;
        $('#zip_files').append('<form id="zip_file_form_'+id+'"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">\n' +
            '                                            <input\n' +
            '                                                width="100%"\n' +
            '                                                id="input_zip_file_'+id+'"\n' +
            '                                                class="pdf-file"\n' +
            '                                                type="file"\n' +
            '                                                data-max-file-size="512M"/>\n' +
            '                                            <button data-id="'+id+'" id="upload_zip_file" class="button button-box button-google-drive">\n' +
            '                                                <i class="zmdi zmdi-cloud-upload {{--done--}}   zmdi-hc-fw"></i>\n' +
            '                                            </button>\n' +
            '                                        </form>');
        $(this).attr('data-id', id);
    });

    $(document).on('click', "#add_pole_word_file", function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        id++;
        $('#word_files').append('<form id="word_file_form_'+id+'"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">\n' +
            '                                            <input\n' +
            '                                                width="100%"\n' +
            '                                                id="input_word_file_'+id+'"\n' +
            '                                                class="pdf-file"\n' +
            '                                                type="file"\n' +
            '                                                data-max-file-size="512M"/>\n' +
            '                                            <button data-id="'+id+'" id="upload_word_file" class="button button-box button-google-drive">\n' +
            '                                                <i class="zmdi zmdi-cloud-upload {{--done--}}   zmdi-hc-fw"></i>\n' +
            '                                            </button>\n' +
            '                                        </form>');
        $(this).attr('data-id', id);
    });

    $(document).on('click', "#add_pole_audio_file", function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        id++;
        $('#audio_files').append('<form id="audio_audio_form_'+id+'"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">\n' +
            '                                            <input\n' +
            '                                                width="100%"\n' +
            '                                                id="input_audio_file_'+id+'"\n' +
            '                                                class="pdf-file"\n' +
            '                                                type="file"\n' +
            '                                                data-max-file-size="512M"/>\n' +
            '                                            <button data-id="'+id+'" id="upload_audio_file" class="button button-box button-google-drive">\n' +
            '                                                <i class="zmdi zmdi-cloud-upload {{--done--}}   zmdi-hc-fw"></i>\n' +
            '                                            </button>\n' +
            '                                        </form>');
        $(this).attr('data-id', id);
    });

/*+++++++++++++Upload Book Files ++++++++++++++++++++++++++++*/
    //upload pdf file in temp
    $(document).on("click", "#upload_pdf_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var fileUpload =$('#input_pdf_file_'+id).prop('files')[0];

        if(fileUpload) {
            let fileName = fileUpload.name;
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1));
        }

        if(fileUpload  && extension === "pdf") {

            var form_data = new FormData();
            form_data.append('file', fileUpload);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/book-upload-file-temp',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data.err == 1) {
                        alert(data.msg);
                    } else {
                        let file = {
                            'file_name': data.res.file_name,
                            'file_type': data.res.file_type,
                        };
                        BookFiles.push(file);
                        $('#pdf_file_form_' + id).html('<span style="width: 100%;">' + (fileUpload.name).substring(0, 30) + '</span>\n' +
                            '                                            <span disabled  class="button button-box off button-google-drive">\n' +
                            '                                                <i class="zmdi zmdi-cloud-done   zmdi-hc-fw"></i>\n' +
                            '                                            </span>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.choise_pdf_file)
        }
    });

    //upload epub file in temp
    $(document).on("click", "#upload_epub_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var fileUpload =$('#input_epub_file_'+id).prop('files')[0];

        if(fileUpload) {
            let fileName = fileUpload.name;
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1));
        }

        if(fileUpload  && (extension === "epub")) {

            var form_data = new FormData();
            form_data.append('file', fileUpload);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/book-upload-file-temp',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data.err == 1) {
                        alert(data.msg);
                    } else {
                        let file = {
                            'file_name': data.res.file_name,
                            'file_type': data.res.file_type,
                        };
                        BookFiles.push(file);
                        $('#epub_file_form_' + id).html('<span style="width: 100%;">' + (fileUpload.name).substring(0, 30) + '</span>\n' +
                            '                                            <span disabled  class="button button-box off button-google-drive">\n' +
                            '                                                <i class="zmdi zmdi-cloud-done   zmdi-hc-fw"></i>\n' +
                            '                                            </span>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.choise_epub_file)
        }
    });

    //upload fb2 file in temp
    $(document).on("click", "#upload_fb2_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var fileUpload =$('#input_fb2_file_'+id).prop('files')[0];

        if(fileUpload) {
            let fileName = fileUpload.name;
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1));
        }

        if(fileUpload  && extension === "fb2") {

            var form_data = new FormData();
            form_data.append('file', fileUpload);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/book-upload-file-temp',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data.err == 1) {
                        alert(data.msg);
                    } else {
                        let file = {
                            'file_name': data.res.file_name,
                            'file_type': data.res.file_type,
                        };
                        BookFiles.push(file);
                        $('#fb2_file_form_' + id).html('<span style="width: 100%;">' + (fileUpload.name).substring(0, 30) + '</span>\n' +
                            '                                            <span disabled  class="button button-box off button-google-drive">\n' +
                            '                                                <i class="zmdi zmdi-cloud-done   zmdi-hc-fw"></i>\n' +
                            '                                            </span>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.choise_fb2_file)
        }
    });


    //upload zip file in temp
    $(document).on("click", "#upload_zip_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var fileUpload =$('#input_zip_file_'+id).prop('files')[0];

        if(fileUpload) {
            let fileName = fileUpload.name;
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1));
        }

        if((fileUpload)&& (extension === "zip" || extension === "rar")) {

            var form_data = new FormData();
            form_data.append('file', fileUpload);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/book-upload-file-temp',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data.err == 1) {
                        alert(data.msg);
                    } else {
                        let file = {
                            'file_name': data.res.file_name,
                            'file_type': data.res.file_type,
                        };
                        BookFiles.push(file);
                        $('#zip_file_form_' + id).html('<span style="width: 100%;">' + (fileUpload.name).substring(0, 30) + '</span>\n' +
                            '                                            <span disabled  class="button button-box off button-google-drive">\n' +
                            '                                                <i class="zmdi zmdi-cloud-done   zmdi-hc-fw"></i>\n' +
                            '                                            </span>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.choise_zip_file)
        }
    });


    //upload word file in temp
    $(document).on("click", "#upload_word_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var fileUpload =$('#input_word_file_'+id).prop('files')[0];

        if(fileUpload) {
            let fileName = fileUpload.name;
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1));
        }

        if((fileUpload)&& (extension === "doc" || extension === "docx" || extension === "text" || extension === "txt")) {

            var form_data = new FormData();
            form_data.append('file', fileUpload);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/book-upload-file-temp',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data.err == 1) {
                        alert(data.msg);
                    } else {
                        let file = {
                            'file_name': data.res.file_name,
                            'file_type': data.res.file_type,
                        };
                        BookFiles.push(file);
                        $('#word_file_form_' + id).html('<span style="width: 100%;">' + (fileUpload.name).substring(0, 30) + '</span>\n' +
                            '                                            <span disabled  class="button button-box off button-google-drive">\n' +
                            '                                                <i class="zmdi zmdi-cloud-done   zmdi-hc-fw"></i>\n' +
                            '                                            </span>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.choise_word_file)
        }
    });


    //upload AUDIO file in temp
    $(document).on("click", "#upload_audio_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var fileUpload =$('#input_audio_file_'+id).prop('files')[0];

        if(fileUpload) {
            let fileName = fileUpload.name;
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1));
        }

        if((fileUpload)&& (extension === "mp3" || extension === "aac" || extension === "wav" || extension === "amr")) {

            var form_data = new FormData();
            form_data.append('file', fileUpload);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/book-upload-file-temp',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    //console.log(data);
                    if (data.err == 1) {
                        alert(data.msg);
                    } else {
                        let file = {
                            'file_name': data.res.file_name,
                            'file_type': data.res.file_type,
                        };
                        BookFiles.push(file);
                        $('#audio_file_form_' + id).html('<span style="width: 100%;">' + (fileUpload.name).substring(0, 30) + '</span>\n' +
                            '                                            <span disabled  class="button button-box off button-google-drive">\n' +
                            '                                                <i class="zmdi zmdi-cloud-done   zmdi-hc-fw"></i>\n' +
                            '                                            </span>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.choise_audio_file)
        }
    });


      //on change cat change section
    $(document).on("change", "#new_book_cat", function(e) {
        e.preventDefault();
        var id = $(this).val();



            var form_data = new FormData();
            form_data.append('id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/change-section-book',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    $('#new_book_section').html(data.html);
                },
                error: function (data) {
                    console.log(data);
                }
            });

    });

    $(document).on('change', '.book-lics', function (e) {
e.preventDefault();
 let licID = $(this).attr('data-id');

 $('#new_book_lic').val(licID);
} );


$(document).on('click', '#add_new_book', function (e) {
e.preventDefault();

let title = $('#new_book_title').val();
let img = $('#new_book_image').prop('files')[0];
let licID = $('#new_book_lic').val();
let authors = $('#new_book_authors').val();
let langID = $('#new_book_lang').val();
let year = $('#new_book_year').val();
let publish = $('#new_book_publish').val();
let catID = $('#new_book_cat').val();
let secID = $('#new_book_section').val();
let typeID = $('#new_book_type').val();
let isbn = $('#new_book_isbn').val();
let descr = $('#new_book_descr').val();
let pages = $('#new_book_pages').val();


    var form_data = new FormData();
    form_data.append('title', title);
    form_data.append('file', img);
    form_data.append('licID', licID);
    form_data.append('authors', authors);
    form_data.append('langID', langID);
    form_data.append('year', year);
    form_data.append('publish', publish);
    form_data.append('catID', catID);
    form_data.append('secID', secID);
    form_data.append('typeID', typeID);
    form_data.append('isbn', isbn);
    form_data.append('descr', descr);
    form_data.append('pages', pages);
    form_data.append('BookFile', JSON.stringify(BookFiles));

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
        }
    });
    $.ajax({
        url: '/create-new-book',
        data: form_data,
        type: 'POST',
        contentType: false,
        cache: false,
        processData: false,
        //dataType: 'json',
        beforeSend: function () {
            $('#add_new_book').attr('disabled', true).html(language.in_proc);
        },
        success: function (data) {
            console.log(data);
            if(data.err == 0) {
                location.href = '/library';
            }else{
                $('#add_new_book').attr('disabled', false).html(language.save);
                alert(data.msg);
            }

        },
        error: function (data) {
            console.log(data);
        }
    });

})


    //delete PDF File
    $(document).on("click", "#delete_pdf_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book-file',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $('#pdf_file_'+id).remove();
            },
            error: function (data) {
                console.log(data);
            }
        });

    });

   //delete Epub File
    $(document).on("click", "#delete_epub_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book-file',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $('#epub_file_'+id).remove();
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


   //delete FB2 File
    $(document).on("click", "#delete_fb2_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book-file',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $('#fb2_file_'+id).remove();
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


   //delete WORD File
    $(document).on("click", "#delete_word_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book-file',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $('#word_file_'+id).remove();
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


   //delete ZIP File
    $(document).on("click", "#delete_zip_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book-file',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $('#zip_file_'+id).remove();
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


   //delete AUDIO File
    $(document).on("click", "#delete_audio_file", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book-file',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $('#audio_file_'+id).remove();
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    $(document).on('click', '#edit_new_book', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');
        let title = $('#new_book_title').val();
        let img = $('#new_book_image').prop('files')[0];
        let licID = $('#new_book_lic').val();
        let authors = $('#new_book_authors').val();
        let langID = $('#new_book_lang').val();
        let year = $('#new_book_year').val();
        let publish = $('#new_book_publish').val();
        let catID = $('#new_book_cat').val();
        let secID = $('#new_book_section').val();
        let typeID = $('#new_book_type').val();
        let isbn = $('#new_book_isbn').val();
        let descr = $('#new_book_descr').val();
        let pages = $('#new_book_pages').val();


        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('title', title);
        form_data.append('file', img);
        form_data.append('licID', licID);
        form_data.append('authors', authors);
        form_data.append('langID', langID);
        form_data.append('year', year);
        form_data.append('publish', publish);
        form_data.append('catID', catID);
        form_data.append('secID', secID);
        form_data.append('typeID', typeID);
        form_data.append('isbn', isbn);
        form_data.append('descr', descr);
        form_data.append('pages', pages);
        form_data.append('BookFile', JSON.stringify(BookFiles));

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/update-book',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#add_new_book').attr('disabled', true).html(language.in_proc);
            },
            success: function (data) {
                console.log(data);
                if(data.err == 0) {
                    location.href = '/library';
                }else{
                    $('#add_new_book').attr('disabled', false).html(language.save);
                    alert(data.msg);
                }

            },
            error: function (data) {
                console.log(data);
            }
        });

    })


    //delete Book
    $(document).on("click", "#delete_book", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-book',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
               location.href = '/library'
            },
            error: function (data) {
                console.log(data);
            }
        });

    });




    //filter book
    $(document).on("click", "#filter_book_btn", function(e) {
        e.preventDefault();
        var cat =  $('#new_book_cat').val();
        var sub_cat =  $('#new_book_section').val();

        if($.isNumeric(cat)) {
            var subCat = 0;
            ($.isNumeric(sub_cat))? subCat = sub_cat: subCat;
            /*console.log(cat);
            console.log(subCat);*/
            if(subCat == 0) {
                location.href = '/book-category/' + cat;
            }
            else{
                location.href = '/book-sub-category/' + subCat;
            }
        }
    });


/*================Pool ===========================================*/
    $(document).on('change', '.pool-input', function (e) {
    e.preventDefault();
    let id = $(this).attr('data-id');

        $('#pool_selected').val(id);
    });
    $(document).on('change', '.poll-input_p', function (e) {
    e.preventDefault();
    let selected_id = $(this).attr('data-id'),
        pool_id =$(this).attr('id');

        $('#pool_selected_'+pool_id).val(selected_id);
    });

    $(document).on('click', '#polling', function (e) {
        e.preventDefault();
        let id = $('#pool_selected').val();

        if (id) {
            var form_data = new FormData();
            form_data.append('id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/pool',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('#polling').prop('disabled', true).addClass('polled').html(language.thanks);
                    $('.voting-radio').removeClass('show').addClass('hide');
                    $('.voting-loading').removeClass('hide');


                },
                success: function (data) {
                    //console.log(data);
                    // $('.voting-loading').addClass('hide');
                    setTimeout(poolResult, 1000, data);

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });


    $(document).on('click', '#pooling', function (e) {
        e.preventDefault();

        let  p_id = $(this).attr('data-id'),
            id = $('#pool_selected_'+p_id).val();

        if (id) {
            var form_data = new FormData();
            form_data.append('id', id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/pool',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('.btn_pooling_'+p_id).prop('disabled', true).addClass('polled').html(language.thanks);
                    $('.voting-radio_'+p_id).removeClass('show').addClass('hide');
                    $('.pool_loading_'+p_id).removeClass('hide');


                },
                success: function (data) {
                    console.log(data);
                    // $('.voting-loading').addClass('hide');
                    setTimeout(poolResultAll, 1000, data, p_id);

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });


    $(document).on('click', '#result_pool', function (e) {
        e.preventDefault();

       let id =$(this).attr('data-id');
        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/pool-get',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#polling').prop('disabled', true);
                $('.voting-radio').removeClass('show').addClass('hide');
                $('.voting-loading').removeClass('hide');

            },
            success: function (data) {
                //console.log(data);
                setTimeout(poolResult, 1000, data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    function poolResult(data) {
        $('.voting-loading').addClass('hide');
        $('#pool_res_percent').removeClass('hide').addClass('show').html(data.html);
    }

    function poolResultAll(data, ID) {
        // console.log(props[0], props[1]);
         console.log(data, ID);
        $('.pool_loading_'+ID).addClass('hide');
        $('#pool_res_percent_'+ID).removeClass('hide').addClass('show').html(data.html);
    }






    $(document).on('click', '#pool_add_btn', function (e) {
        e.preventDefault();
        let title = $('#pool_title').val();
        let answers =  $('input[name^=pool-ads]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        let start_date = $('#start_date_pool').val();
        let end_date = $('#end_date_pool').val();
        //console.log(date);



        let form_data = new FormData();
        form_data.append('title', title);
        form_data.append('start_date', start_date);
        form_data.append('end_date', end_date);
        form_data.append('answers', answers);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/pool-add',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#pool_add_btn').prop('disabled', true).html(language.in_proc);

            },
            success: function (data) {
                //console.log(data);
                if(data.err != 0){
                    $('#err').removeClass('d-none').fadeIn(500).html('<span>'+data.msg+'</span>');
                    $('#pool_add_btn').prop('disabled', false).html(language.save);

                }else {
                    location.href = '/admin-pool';
                }

            },
            error: function (data) {
                console.log(data);
            }
        });




    });



    $(document).on('click', '#pool_edit_btn', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let title = $('#pool_title').val();
        let answers =  $('input[name^=pool-ads]').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        let start_date =$('#start_date_pool').val();
        let end_date =$('#end_date_pool').val();

/*        console.log(start_date, end_date);*/

        let form_data = new FormData();
        form_data.append('id', id);
        form_data.append('title', title);
        form_data.append('answers', answers);
        form_data.append('start_date', start_date);
        form_data.append('end_date', end_date);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/pool-edit',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#pool_add_btn').prop('disabled', true).html(language.in_proc);

            },
            success: function (data) {
                if(data.err != 0){
                    $('#err').removeClass('d-none').fadeIn(500).html('<span>'+data.msg+'</span>');
                    $('#pool_add_btn').prop('disabled', false).html(language.save);

                }else {
                    location.href = '/admin-pool';
                }

            },
            error: function (data) {
                console.log(data);
            }
        });



    });


    $(document).on('click', '#pool_remove_btn', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');

        let form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/pool-remove',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {


            },
            success: function (data) {
                $('#adm_table_item_'+id).remove();

            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    //change active forum
    $(document).on("click", "#change_pool_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-pool',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);

                $('.input_pool_sts_text').each( function(i) {
                    $(this).html(language.no);
                });
                $('.input_pool_sts').each( function(i) {
                    $(this). prop("checked", false);
                });
                $('#sts_'+ID). prop("checked", true);
                $('#sts_text_'+ID).html(language.yes)



            },
            error: function (data) {
                console.log(data);
            }
        });


    });




    //edit forum
    $(document).on("click", "#edit_cat_elon", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var Catcontent = $('#title_'+ID).text();


        $('#adm_table_item_'+ID).html(' <td></td>\n' +
            '                                <td>\n' +
            '                                <input id="category_edit_'+ID+'" type="text" style="width: 100%;" value="'+Catcontent+'">\n' +
            '                                </td>\n' +
            '                                <td class="text-center adm-table-notification" width="170">\n' +
            '                                    <span data-id="'+ID+'" id="edit-cat-elon-label" class=" edit-item ti-check mr-10"></span>\n' +
            '                                    <span data-id="'+ID+'" id="cancel-edit-cat-elon-label" class=" remove-item  ti-close"></span>\n' +
            '                                </td>');

    });

    //cancel edited category Elon
    $(document).on("click", "#cancel-edit-cat-elon-label", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/elon-cat-cancel',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data.html);



            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //save edited category
    $(document).on("click", "#edit-cat-elon-label", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');
        var title =$('#category_edit_'+ID).val();

        var form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/elon-cat-save',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).html(data);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //remove category
    $(document).on("click", "#delete_item_elonCat", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/elon-cat-remove',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //create category
    $(document).on("click", "#add_e_cat_btn", function(e) {
        e.preventDefault();
        var title =$('#new_e_c_title').val();

        var form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/elon-cat-create',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(){
                $('#new_e_c_title').val('');
            },
            success: function (data) {
                //console.log(data);
                $('#new_e_c_title').val('');
                $('#f_c_t_b').prepend('<tr id="adm_table_item_'+data.id+'">'+data.html+'</tr>');
            },
            error: function (data) {
                console.log(data);
            }
        });


    });





    //file share settings
    $(document).on("click", "#save_file_sharing_settings_btn", function(e) {
        e.preventDefault();
        var title =$('#file_share_input_settings').val();

        if(title) {
            var form_data = new FormData();
            form_data.append('title', title);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/edit-file-share-settings',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (data) {
                    console.log(data);
                    $('#succes_file_sharing').fadeIn(500).removeClass('d-none')
                        .html(language.succesfuly_max_file_size_changed+' <span class="alert-succes-custom-text" >'+data.maxFileSize+' MB</span>.');

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

    });



    $(document).on('click', '#notice_view_btn', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        let form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/notice',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                 //console.log(data);
                 $('#notice-modal').modal('show');
                 $('#notice-modal h5').html(data.title);
                 $('#notice-modal p').html(data.descr);

                 if(data.sts){
                     let c_n = $('#count_not_readed_notice').val();
                     c_n--;
                     $('#count_not_readed_notice').val(c_n);
                     $('#notice_'+id).removeClass('notice-not-readed').addClass('notice-readed');
                     if(c_n > 0){
                         $('#not-readed-message').html( language.you_have+' '+c_n+' '+language.not_readed_notice);
                     }
                     if(c_n <= 0){
                         $('#notice_sts').addClass('d-none');
                         $('#not-readed-message').html(language.you_havnt_not_readed_notice);

                     }
                 }


            },
            error: function (data) {
                console.log(data);
            }
        });
    });





    $(document).on('click', '#mask-as-read', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        let form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/notice',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                /* console.log(data);
                 $('#notice-modal').modal('show');
                 $('#notice-modal h5').html(data.title);
                 $('#notice-modal p').html(data.descr);*/

                 if(data.sts){
                     let c_n = $('#count_not_readed_notice').val();
                     c_n--;
                     $('#count_not_readed_notice').val(c_n);
                     $('#notice_'+id).removeClass('notice-not-readed').addClass('notice-readed');
                     if(c_n > 0){
                         $('#not-readed-message').html( language.you_have+' '+c_n+' '+language.not_readed_notice);
                     }
                     if(c_n <= 0){
                         $('#notice_sts').addClass('d-none');
                         $('#not-readed-message').html(language.you_havnt_not_readed_notice);

                     }
                 }


            },
            error: function (data) {
                console.log(data);
            }
        });
    });





    $(document).on('click', '#view_notice', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');

        /*let form_data = new FormData();
        form_data.append('id', id);
*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/notice/'+id,
           // data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
            },
            success: function (data) {
                 console.log(data);

                 $('#notice-modal').modal('show');
                 $('#notice-modal h5').html(data.title);
                 $('#notice-modal p').html(data.descr);


            },
            error: function (data) {
                console.log(data);
            }
        });
    });




    //delete news
    $(document).on("click", "#delete_notice", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', ID);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/delete-notice',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    $('#notice-create').click(function (e) {
        e.preventDefault();
        $('#notice-create-modal').modal('show');
    });




    $('#send_notice').click( (e)=>{
        e.preventDefault();

        let title = $('#notice_title').val(),
            role = $('#notice_who').val(),
            descr = $('#notice_text').val();



        var form_data = new FormData();
        form_data.append('title', title);
        form_data.append('role', role);
        form_data.append('descr', descr);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/create-notice',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#notice_title').val('');
                $('#notice_who').val(0);
                $('#notice_text').val('');

                if(data.err != 0){
                    $('#error').removeClass('d-none').html(data.msg);
                }else {
                    $('#notice_table').prepend(data.html);
                    $('#notice-create-modal').modal('hide');
                }




            },
            error: function (data) {
                console.log(data);
            }
        });

    });




        $(document).on('click','#filter_notice', (e) => {
        e.preventDefault();
        let notice_role = $('#notice_role').val();
        var form_data = new FormData();
        form_data.append('notice_role', notice_role);



        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/filter-notice',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#notice_table').html(data);


            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    $(document).on("click", "#edit_notice", function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id');


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/edit-notice/'+id,
            // data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
             dataType: 'json',
            success: function (data) {
                //console.log(data);

                $('#notice_u_title').val(data.title);
                $('#notice_u_who').val(data.who_can_see);
                $('#notice_u_text').val(data.description);
                $('#update_notice').attr('data-id', data.id);

                $('#notice-edit-modal').modal('show');


            },
            error: function (data) {
                console.log(data);
            }
        });

    });





        $(document).on("click", "#update_notice", function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id');

        let title = $('#notice_u_title').val(),
            role = $('#notice_u_who').val(),
            descr = $('#notice_u_text').val();



        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('title', title);
        form_data.append('role', role);
        form_data.append('descr', descr);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/update-notice',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#notice_u_title').val('');
                $('#notice_u_who').val(0);
                $('#notice_u_text').val('');

                if(data.err != 0){
                    $('#error').removeClass('d-none').html(data.msg);
                }
                else{
                    console.log(data);
                    $('#adm_table_item_'+id).html(data.html);
                    $('#notice-edit-modal').modal('hide');
                }




            },
            error: function (data) {
                console.log(data);
            }
        });

    });

    $(document).on('click', '.news-item', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        location.href = '/news/'+id;

    });

    $(document).on('click', '.em-item', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        location.href = '/book/'+id;

    });


    $(document).on('click', '.vl-item', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        location.href = '/videocourse/'+id;

    });



    $(document).on('change', '.permission_forum', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        //console.log(id);

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/forum-permission-change/'+id,
            //data: form_data,
            type: 'GET',
           /* contentType: false,
            cache: false,
            processData: false,*/
            //dataType: 'json',
            success: function (data) {
                console.log(data);

            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    $(document).on('change', '.f-moderable', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/forum-moderable-change/'+id,
            //data: form_data,
            type: 'GET',
           /* contentType: false,
            cache: false,
            processData: false,*/
            //dataType: 'json',
            success: function (data) {
                console.log(data);

            },
            error: function (data) {
                console.log(data);
            }
        });

    });

    $(document).on('click', '#reply_to_answer', function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');

        let imgsrc = $('#answer_'+id+' .media img').attr('src');
        let text = ($('#answer_'+id+' .media .media-body input').val()).substr(0, 200);

       /* console.log(id);
        console.log(imgsrc);
        console.log(text);*/
       $('#parent_id_answer').val(id);
       $('#reply_head img').attr('src', imgsrc);
        $('#reply_head p').html(text);
       $('#reply_head').removeClass('d-none');
       location.href='#create_answer';


    });



    $(document).on('click', '#edit_item_comm', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        //console.log(id);
        //$('#community_edit_modal').modal('show');

        var form_data = new FormData();
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/community-moderator/' + id,
            //data: form_data,
            type: 'GET',
            /* contentType: false,
             cache: false,
             processData: false,*/
            //dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#edited_mod').html(data.html);
                $('#comm_edit_moderator').attr('data-id', id);
                $('#community_edit_modal').modal('show');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });



    $(document).on('click', '#comm_edit_moderator', function (e) {
        e.preventDefault();
        let com_moderarot = $('#edit_moderator_community').val();
        let id = $(this).attr('data-id');

        var form_data = new FormData();
        form_data.append('com_moderarot', com_moderarot);
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/community-moderator',
            data: form_data,
            type: 'POST',
             contentType: false,
             cache: false,
             processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#community_edit_modal').modal('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    $(document).on('change', '.userType', function (e) {
        e.preventDefault();
        $('#user_type').val($(this).attr('data-id'));
    });


    $(document).on('click', '#comment-room-toggle', function (e) {
        e.preventDefault();
        let id =$(this).attr('data-id');
        $('.comment_room_'+id).toggleClass('hide');
    });

    $(document).on('click', '#reply_comment_form', function (e) {
        e.preventDefault();
        let id =$(this).attr('data-id');
        $('#form-reply-'+id).removeClass('hide');
        $('#reply-comment-form-'+id).toggleClass('hide');
    });



    $(document).on('click', '#comment_post', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let msg = $('#commet-text-'+id).val();
        let c_id = $('#comm-id').val();
        $('#commet-text-'+id).val('')
        var form_data = new FormData();
        form_data.append('id', id);
        form_data.append('c_id', c_id);
        form_data.append('msg', msg);
        console.log(c_id);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/community-post-comment',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#chat-list-'+id).prepend(data);
            },
            error: function (data) {
                console.log(data);
            }
        });


    });




    $(document).on('click', '#add-reply-comment', function (e) {
        e.preventDefault();
        let parentID = $(this).attr('data-id');
        let postID = $('#post-id').val();
        let c_id = $('#comm-id').val();
        let msg = $('#comment-reply-'+parentID).val();
        $('#comment-reply-'+parentID).val('')
        var form_data = new FormData();
        form_data.append('c_id', c_id);
        form_data.append('postID', postID);
        form_data.append('parentID', parentID);
        form_data.append('msg', msg);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/community-post-comment-reply',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#coment-replies-'+parentID).prepend(data);
                $('#form-reply-'+parentID).toggleClass('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    $(document).on('change', '.c-moderable', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var cid = $('#comm-id').val();

        var form_data = new FormData();
        form_data.append('cid', cid);
        form_data.append('id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/community-moderableChange',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);

            },
            error: function (data) {
                console.log(data);
            }
        });

    });



    $(document).on('click', '#view_comment', function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/comment/'+id,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                console.log(data);
                $('#comment-modal .modal-content .modal-body p').html(data);
                $('#comment-modal').modal('show');

            },
            error: function (data) {
                console.log(data);
            }
        });

    });


    //change active news
    $(document).on("click", "#change_comment_active", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        /*var form_data = new FormData();
        form_data.append('news_id', ID);*/


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/change-active-comment/'+ID,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(data == 0){
                    $('#sts_'+ID). prop("checked", false);
                    $('#sts_text_'+ID).html(language.no)
                }else{
                    $('#sts_'+ID). prop("checked", true);
                    $('#sts_text_'+ID).html(language.yes)
                }


            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //delete forum
    $(document).on("click", "#delete_comment", function(e) {
        e.preventDefault();
        var ID = $(this).attr('data-id');


        /*var form_data = new FormData();
        form_data.append('forum_id', ID);*/


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/delete-comment/'+ID,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#adm_table_item_'+ID).remove();



            },
            error: function (data) {
                console.log(data);
            }
        });


    });



    //delete forum
    $(document).on("click", "#save_name_user", function(e) {
        e.preventDefault();
        const ID = $(this).attr('data-id');
        const name =$('.name_user').val();



        const form_data = new FormData();
        form_data.append('id', ID);
        form_data.append('name', name);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/edit-name-user',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#status').addClass('alert-success').removeClass('d-none').html(language.succes);
                $('.info h5').html(data);


            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    $(document).on('click', '#show-add-fed-to-modal',()=>{ $('#ad_new_fed_to_modal').modal('show');});

    $(document).on('click', '#add-new-fed-to-btn', function (e) {
        e.preventDefault();
        let f_id = $('#faculty-fed-to').val();
        let place = $('#place-fed-to').val();
        let name = $('#name-fed-to').val();
        let email = $('#email-fed-to').val();
        if(validateEmail(email)) {
            const form_data = new FormData();
            form_data.append('f_id', f_id);
            form_data.append('place', place);
            form_data.append('name', name);
            form_data.append('email', email);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/create-new-fed-to',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#table-admin-body').prepend(data.html);
                    $('#ad_new_fed_to_modal').modal('hide');
                    $('#faculty-fed-to').val('');
                    $('#place-fed-to').val('');
                    $('#name-fed-to').val('');
                    $('#email-fed-to').val('');


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }else{
            alert(language.enter_correct_email);
        }

    });


    $(document).on('click', '#edit-fed-to-btn', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let f_id = $('#faculty-fed-to-edit').val();
        let place = $('#place-fed-to-edit').val();
        let name = $('#name-fed-to-edit').val();
        let email = $('#email-fed-to-edit').val();
        if(validateEmail(email)) {
            const form_data = new FormData();
            form_data.append('id', id);
            form_data.append('f_id', f_id);
            form_data.append('place', place);
            form_data.append('name', name);
            form_data.append('email', email);


            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/update-fed-to',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    //$('#table-admin-body').prepend(data.html);
                    $('#edit_fed_to_modal').modal('hide');
                    $('#adm_table_item_'+id).html(data.html);



                },
                error: function (data) {
                    console.log(data);
                }
            });
        }else{
            alert(language.enter_correct_email);
        }

    });



  $(document).on('click', '#edit_item_fed_to', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');

           /* const form_data = new FormData();
            form_data.append('id', id);*/

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/edit-fed-to/'+id,
                //data: form_data,
                type: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#edit-fed-form').html(data.html);
                    $('#edit_fed_to_modal').modal('show');



                },
                error: function (data) {
                    console.log(data);
                }
            });

    });


  $(document).on('click', '#delete_item_fed_to', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');

           /* const form_data = new FormData();
            form_data.append('id', id);*/

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/remove-fed-to/'+id,
                //data: form_data,
                type: 'GET',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#adm_table_item_'+id).remove();

                },
                error: function (data) {
                    console.log(data);
                }
            });

    });


    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if( !emailReg.test( email ) ) {
            return false;
        }
        else {
            return true;
        }
    }



    $(document).on('change', '#facult_select', function () {
        let id = $(this).val();
        //console.log(id);
        /* const form_data = new FormData();
           form_data.append('id', id);*/

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/get-by-fac-to-whom/'+id,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#to_whom').append(data.html);

            },
            error: function (data) {
                console.log(data);
            }
        });
    });







    $(document).on('click', '#update_admin_mail', function (e) {
        e.preventDefault();
        let propVal = $('.admin_mail_text').val();

        if (validateEmail(propVal)) {

            const form_data = new FormData();
            form_data.append('propVal', propVal);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/update-mail-admin',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#succes_form').fadeIn(500).removeClass('d-none');

                    setTimeout(removeSucces,3000);


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.enter_correct_email)
        }
    });

    function removeSucces(){
    $('#succes_form').fadeOut(500).addClass('d-none');
}

    $(document).on('click', '#update_booker_mail', function (e) {
        e.preventDefault();
        let propVal = $('.booker_mail_text').val();

        if (validateEmail(propVal)) {
            const form_data = new FormData();
            form_data.append('propVal', propVal);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/update-mail-booker',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function (data) {
                    //console.log(data);
                    $('#succes_form').fadeIn(500).removeClass('d-none');
                    setTimeout(removeSucces,3000);


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            alert(language.enter_correct_email)
        }

    });


    $(document).on('click', '#view_user_data', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
         //


        /*const form_data = new FormData();
        form_data.append('propVal', propVal);*/

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/view-user-info-modal/'+id,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#view_user_info_form').html(data.html);
                $('#view_info_user_modal').modal('show');

            },
            error: function (data) {
                console.log(data);
            }
        });
    });




    $(document).on('click', '#add_new_fac_show_modal', function (e) {
        e.preventDefault();
       $('#add_new_fac_modal').modal('show');
    });


    $(document).on('click', '#add_new_facult', function (e) {
        e.preventDefault();
        let title = $('#facult_name').val();


        const form_data = new FormData();
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/create-facult',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#facs_tbody').prepend(data);
                $('#facult_name').val('');
                $('#add_new_fac_modal').modal('hide');

            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('click', '#delete_item_fac', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-facult/'+id,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                $('#adm_table_item_'+id).remove();

            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('click', '#edit_item_fac', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let title = $('#title-fac-'+id).val();
        $('#facult_name_edit').val(title);
        $('#update_facult').attr('data-id', id);
        $('#edit_fac_modal').modal('show');
    });



    $(document).on('click', '#update_facult', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let title = $('#facult_name_edit').val();


        const form_data = new FormData();
        form_data.append('id', id);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/update-facult',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+id).html(data);
                $('#edit_fac_modal').modal('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });



//cafedra

    $(document).on('click', '#add_new_caf_show_modal', function (e) {
        e.preventDefault();
       $('#add_new_caf_modal').modal('show');
    });


    $(document).on('click', '#add_new_cafedra', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let title = $('#cafedra_name').val();


        const form_data = new FormData();
        form_data.append('title', title);
        form_data.append('fid', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/create-cafedra',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#facs_tbody').prepend(data);
                $('#cafedra_name').val('');
                $('#add_new_caf_modal').modal('hide');

            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('click', '#delete_item_caf', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');

        console.log(id);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/remove-cafedra/'+id,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                $('#adm_table_item_'+id).remove();

            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('click', '#edit_item_caf', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let title = $('#title-caf-'+id).val();
        $('#cafedra_name_edit').val(title);
        $('#update_cafedra').attr('data-id', id);
        $('#edit_caf_modal').modal('show');
    });



    $(document).on('click', '#update_cafedra', function (e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let title = $('#cafedra_name_edit').val();


        const form_data = new FormData();
        form_data.append('id', id);
        form_data.append('title', title);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/update-cafedra',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#adm_table_item_'+id).html(data);
                $('#edit_caf_modal').modal('hide');
            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('click', '.h_example', function(e){

        let id = $(this).attr('data-id');
        $('#hasExample').val(id);
        if($('#hasExample').val() == 0){
            $('#example_test').addClass('d-none');
            $('#without_example').removeClass('d-none');

        }else{
            $('#without_example').addClass('d-none');
            $('#example_test').removeClass('d-none');
        }
    });

    $(document).on('change', '#faculty_id', function () {
        let id = $(this).val();
        //console.log(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: '/fac-cafedra/'+id,
            //data: form_data,
            type: 'GET',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.cafs').html(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });



$(document).on('click', '#set_lang', function(){
    let loc = $(this).attr('data-id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
        }
    });
    $.ajax({
        url: '/change-lang/'+loc,
        //data: form_data,
        type: 'GET',
        contentType: false,
        cache: false,
        processData: false,
        //dataType: 'json',
        success: function (data) {
            console.log(data);
            setLanguage(loc);
            //location.reload();

        },
        error: function (data) {
            console.log(data);
        }
    });
});





})(jQuery);

function dataURLtoFile(dataurl, filename) {

    let arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);

    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }

    return new File([u8arr], filename, {type:mime});
}

