(function ($) {
    "use strict";

    //timer
$(document).ready(function() {
     var minut = parseInt($('#test_timer').html());
     //var minut = 1;
    var second = 0;
    var str_s, str_m;
    // Function to update counters on all elements with class counter
    var doUpdate = function() {
        $('#test_timer').each(function() {

            if(second >0){
                second--;
            }
            if( second == 0 && minut > 0){
                minut--;
                second = 59;
            }
            if(minut == 0 && second == 0){
                console.log('Stop');
                getResults();
                clearInterval(timer);
            }
            (second < 10) ? str_s = "0" + second : str_s = second;
            (minut < 10) ? str_m = "0" + minut : str_m = minut;
            $(this).html(str_m + ' : ' + str_s);

        });
    };
     var timer = setInterval(doUpdate, 1000);
});


    // on change radio
    $(document).on("change", ".radioAnswer", function(e) {
        e.preventDefault();

        var qID = $(this).attr('data-id');
        var aID = $(this).val();

        $('#answ_id_' + qID).val(aID);

    });

    // submit
    $(document).on("click", "#btn_result_test", function(e) {
        e.preventDefault();

        getResults();

    });

    function getResults() {
        var test_id =$('input[name=test]').val();

        var questions = $('input[name^=question]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var answers = $('input[name^=answer]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        //console.log(questions);
        //console.log(answers);

        var form_data = new FormData();
        form_data.append('test_id', test_id);
        form_data.append('questions', questions);
        form_data.append('answers', answers);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/test-result',
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
                $('#exampleModal5 .modal-dialog  .modal-content .modal-body span').html(data.point.toFixed(2));
                $('#exampleModal5 .modal-dialog  .modal-content .modal-body .proxodnoy-ball').html('*проходной балл '+data.checkpoint);

                $('#exampleModal5').modal('show');

            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    //close modal result
    $(document).on("click", "#btn_close_res_test", function(e) {
        e.preventDefault();
        location.href = '/testing';
    });

    //test image
    $(document).on("click", ".add-test-image", function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id')
        $('#upload_image_test'+id).toggleClass('d-none');
    });

    //upload image in folder temp
    $(document).on("change", ".dropify-img-preview", function(e) {
        e.preventDefault();
        var file  = $(this).prop('files')[0];

        var inputID = $(this).attr('data-id');
        var form_data = new FormData();

        form_data.append('file', file);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/upload-image-temp',
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
                $('#quest_img_'+inputID).val(data);

            },
            error: function (data) {
                console.log(data);
            }
        });


    });

    //add test pole
    var variantID = 1;
    $(document).on("click", "#add_test_p", function(e) {
        var t = $(this).attr('data-id');
             variantID++;
        $('#answers'+t).append('<label class="test-radio">\n' +
            '                                <input   data-id="'+t+'" id="'+variantID+'"  class="radio radioANS" type="radio" name="answer'+t+'">\n' +
            '                                <i class="icon"></i>\n' +
            '                                <input id="v'+variantID+'"  name="add_answer'+t+'[]" type="text" class="form-control" placeholder="">\n' +
            '                            </label>');
    });

    //add question item
    $(document).on("click", "#add_question_item", function(e) {
        e.preventDefault();
        var t = $("#new_ques_id").val();
        variantID++;
        t++;
        $("#new_ques_id").val(t);

        $('#question_items .col-sm-10').append('<div id="add_ques_item" class="add-question-item mb-15">\n' +
            '                    <div class="row mbn-15">\n' +
            '                    <h5>Введите вопрос</h5>\n' +
            '                    <div class="col-12 pl-40 mb-15">\n' +
            '                        <input id="ques_title'+t+'" name="add_question[]" type="text" class="form-control" placeholder="Введите вопрос">\n' +
            '                        <span data-id="'+t+'" class="add-test-image">\n' +
            '                            <i class="fa fa-picture-o" aria-hidden="true"></i>\n' +
            '                        </span>\n' +
            '                    </div>\n' +
            '                        <div id="upload_image_test'+t+'" class=" d-none col-12">\n' +
            '                            <div class="col-12 elon_img mb-15   p-20">\n' +
            '                                <form class="" action="" enctype="multipart/form-data">\n' +
            '                                    <div class="col-4">\n' +
            '                                        <input type="hidden" id="quest_img_'+t+'" value="">' +
            '                                        <input\n' +
            '                                        data-id="'+t+'"' +
            '                                            type="file"\n' +
            '                                            class="dropify-img-preview"\n' +
            '                                            id="ques_img'+t+'"\n' +
            '                                            name="add_question_img[]"\n' +
            '                                            data-allowed-file-extensions="jpg jpeg png gif "\n' +
            '                                            data-max-file-size="5M"/>\n' +
            '                                    </div>\n' +
            '                                </form>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    <h5 class="mt-20">Введите варианты ответов и веберите правильный ответ:</h5>\n' +
            '                    <div class=" col-12 mb-20">\n' +
            '                        <div id="answers'+t+'" class="test-checkbox-radio-group">' +
            '                       <input type="hidden" name="ans_checked" id="answ_id_'+t+'" value="">'+
            '                            <label class="test-radio">\n' +
            '                                <input   data-id="'+t+'" id="'+variantID+'"   class="radio radioANS" type="radio" name="answer'+t+'">\n' +
            '                                <i class="icon"></i>\n' +
            '                                <input id="v'+variantID+'" name="add_answer'+t+'[]" type="text" class="form-control" placeholder="">\n' +
            '                            </label>\n' +
            '                        </div>\n' +
            '                        <button data-id="'+t+'" id="add_test_p" class="button mt-10 std button-primary button-outline fl-right"> Добавить поле</button>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '                </div>');

    });


    // on change radio
    $(document).on("change", ".radioANS", function(e) {
        e.preventDefault();
        var qID = $(this).attr('data-id');
        var ID = $(this).attr('id');

        var ans = $('#v' + ID).val();

        $('#answ_id_' + qID).val(ans);

    });


    //save TEST in db
    $(document).on("click", "#save_new_test", function(e) {
        e.preventDefault();
        let fID = $('#faculty_id').val();
        let cID = $('#cafedra_id').val();
        let lang = $('#lang').val();
        let subj = $('#subject').val();
        let hasExample = $('#hasExample').val();
        let file =  $('#file_test').prop('files')[0];
        var checkpoint = $('#checkpoint').val();
        var test_timer = $('#test_timer').val();

        var obj=[];
        $( ".add-question-item" ).each(function( i ) {
            var  tmp ={
                'title': $('#ques_title'+(i+1)).val(),
                'image': $('#quest_img_'+(i+1)).val(),
                'answers': $('input[name^=add_answer'+(i+1)+']').map(function(idx, elem) {
                                return $(elem).val();
                                }).get(),
                'is_true': $('#answ_id_'+(i+1)).val(),
            };
            obj.push(tmp);
        });

        var form_data = new FormData();
        form_data.append('fID', fID);
        form_data.append('cID', cID);
        form_data.append('lang', lang);
        form_data.append('subj', subj);
        form_data.append('hasExample', hasExample);
        form_data.append('file', file);
        form_data.append('checkpoint', checkpoint);
        form_data.append('test_timer', test_timer);
       form_data.append('questions', JSON.stringify(obj));

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/add-test',
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
                setTimeout("location.href = '/my-tests'", 1000);


            },
            error: function (data) {
                console.log(data);
            }
        });



    });

    $(document).on('click', '#save_without', function (e) {
        e.preventDefault();
        let fID = $('#faculty_id').val();
        let cID = $('#cafedra_id').val();
        let lang = $('#lang').val();
        let subj = $('#subject').val();
        let hasExample = $('#hasExample').val();
        let file =  $('#file_test').prop('files')[0];




        var form_data = new FormData();
        form_data.append('fID', fID);
        form_data.append('cID', cID);
        form_data.append('lang', lang);
        form_data.append('subj', subj);
        form_data.append('hasExample', hasExample);
        form_data.append('file', file);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/add-test',
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
                setTimeout("location.href = '/my-tests'", 1000);


            },
            error: function (data) {
                console.log(data);
            }
        });



    });





    //Filter
    $(document).on("click", "#filter_test", function(e) {
        e.preventDefault();

        var f_id  = $("#faculty_id").val();
        var c_id  = $("#cafedra_id").val();

        /*console.log(f_id);
        console.log(c_id);
        console.log(s_id);*/

        var form_data = new FormData();
        form_data.append('f_id', f_id);
        form_data.append('c_id', c_id);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/filter-test',
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
                $('table.table.tes').html(data.html);


            },
            error: function (data) {
                console.log(data);
            }
        });


    });


    //Edit Test
    $(document).on("click", "#edit_test_btn", function(e) {
        e.preventDefault();

        var qID  = $(this).attr('data-id');

        var qTitle = $('#q_i_'+qID+' h5 span').html();
        var qIMG = $('#q_i_'+qID+' img').attr('src');

        var ans = $('#answ_id_'+qID).val();

        var answers = $('input[name^=answers'+qID+']').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        var answersIDs = $('input[name^=answers'+qID+']').map(function(idx, elem) {
            return $(elem).attr('data-id');
        }).get();


        //console.log(ans);

        var variants =[];
        $.each(answers, function(i,  elem) {
            if(ans == elem) {
                variants += '<label id="rad_'+ answersIDs[i]+'"  class="test-radio d-flex">\n' +
                    '                                <input data-id="' + qID + '" id="' + i + '" class="radio radioANS" type="radio" checked name="answer' + qID + '">\n' +
                    '                                <i class="icon"></i>\n' +
                    '                                <input q-id="' + qID + '" data-id="'+answersIDs[i]+'" id="v' + i + '"  name="add_answer' + qID + '[]" type="text" class="form-control test_control" placeholder="" value="' + elem + '">\n' +
                    '                                <span data-id="'+answersIDs[i]+'" id="delete_pole_edited_ques" class="d-flex align-items-center ml-10"><i class="ti-close"></i></span>\n' +
                    '                            </label>\n'
            }
            else{
                variants += '<label id="rad_'+ answersIDs[i]+'"  class="test-radio d-flex">\n' +
                    '                                <input data-id="' + qID + '" id="' + i + '" class="radio radioANS" type="radio" name="answer' + qID + '">\n' +
                    '                                <i class="icon"></i>\n' +
                    '                                <input q-id="' + qID + '" data-id="'+answersIDs[i]+'"  id="v' + i + '"  name="add_answer' + qID + '[]" type="text" class="form-control test_control" placeholder="" value="' + elem + '">\n' +
                    '                                <span data-id="'+answersIDs[i]+'" id="delete_pole_edited_ques"  class="d-flex align-items-center ml-10"><i class="ti-close"></i></span>\n' +
                    '                            </label>\n'
            }

             });


        $('#q_i_'+qID).html(' <div  id="add_ques_item" class="add-question-item mb-15">\n' +
            '                    <div class="row mbn-15">\n' +
            '                    <h5>Введите вопрос</h5>\n' +
            '                    <div class="col-12 pl-40 mb-15">\n' +
            '                        <input  id="ques_title_'+qID+'"  type="text" class="form-control" placeholder="Введите вопрос" value="'+ qTitle +'">\n' +
            '                        <span data-id="1" class="add-test-image">\n' +
            '                            <i class="fa fa-picture-o" aria-hidden="true"></i>\n' +
            '                        </span>\n' +
            '                    </div>\n' +
            '                        <div id="upload_image_test1" class=" col-12">\n' +
            '                            <div class="col-12 elon_img mb-15   p-20">\n' +
            '                                <form class="" action="" enctype="multipart/form-data">\n' +
            '                                    <div class="col-4 d-flex align-items-center">\n' +
            '                                        <img id="img_prew_'+qIMG+'" src="'+qIMG+'" alt="no-image">\n' +
            '                                        <input\n' +
            '                                            data-id="'+qIMG+'"\n' +
            '                                            type="file"\n' +
            '                                            class="dropify-img-edit-test ml-20"\n' +
            '                                            id="ques_img'+qID+'"\n  ' +
            '                                            data-default-file="'+qIMG+'"'+
            '                                            name="add_question_img'+qID+'"\n' +
            '                                            data-allowed-file-extensions="jpg jpeg png gif "\n' +
            '                                            data-max-file-size="5M"/>\n' +
            '                                    </div>\n' +
            '                                </form>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    <h5 class="mt-20">Введите варианты ответов и веберите правильный ответ:</h5>\n' +
            '                    <div class=" col-12 mb-20">\n' +
            '                        <div  id="answers'+qID+'" class="test-checkbox-radio-group">\n' +
            '                            <input type="hidden" name="ans_checked" id="answ_id_'+qID+'" value="'+ans+'">\n' +
                                        variants +
            '                        </div>\n' +
            '                           <div class="d-table" style="width: 100%">\n' +
            '                            <input type="hidden"  id="variant_'+qID+'" value="'+answers.length+'">\n' +
            '                             <button v-id="'+answers.length+'"  data-id="'+qID+'" id="add_edit_test_p" class="button mt-10 std button-primary button-outline fl-right"> Добавить поле</button>\n' +
            '                           </div>\n' +
            '                           <div class="d-table" style="width: 100%">\n' +
            '                               <button data-id="'+qID+'" id="save_edit_test_btn" class="button mt-20  button-primary fl-right"> Сохранить</button>\n' +
            '                               <span data-id="'+qID+'" id="remove_question" class="mt-30 pt-5 delete-community mr-25 fl-right">Удалить вопрос</span>\n' +
            '                           </div>\n' +
            '                   </div>\n' +

            '                </div>\n' +
            '                </div>');
    });

    //changing image_preview
    $(document).on("change", ".dropify-img-edit-test", function(e) {
        e.preventDefault();
         var qID = $(this).attr('data-id');
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#img_prew_'+qID).attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);

    });

    //change is true value onchanged input with radio checked
    $(document).on("change", "input.form-control.test_control", function(e) {
        e.preventDefault();
        var varID =$(this).attr('data-id');
        var qID =$(this).attr('q-id');
        var varVAL = $(this).val();

   if($('#rad_'+varID+'  input.radio.radioANS').is(':checked')) {
       $('#answ_id_'+qID).val(varVAL);
   }
        //console.log(varVAL);
    });


    //add edit pole in edit page
    $(document).on("click", "#add_edit_test_p", function(e) {
        e.preventDefault();
        var qID =$(this).attr('data-id');
        var vID =$(this).attr('v-id');
        //var vID =$('input#variant_'+qID).val();

        $('#answers'+qID).append('<label id="rad_0"  class="test-radio d-flex">\n' +
            '                                <input data-id="' + qID + '" id="' +vID + '" class="radio radioANS" type="radio" name="answer' + qID + '">\n' +
            '                                <i class="icon"></i>\n' +
            '                                <input q-id="' + qID + '" data-id="0"  id="v' + vID + '"  name="add_answer' + qID + '[]" type="text" class="form-control test_control" placeholder="" value="">\n' +
            '                                <span data-id="0" id="delete_pole_edited_ques" class="d-flex align-items-center ml-10" ><i class="ti-close"></i></span>\n' +
            '                            </label>\n');
        let v = parseInt(vID);
        v++;
        $(this).attr('v-id', v);
    });

    //save question
    $(document).on("click", "#save_edit_test_btn", function(e) {
        e.preventDefault();
        var qID =$(this).attr('data-id');

        var title = $('#ques_title_'+qID).val();
        var image = $('#ques_img'+qID).prop('files')[0];


        var is_truetext = $('#answ_id_'+qID).val();
        var testID = $('#question_items').attr('data-id');
        /*if(image){
            image=image;
        }else{
            image=null;
        }*/


        var answers = $('input[name^=add_answer' + qID +']').map(function(idx, elem) {
            return $(elem).val();
        }).get();
        var answersIds = $('input[name^=add_answer' + qID +']').map(function(idx, elem) {
            return $(elem).attr('data-id');
        }).get();


        var answs=[];
        $.each(answers, function(i,  elem) {
            var  tmp ={
                'id': answersIds[i],
                'title': elem,
            };
            answs.push(tmp);
        });
       /* console.log(qID);
        console.log(title);
        console.log(image);
        console.log(is_truetext);
        console.log(answs);*/



        var form_data = new FormData();
        form_data.append('test_id', testID);
        form_data.append('question_id', qID);
        form_data.append('title', title);
        form_data.append('file', image);
        form_data.append('is_true_text', is_truetext);
        form_data.append('answers', JSON.stringify(answs));

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/save-que-test',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#save_edit_test_btn').html('В процесее ...');
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


    //delete pole
    $(document).on("click", "#delete_pole_edited_ques", function(e) {
        e.preventDefault();
        var pID =$(this).attr('data-id');

        if(pID !=0) {
            var form_data = new FormData();
            form_data.append('ans_id', pID);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/remove-que-var',
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
                    $('#rad_'+pID).remove();
                    //setTimeout("location.reload()", 1000);


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            $('#rad_'+pID).remove();
        }

    });

    //delete question
    $(document).on("click", "#remove_question", function(e) {
        e.preventDefault();
        var qID =$(this).attr('data-id');
        var tID =$('#question_items').attr('data-id');

        if(qID !=0) {
            var form_data = new FormData();
            form_data.append('que_id', qID);
            form_data.append('test_id', tID);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                }
            });
            $.ajax({
                url: '/remove-que',
                data: form_data,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                //dataType: 'json',
                beforeSend: function () {
                    $('#remove_question').html('В процессе ...');
                },
                success: function (data) {
                    //console.log(data);
                    //$('#rad_'+pID).remove();
                    setTimeout("location.reload()", 1000);


                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        else{
            $('#rad_'+pID).remove();
        }

    });


    //add question id edit
    $(document).on("click", "#add_question_item_edited", function(e) {
        e.preventDefault();
        var t = $("#new_ques_id").val();

        variantID++;
        t++;
        $("#new_ques_id").val(t);

        $('#question_items .col-sm-10').append('<div id="add_ques_item" class="add-question-item mt-30 mb-15">\n' +
            '                    <div class="row mbn-15">\n' +
            '                    <h5>Введите вопрос</h5>\n' +
            '                    <div class="col-12 pl-40 mb-15">\n' +
            '                        <input id="ques_title_new_edited" name="add_question[]" type="text" class="form-control" placeholder="Введите вопрос">\n' +
            '                        <span data-id="'+t+'" class="add-test-image">\n' +
            '                            <i class="fa fa-picture-o" aria-hidden="true"></i>\n' +
            '                        </span>\n' +
            '                    </div>\n' +
            '                        <div id="upload_image_test'+t+'" class=" d-none col-12">\n' +
            '                            <div class="col-12 elon_img mb-15   p-20">\n' +
            '                                <form class="" action="" enctype="multipart/form-data">\n' +
            '                                    <div class="col-4">\n' +
            '                                        <input type="hidden" id="quest_img_'+t+'" value="">' +
            '                                        <input\n' +
            '                                            type="file"\n' +
            '                                            class="dropify-img-preview"\n' +
            '                                            id="ques_img_new_edited"\n' +
            '                                            name="add_question_img[]"\n' +
            '                                            data-allowed-file-extensions="jpg jpeg png gif "\n' +
            '                                            data-max-file-size="5M"/>\n' +
            '                                    </div>\n' +
            '                                </form>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    <h5 class="mt-20">Введите варианты ответов и веберите правильный ответ:</h5>\n' +
            '                    <div class=" col-12 mb-20">\n' +
            '                        <div id="answers'+t+'" class="test-checkbox-radio-group">' +
            '                       <input type="hidden" name="ans_checked" id="answ_id_'+t+'" value="">'+
            '                            <label id="rad_'+variantID+'" class="test-radio">\n' +
            '                                <input   data-id="'+t+'" id="'+variantID+'"   class="radio radioANS" type="radio" name="answer'+t+'">\n' +
            '                                <i class="icon"></i>\n' +
            '                                <input q-id="'+t+'" data-id="'+variantID+'" id="v'+variantID+'" name="add_answer'+t+'[]" type="text" class="form-control test_control" placeholder="">\n' +
            '                            </label>\n' +
            '                        </div>\n' +
            '                        <div class="d-table" style="width: 100%">\n' +
            '                           <button data-id="'+t+'" id="add_test_p_edited_new" class="button mt-10 std button-primary button-outline fl-right"> Добавить поле</button>\n' +
            '                        </div>\n' +
            '                        <button data-id="'+t+'" id="save_edit_test_btn_new" class="button mt-20  button-primary fl-right"> Сохранить</button>\n' +

            '                    </div>\n' +
            '                </div>\n' +
            '                </div>'
        );

    });

    //add pole in new qeustion in editing page
    $(document).on("click", "#add_test_p_edited_new", function(e) {
        e.preventDefault();
        var t = $(this).attr('data-id');
        variantID++;
        $('#answers'+t).append('<label id="rad_'+variantID+'" id="" class="test-radio">\n' +
            '                                <input   data-id="'+t+'" id="'+variantID+'"  class="radio radioANS" type="radio" name="answer'+t+'">\n' +
            '                                <i class="icon"></i>\n' +
            '                                <input q-id="'+t+'" data-id="'+variantID+'"   id="v'+variantID+'"  name="add_answer'+t+'[]" type="text" class="form-control test_control" placeholder="">\n' +
            '                            </label>');

    });



    //save new question in editing page
    $(document).on("click", "#save_edit_test_btn_new", function(e) {
        e.preventDefault();
        var t = $("#new_ques_id").val();
        var testID = $("#question_items").attr('data-id');
        var title = $("#ques_title_new_edited").val();
        var is_truetext = $("#answ_id_"+t).val();
        var image = $("#ques_img_new_edited").prop('files')[0];

        var answers = $('input[name^=add_answer' + t + ']').map(function (idx, elem) {
            return $(elem).val();
        }).get();

       /* console.log(testID);
        console.log(title);
        console.log(img);
        console.log(answers);
        console.log(is_true);*/




        var form_data = new FormData();
        form_data.append('test_id', testID);
        form_data.append('title', title);
        form_data.append('file', image);
        form_data.append('is_true_text', is_truetext);
        form_data.append('answers', JSON.stringify(answers));

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/save-new-que-editing-test',
            data: form_data,
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            //dataType: 'json',
            beforeSend: function () {
                $('#save_edit_test_btn_new').html('В процесее ...');
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


    //save edited Test
    $(document).on("click", "#save_edited_test", function(e) {
        e.preventDefault();

        var testID = $("#question_items").attr('data-id');

       /* var facult = $('#facult_id').val();
        var course = $('#course_id').val();*/
       // var subject = $('#subject_id').val();

        var checkpoint = $('#checkpoint').val();
        var test_timer = $('#test_timer').val();


        var form_data = new FormData();
        form_data.append('test_id', testID);
        /*form_data.append('facult_id', facult);
        form_data.append('course_id', course);*/
       // form_data.append('subject_id', subject);
        form_data.append('checkpoint', checkpoint);
        form_data.append('test_timer', test_timer);


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });

        $.ajax({
            url: '/save-edited-test',
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
                setTimeout("location.href = '/my-tests'", 1000);


            },
            error: function (data) {
                console.log(data);
            }
        });

    });

    $(document).on('change', '#f_id', function () {
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




})(jQuery);
