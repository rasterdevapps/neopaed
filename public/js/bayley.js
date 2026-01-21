$(document).ready(function() {

    var reduce_cg = 0;
    var reduce_rc = 0;
    var reduce_ec = 0;
    var reduce_fm = 0;
    var reduce_gm = 0;

    var scroll_done_cg = 0;
    var scroll_done_rc = 0;
    var scroll_done_ec = 0;
    var scroll_done_fm = 0;
    var scroll_done_gm = 0;

    var prev_point = '';
    $(document).on('click', '#bayley_form a[data-toggle="collapse"]', function() {
        makeMove();
    });

    function makeMove() {     
        setTimeout(function() {
            prev_point = '';
            reduce_cg = $('#bayleyHeadingOne').position().top;
            reduce_rc = $('#bayleyHeadingTwo').position().top;
            reduce_ec = $('#bayleyHeadingThree').position().top;
            reduce_fm = $('#bayleyHeadingFour').position().top;
            reduce_gm = $('#bayleyHeadingFive').position().top;
            reduce_se = $('#bayleyHeadingSix').position().top;
            reduce_ab = $('#bayleyHeadingSeven').position().top;
            var make_scroll = 0;
            if ($('.collapse').hasClass('in')) {
                $('.category-block').addClass('hide');
                var href_name = $('.collapse.in').attr('id');
                var category_name = '';
                var reduce = 0;
                if (href_name == 'bayleyOne') {
                    category_name = 'cg';
                    reduce = reduce_cg;
                    // if (scroll_done_cg == 0) {
                    make_scroll = 1;
                        // scroll_done_cg = 1;
                    // }
                    $('#cg-active-block').removeClass('hide');
                } else if (href_name == 'bayleyTwo') {
                    category_name = 'rc';
                    reduce = reduce_rc;
                    // if (scroll_done_rc == 0) {
                    make_scroll = 1;
                        // scroll_done_rc = 1;
                    // }
                    $('#rc-active-block').removeClass('hide');
                } else if (href_name == 'bayleyThree') {
                    category_name = 'ec';
                    reduce = reduce_ec;
                    // if (scroll_done_ec == 0) {
                    make_scroll = 1;
                        // scroll_done_ec = 1;
                    // }
                    $('#ec-active-block').removeClass('hide');
                } else if (href_name == 'bayleyFour') {
                    category_name = 'fm';
                    reduce = reduce_fm;
                    // if (scroll_done_fm == 0) {
                    make_scroll = 1;
                        // scroll_done_fm = 1;
                    // }
                    $('#fm-active-block').removeClass('hide');
                } else if (href_name == 'bayleyFive') {
                    category_name = 'gm';
                    reduce = reduce_gm;
                    // if (scroll_done_gm == 0) {
                    make_scroll = 1;
                        // scroll_done_gm = 1;
                    // }
                    $('#gm-active-block').removeClass('hide');
                } else if (href_name == 'bayleySix') {
                    category_name = 'se';
                    reduce = reduce_se;
                    make_scroll = 1;
                    $('#se-active-block').removeClass('hide');
                } else if (href_name == 'bayleySeven') {
                    category_name = 'ab';
                    reduce = reduce_ab;
                    make_scroll = 1;
                    $('#ab-active-block').removeClass('hide');
                }

                if (href_name != 'bayleySix' && href_name != 'bayleySeven') {
                    var point_name = startPoint();
                    $('input[name="start_point"]').val(point_name);
                    $('#' + category_name + '-point-' + point_name).parent().find('.bookmark').removeClass('display-none');
                    if (make_scroll == 1) {
                        var position = $('#' + category_name + '-point-' + point_name).position().top + reduce;
                    }
                } else {                    
                    if (make_scroll == 1) {
                        var position = $('#' + category_name + '-point').position().top + reduce;
                    }
                }
                $('html, body').animate({
                    scrollTop: position
                }, 2000);

                if (href_name == 'bayleySix') {
                    var point_name = lastPoint();
                    $('tr[data-category="6"][data-question="' + point_name + '"]').addClass('stop-bg');
                    $('tr[data-category="6"].stop-bg').nextAll().find('.score-bg-se').addClass('score-disabled');
                }

            } else {
                $('.category-block').addClass('hide');
            }
        }, 500);
    }

    function startPoint() {
        var days = $('input[name="whole_days"]').val();

        if (days >= 16 && days < 60) {
            return 'A';
        } else if (days >= 60 && days < 90) {
            return 'B';
        } else if (days >= 90 && days < 120) {
            return 'C';
        } else if (days >= 120 && days < 150) {
            return 'D';
        } else if (days >= 150 && days < 180) {
            return 'E';
        } else if (days >= 180 && days < 210) {
            return 'F';
        } else if (days >= 210 && days < 240) {
            return 'G';
        } else if (days >= 240 && days < 330) {
            return 'H';
        } else if (days >= 330 && days < 420) {
            return 'I';
        } else if (days >= 420 && days < 510) {
            return 'J';
        } else if (days >= 510 && days < 600) {
            return 'K';
        } else if (days >= 600 && days < 690) {
            return 'L';
        } else if (days >= 690 && days < 780) {
            return 'M';
        } else if (days >= 780 && days < 870) {
            return 'N';
        } else if (days >= 870 && days < 990) {
            return 'O';
        } else if (days >= 990 && days < 1170) {
            return 'P';
        } else if (days >= 1170 && days < 1290) {
            return 'Q';
        }
    }

    function lastPoint() {
        var days = $('input[name="whole_days"]').val();
        var month = days / 30;
            month = parseInt(month);

        if (month <= 3) {
            return 11;
        } else if (month >= 4 && month <= 5) {
            return 13;
        } else if (month >= 6 && month <= 9) {
            return 15;
        } else if (month >= 10 && month <= 14) {
            return 17;
        } else if (month >= 15 && month <= 18) {
            return 21;
        } else if (month >= 19 && month <= 24) {
            return 24;
        } else if (month >= 25 && month <= 30) {
            return 28;
        } else if (month >= 31 && month <= 42) {
            return 35;
        }
    }

    var continuous_3_2 = 0;
    var top_3_not_equal_to_2 = 0;
    var prev_found = 0;
    var cg_pass_mark = $('input[name="cg_pass_mark"]').val();
    cg_pass_mark = cg_pass_mark == 3 ? true : false;
    var rc_pass_mark = $('input[name="rc_pass_mark"]').val();
    rc_pass_mark = rc_pass_mark == 3 ? true : false;
    var ec_pass_mark = $('input[name="ec_pass_mark"]').val();
    ec_pass_mark = ec_pass_mark == 3 ? true : false;
    var fm_pass_mark = $('input[name="fm_pass_mark"]').val();
    fm_pass_mark = fm_pass_mark == 3 ? true : false;
    var gm_pass_mark = $('input[name="gm_pass_mark"]').val();
    gm_pass_mark = gm_pass_mark == 3 ? true : false;

    var cg_pass_manager = $('input[name="cg_pass_manager"]').val();
    if (typeof cg_pass_manager !== 'undefined') {
        cg_pass_manager = JSON.parse(cg_pass_manager);
    }
    var rc_pass_manager = $('input[name="rc_pass_manager"]').val();
    if (typeof rc_pass_manager !== 'undefined') {
        rc_pass_manager = JSON.parse(rc_pass_manager);
    }
    var ec_pass_manager = $('input[name="ec_pass_manager"]').val();
    if (typeof ec_pass_manager !== 'undefined') {
        ec_pass_manager = JSON.parse(ec_pass_manager);
    }
    var fm_pass_manager = $('input[name="fm_pass_manager"]').val();
    if (typeof fm_pass_manager !== 'undefined') {
        fm_pass_manager = JSON.parse(fm_pass_manager);
    }
    var gm_pass_manager = $('input[name="gm_pass_manager"]').val();
    if (typeof gm_pass_manager !== 'undefined') {
        gm_pass_manager = JSON.parse(gm_pass_manager);
    }

    var last_cg = parseInt($('input[name="last_cg"]').val());
    var last_rc = parseInt($('input[name="last_rc"]').val());
    var last_ec = parseInt($('input[name="last_ec"]').val());
    var last_fm = parseInt($('input[name="last_fm"]').val());
    var last_gm = parseInt($('input[name="last_gm"]').val());

    $(document).on('click', '.score-block', function() {
        var score = $(this).attr('data-value');
        score = parseInt(score);
        var element = $(this).parents('tr');
        var category_id = element.attr('data-category');
        var question_id = element.attr('data-question');
        var sub_id = element.attr('data-sub-question');
        $('input[name="score_sub_id[' + category_id + '][' + question_id + ']"]').val(sub_id).addClass('add-value');
        $('input[name="score[' + category_id + '][' + question_id + ']"]').val(score).addClass('add-value').trigger('change').attr('data-manual', true);
        $('input[name="is_manual[' + category_id + '][' + question_id + ']"]').val(true).addClass('add-value');
        $('tr[data-category="' + category_id + '"][data-question="' + question_id + '"]').find('td.score-block').removeClass('active-block');
        $('tr[data-category="' + category_id + '"][data-question="' + question_id + '"][data-sub-question="' + sub_id + '"]').find('td.score-block').addClass('active-block');
        var current_count = $(this).parent('tr').attr('data-count');

        var current_point = $(this).parents('tr[data-category="' + category_id + '"][data-question="' + question_id + '"]').attr('data-point');

        continuous_3_2 = 0;
        top_3_not_equal_to_2 = 0;

        var cg = rc = ec = fm = gm = 0;

        var active_category_name = '';
        var active_category_id = 0;
        var cg_continuous_five_zero = rc_continuous_five_zero = ec_continuous_five_zero = fm_continuous_five_zero = gm_continuous_five_zero = true;

        $('#bayleyOne.in .score-bg.active-block').each(function() {
            var score = $(this).attr('data-value');
            score = parseInt(score);
            cg = cg + score;
            $('input[name="cg"]').val(cg);
            $('#cg b').html(cg);
            var temp_point = $(this).parent('tr').attr('data-point');
            var count = $(this).parent('tr').attr('data-count');
            count = parseInt(count);
            if (temp_point == current_point) {
                if (count == 1 || count == 2 || count == 3) {
                    if (score < 2) {
                        top_3_not_equal_to_2++;
                    } else {
                        top_3_not_equal_to_2 = 0;
                    }
                    if (score == 2) {
                        continuous_3_2++;
                    }
                    if (continuous_3_2 == 3) {
                        if (cg_pass_manager.length == 0) {
                            var temp_question_id = parseInt(question_id);
                            cg_pass_manager.push(temp_question_id - 2);
                            cg_pass_manager.push(temp_question_id - 1);
                            cg_pass_manager.push(temp_question_id);
                        }
                        cg_pass_mark = true;
                    }
                }
            }
            active_category_name = 'cg';
            active_category_id = 1;
            reduce = reduce_cg;
        });

        $('#bayleyTwo.in .score-bg.active-block').each(function() {
            var score = $(this).attr('data-value');
            score = parseInt(score);
            rc = rc + score;
            $('input[name="rc"]').val(rc);
            $('#rc b').html(rc);
            var temp_point = $(this).parent('tr').attr('data-point');
            var count = $(this).parent('tr').attr('data-count');
            count = parseInt(count);
            if (temp_point == current_point) {
                if (count == 1 || count == 2 || count == 3) {
                    if (score < 2) {
                        top_3_not_equal_to_2++;
                    } else {
                        top_3_not_equal_to_2 = 0;
                    }
                    if (score == 2) {
                        continuous_3_2++;
                    }
                    if (continuous_3_2 == 3) {
                        if (rc_pass_manager.length == 0) {
                            var temp_question_id = parseInt(question_id);
                            rc_pass_manager.push(temp_question_id - 2);
                            rc_pass_manager.push(temp_question_id - 1);
                            rc_pass_manager.push(temp_question_id);
                        }
                        rc_pass_mark = true;
                    }
                }
            }
            active_category_name = 'rc';
            active_category_id = 2;
            reduce = reduce_rc;
        });

        $('#bayleyThree.in .score-bg.active-block').each(function() {
            var score = $(this).attr('data-value');
            score = parseInt(score);
            ec = ec + score;
            $('input[name="ec"]').val(ec);
            $('#ec b').html(ec);
            var temp_point = $(this).parent('tr').attr('data-point');
            var count = $(this).parent('tr').attr('data-count');
            count = parseInt(count);
            if (temp_point == current_point) {
                if (count == 1 || count == 2 || count == 3) {
                    if (score < 2) {
                        top_3_not_equal_to_2++;
                    } else {
                        top_3_not_equal_to_2 = 0;
                    }
                    if (score == 2) {
                        continuous_3_2++;
                    }
                    if (continuous_3_2 == 3) {
                        if (ec_pass_manager.length == 0) {
                            var temp_question_id = parseInt(question_id);
                            ec_pass_manager.push(temp_question_id - 2);
                            ec_pass_manager.push(temp_question_id - 1);
                            ec_pass_manager.push(temp_question_id);
                        }
                        ec_pass_mark = true;
                    }
                }
            }
            active_category_name = 'ec';
            active_category_id = 3;
            reduce = reduce_ec;
        });

        $('#bayleyFour.in .score-bg.active-block').each(function() {
            var score = $(this).attr('data-value');
            score = parseInt(score);
            fm = fm + score;
            $('input[name="fm"]').val(fm);
            $('#fm b').html(fm);
            var temp_point = $(this).parent('tr').attr('data-point');
            var count = $(this).parent('tr').attr('data-count');
            count = parseInt(count);
            if (temp_point == current_point) {
                if (count == 1 || count == 2 || count == 3) {
                    if (score < 2) {
                        top_3_not_equal_to_2++;
                    } else {
                        top_3_not_equal_to_2 = 0;
                    }
                    if (score == 2) {
                        continuous_3_2++;
                    }
                    if (continuous_3_2 == 3) {
                        if (fm_pass_manager.length == 0) {
                            var temp_question_id = parseInt(question_id);
                            fm_pass_manager.push(temp_question_id - 2);
                            fm_pass_manager.push(temp_question_id - 1);
                            fm_pass_manager.push(temp_question_id);
                        }
                        fm_pass_mark = true;
                    }
                }
            }
            active_category_name = 'fm';
            active_category_id = 4;
            reduce = reduce_fm;
        });
        
        $('#bayleyFive.in .score-bg.active-block').each(function() {
            var score = $(this).attr('data-value');
            score = parseInt(score);
            gm = gm + score;
            $('input[name="gm"]').val(gm);
            $('#gm b').html(gm);
            var temp_point = $(this).parent('tr').attr('data-point');
            var count = $(this).parent('tr').attr('data-count');
            count = parseInt(count);
            if (temp_point == current_point) {
                if (count == 1 || count == 2 || count == 3) {
                    if (score < 2) {
                        top_3_not_equal_to_2++;
                    } else {
                        top_3_not_equal_to_2 = 0;
                    }
                    if (score == 2) {
                        continuous_3_2++;
                    }
                    if (continuous_3_2 == 3) {
                        if (gm_pass_manager.length == 0) {
                            var temp_question_id = parseInt(question_id);
                            gm_pass_manager.push(temp_question_id - 2);
                            gm_pass_manager.push(temp_question_id - 1);
                            gm_pass_manager.push(temp_question_id);
                        }
                        gm_pass_mark = true;
                    }
                }
            }
            active_category_name = 'gm';
            active_category_id = 5;
            reduce = reduce_gm;
        });

        if (active_category_name == 'cg') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#cg-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        cg_continuous_five_zero = false;
                    }
                }
                if (cg_continuous_five_zero) {
                    makeActive();
                    cg_pass_mark = true;
                }
            }
            if (question_id == last_cg) {
                makeActive();
                cg_pass_mark = true;
            }
            if (cg_pass_manager.indexOf(parseInt(question_id)) >= 0 && score < 2) {
                cg_pass_mark = false;
                cg_pass_manager = [];
            }
            if (cg_pass_mark) {
                var ques_id = $('.cg-scale-score[value="2"]').attr('data-ques-id');
                ques_id = parseInt(ques_id) - 1;
                for (var i = ques_id; i > 0; i--) {
                    $('#cg-ans-' + i).val(2).addClass('add-value').attr('data-manual', false);
                    var score_name = $('#cg-ans-' + i).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    var sub_id = $('#cg-ans-' + i).parent().attr('data-sub-question');
                    $('input[name="' + score_name + '"]').val(sub_id).addClass('add-value');
                    $('tr[data-category="1"][data-question="' + i + '"] .score-block').removeClass('active-block');
                    $('tr[data-category="1"][data-question="' + i + '"] .score-block[data-value="2"]').addClass('active-block');
                }
                var cg_value = 0;
                $('#bayleyOne .score-bg-cg.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    cg_value = cg_value + temp_value;
                });
                $('input[name="cg"]').val(cg_value);
                $('#cg b').html(cg_value);
            } else {
                $('.cg-scale-score[data-manual="false"]').each(function() {
                    var ques_id = $(this).attr('data-ques-id');
                    $('#cg-ans-' + ques_id).val('').addClass('add-value').attr('data-manual', false);
                    var score_name = $('#cg-ans-' + ques_id).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    if ($('input[name="' + score_name + '"]').attr('data-original') > 0) {
                        $('input[name="' + score_name + '"]').addClass('add-value');
                    } else {
                        $('input[name="' + score_name + '"]').val('').addClass('add-value');
                    }
                    $('tr[data-category="1"][data-question="' + ques_id + '"] .score-block').removeClass('active-block');
                });
                var cg_value = 0;
                $('#bayleyOne .score-bg-cg.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    cg_value = cg_value + temp_value;
                });
                $('input[name="cg"]').val(cg_value);
                $('#cg b').html(cg_value);
            }

        }

        if (active_category_name == 'rc') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#rc-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        rc_continuous_five_zero = false;
                    }
                }
                if (rc_continuous_five_zero) {
                    makeActive();
                    rc_pass_mark = true;
                }
            }
            if (question_id == last_rc) {
                makeActive();
                rc_pass_mark = true;
            }
            if (rc_pass_manager.indexOf(parseInt(question_id)) >= 0 && score < 2) {
                rc_pass_mark = false;
                rc_pass_manager = [];
            }
            if (rc_pass_mark) {
                var ques_id = $('.rc-scale-score[value="2"]').attr('data-ques-id');
                ques_id = parseInt(ques_id) - 1;
                for (var i = ques_id; i > 0; i--) {
                    $('#rc-ans-' + i).val(2).addClass('add-value').attr('data-manual', false);
                    var score_name = $('#rc-ans-' + i).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    var sub_id = $('#rc-ans-' + i).parent().attr('data-sub-question');
                    $('input[name="' + score_name + '"]').val(sub_id).addClass('add-value');
                    $('tr[data-category="2"][data-question="' + i + '"] .score-block').removeClass('active-block');
                    $('tr[data-category="2"][data-question="' + i + '"] .score-block[data-value="2"]').addClass('active-block');
                }
                var rc_value = 0;
                $('#bayleyTwo .score-bg-rc.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    rc_value = rc_value + temp_value;
                });
                $('input[name="rc"]').val(rc_value);
                $('#rc b').html(rc_value);
            } else {
                $('.rc-scale-score[data-manual="false"]').each(function() {
                    var ques_id = $(this).attr('data-ques-id');
                    $('#rc-ans-' + ques_id).val('').addClass('add-value').attr('data-manual', false);
                    var score_name = $('#rc-ans-' + ques_id).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    if ($('input[name="' + score_name + '"]').attr('data-original') > 0) {
                        $('input[name="' + score_name + '"]').addClass('add-value');
                    } else {
                        $('input[name="' + score_name + '"]').val('').addClass('add-value');
                    }
                    $('tr[data-category="2"][data-question="' + ques_id + '"] .score-block').removeClass('active-block');
                });
                var rc_value = 0;
                $('#bayleyOne .score-bg-rc.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    rc_value = rc_value + temp_value;
                });
                $('input[name="rc"]').val(rc_value);
                $('#rc b').html(rc_value);
            }
        }

        if (active_category_name == 'ec') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#ec-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        ec_continuous_five_zero = false;
                    }
                }
                if (ec_continuous_five_zero) {
                    makeActive();
                    ec_pass_mark = true;
                }
            }
            if (question_id == last_ec) {
                makeActive();
                ec_pass_mark = true;
            }
            if (ec_pass_manager.indexOf(parseInt(question_id)) >= 0 && score < 2) {
                ec_pass_mark = false;
                ec_pass_manager = [];
            }

            if (ec_pass_mark) {
                var ques_id = $('.ec-scale-score[value="2"]').attr('data-ques-id');
                ques_id = parseInt(ques_id) - 1;
                for (var i = ques_id; i > 0; i--) {
                    $('#ec-ans-' + i).val(2).addClass('add-value').attr('data-manual', false);
                    var score_name = $('#ec-ans-' + i).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    var sub_id = $('#ec-ans-' + i).parent().attr('data-sub-question');
                    $('input[name="' + score_name + '"]').val(sub_id).addClass('add-value');
                    $('tr[data-category="3"][data-question="' + i + '"] .score-block').removeClass('active-block');
                    $('tr[data-category="3"][data-question="' + i + '"] .score-block[data-value="2"]').addClass('active-block');
                }
                var ec_value = 0;
                $('#bayleyThree .score-bg-ec.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    ec_value = ec_value + temp_value;
                });
                $('input[name="ec"]').val(ec_value);
                $('#ec b').html(ec_value);
            } else {
                $('.ec-scale-score[data-manual="false"]').each(function() {
                    var ques_id = $(this).attr('data-ques-id');
                    $('#ec-ans-' + ques_id).val('').addClass('add-value').attr('data-manual', false);
                    var score_name = $('#ec-ans-' + ques_id).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    if ($('input[name="' + score_name + '"]').attr('data-original') > 0) {
                        $('input[name="' + score_name + '"]').addClass('add-value');
                    } else {
                        $('input[name="' + score_name + '"]').val('').addClass('add-value');
                    }
                    $('tr[data-category="3"][data-question="' + ques_id + '"] .score-block').removeClass('active-block');
                });
                var ec_value = 0;
                $('#bayleyOne .score-bg-ec.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    ec_value = ec_value + temp_value;
                });
                $('input[name="ec"]').val(ec_value);
                $('#ec b').html(ec_value);
            }
        }

        if (active_category_name == 'fm') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#fm-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        fm_continuous_five_zero = false;
                    }
                }
                if (fm_continuous_five_zero) {
                    makeActive();
                    fm_pass_mark = true;
                }
            }
            if (question_id == last_fm) {
                makeActive();
                fm_pass_mark = true;
            }
            if (fm_pass_manager.indexOf(parseInt(question_id)) >= 0 && score < 2) {
                fm_pass_mark = false;
                fm_pass_manager = [];
            }
            if (fm_pass_mark) {
                var ques_id = $('.fm-scale-score[value="2"]').attr('data-ques-id');
                ques_id = parseInt(ques_id) - 1;
                for (var i = ques_id; i > 0; i--) {
                    $('#fm-ans-' + i).val(2).addClass('add-value').attr('data-manual', false);
                    var score_name = $('#fm-ans-' + i).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    var sub_id = $('#fm-ans-' + i).parent().attr('data-sub-question');
                    $('input[name="' + score_name + '"]').val(sub_id).addClass('add-value');
                    $('tr[data-category="4"][data-question="' + i + '"] .score-block').removeClass('active-block');
                    $('tr[data-category="4"][data-question="' + i + '"] .score-block[data-value="2"]').addClass('active-block');
                }
                var fm_value = 0;
                $('#bayleyFour .score-bg-fm.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    fm_value = fm_value + temp_value;
                });
                $('input[name="fm"]').val(fm_value);
                $('#fm b').html(fm_value);
            } else {
                $('.fm-scale-score[data-manual="false"]').each(function() {
                    var ques_id = $(this).attr('data-ques-id');
                    $('#fm-ans-' + ques_id).val('').addClass('add-value').attr('data-manual', false);
                    var score_name = $('#fm-ans-' + ques_id).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    if ($('input[name="' + score_name + '"]').attr('data-original') > 0) {
                        $('input[name="' + score_name + '"]').addClass('add-value');
                    } else {
                        $('input[name="' + score_name + '"]').val('').addClass('add-value');
                    }
                    $('tr[data-category="4"][data-question="' + ques_id + '"] .score-block').removeClass('active-block');
                });
                var fm_value = 0;
                $('#bayleyOne .score-bg-fm.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    fm_value = fm_value + temp_value;
                });
                $('input[name="fm"]').val(fm_value);
                $('#fm b').html(fm_value);
            }
        }

        if (active_category_name == 'gm') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#gm-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        gm_continuous_five_zero = false;
                    }
                }
                if (gm_continuous_five_zero) {
                    makeActive();
                    gm_pass_mark = true;
                }
            }
            if (question_id == last_gm) {
                makeActive();
                gm_pass_mark = true;
            }
            if (gm_pass_manager.indexOf(parseInt(question_id)) >= 0 && score < 2) {
                gm_pass_mark = false;
                gm_pass_manager = [];
            }

            if (gm_pass_mark) {
                var ques_id = $('.gm-scale-score[value="2"]').attr('data-ques-id');
                ques_id = parseInt(ques_id) - 1;
                for (var i = ques_id; i > 0; i--) {
                    $('#gm-ans-' + i).val(2).addClass('add-value').attr('data-manual', false);
                    var score_name = $('#gm-ans-' + i).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    var sub_id = $('#gm-ans-' + i).parent().attr('data-sub-question');
                    $('input[name="' + score_name + '"]').val(sub_id).addClass('add-value');
                    $('tr[data-category="5"][data-question="' + i + '"] .score-block').removeClass('active-block');
                    $('tr[data-category="5"][data-question="' + i + '"] .score-block[data-value="2"]').addClass('active-block');
                }
                var gm_value = 0;
                $('#bayleyFive .score-bg-gm.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    gm_value = gm_value + temp_value;
                });
                $('input[name="gm"]').val(gm_value);
                $('#gm b').html(gm_value);
            } else {
                $('.gm-scale-score[data-manual="false"]').each(function() {
                    var ques_id = $(this).attr('data-ques-id');
                    $('#gm-ans-' + ques_id).val('').addClass('add-value').attr('data-manual', false);
                    var score_name = $('#gm-ans-' + ques_id).attr('name');
                    score_name = score_name.replace('score', 'score_sub_id');
                    if ($('input[name="' + score_name + '"]').attr('data-original') > 0) {
                        $('input[name="' + score_name + '"]').addClass('add-value');
                    } else {
                        $('input[name="' + score_name + '"]').val('').addClass('add-value');
                    }
                    $('tr[data-category="5"][data-question="' + ques_id + '"] .score-block').removeClass('active-block');
                });
                var gm_value = 0;
                $('#bayleyOne .score-bg-gm.active-block').each(function() {
                    var temp_value = $(this).attr("data-value");
                    temp_value = parseInt(temp_value);
                    gm_value = gm_value + temp_value;
                });
                $('input[name="gm"]').val(gm_value);
                $('#gm b').html(gm_value);
            }

        }

        if (top_3_not_equal_to_2 > 0 && ((active_category_name == 'cg' && !cg_pass_mark) || (active_category_name == 'rc' && !rc_pass_mark) || (active_category_name == 'ec' && !ec_pass_mark) || (active_category_name == 'fm' && !fm_pass_mark) || (active_category_name == 'gm' && !gm_pass_mark)) && (current_count == 1 || current_count == 2 || current_count == 3)) {
            var first_question = $('tr[data-category="' + category_id + '"][data-point="' + current_point + '"]').attr('data-question');
            var question_id = parseInt(first_question) - 1;
            prev_point = $('tr[data-category="' + active_category_id + '"][data-question="' + question_id + '"]').attr('data-point');
            if (prev_point != undefined) {
                var prev_pointt = prev_point.split(',')[0];
                bootbox.confirm("Are you sure ? Do you want to move for previous question ?", function(confirmed) {
                    if (confirmed) {
                        var position = $('#' + active_category_name + '-point-' + prev_pointt).position().top + reduce;
                        $('html, body').animate({
                            scrollTop: position
                        }, 2000);
                        prev_found = 1;
                    }
                });
            }
        }

        if (continuous_3_2 == 3 && prev_found && current_point == prev_point) {
            $('tr[data-category="' + category_id + '"][data-type="1"][data-point="' + current_point + '"][data-scale="2"]').each(function() {
                var loop_question_id = $(this).attr('data-question');
                loop_question_id = parseInt(loop_question_id);
                question_id = parseInt(question_id);
                if (question_id < loop_question_id) {
                    $('tr[data-category="' + category_id + '"] #' + active_category_name + '-ans-' + loop_question_id).val(2).attr('data-manual', false);
                    $('tr[data-category="' + category_id + '"] #' + active_category_name + '-manual-' + loop_question_id).val(false);
                    $('tr[data-category="' + category_id + '"][data-question="' + loop_question_id + '"] .score-block[data-value="2"]').addClass('active-block');
                }
            });
        }

    });

    $(document).on('click', '.score-block-2', function() {
        var se = ab_r = ab_e = ab_p = ab_ir = ab_pl = 0;
        var ab_r_continuous_five_zero = ab_e_continuous_five_zero = ab_p_continuous_five_zero = ab_ir_continuous_five_zero = ab_pl_continuous_five_zero = true;

        var score = $(this).attr('data-value');
        score = parseInt(score);
        var element = $(this).parents('tr');
        var category_id = element.attr('data-category');
        var question_id = element.attr('data-question');
        var sub_id = element.attr('data-sub-question');
        $('tr[data-category="' + category_id + '"][data-question="' + question_id + '"]').find('td.score-block-2').removeClass('active-block');
        $('tr[data-category="' + category_id + '"][data-question="' + question_id + '"]').find('td.score-block-2[data-value="' + score + '"]').addClass('active-block');
        $('input[name="score[' + category_id + '][' + question_id + ']"]').val(score).trigger('change');
        $('input[name="score_sub_id[' + category_id + '][' + question_id + ']"]').val(sub_id).addClass('add-value');

        $('#bayleySix.in .score-bg.active-block').each(function() {
            var score = $(this).attr('data-value');
            score = parseInt(score);
            se = se + score;
            $('input[name="se_raw_score"]').val(se);
            $('#se b').html(se);
        });

        if (element.hasClass('stop-bg')) {
            makeActive();
        }

        var ab_active_category = $(this).parents('.bayley-ab').attr('id');

        $('#bayleySeven.in #' + ab_active_category + ' .score-bg.active-block').each(function() {
            if (ab_active_category == 'ab-r') {
                var score = $(this).attr('data-value');
                score = parseInt(score);
                ab_r = ab_r + score;
                $('input[name="rec_raw_score"]').val(ab_r);
                $('#ab_r b').html(ab_r);
            } else  if (ab_active_category == 'ab-e') {
                var score = $(this).attr('data-value');
                score = parseInt(score);
                ab_e = ab_e + score;
                $('input[name="exp_raw_score"]').val(ab_e);
                $('#ab_e b').html(ab_e);
            } else  if (ab_active_category == 'ab-p') {
                var score = $(this).attr('data-value');
                score = parseInt(score);
                ab_p = ab_p + score;
                $('input[name="per_raw_score"]').val(ab_p);
                $('#ab_p b').html(ab_p);
            } else  if (ab_active_category == 'ab-ir') {
                var score = $(this).attr('data-value');
                score = parseInt(score);
                ab_ir = ab_ir + score;
                $('input[name="ipr_raw_score"]').val(ab_ir);
                $('#ab_ir b').html(ab_ir);
            } else  if (ab_active_category == 'ab-pl') {
                var score = $(this).attr('data-value');
                score = parseInt(score);
                ab_pl = ab_pl + score;
                $('input[name="pla_raw_score"]').val(ab_pl);
                $('#ab_pl b').html(ab_pl);
            }
        });

        if (ab_active_category == 'ab-r') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#ab_r-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        ab_r_continuous_five_zero = false;
                    }
                }
                if (ab_r_continuous_five_zero) {
                    makeActive(ab_active_category);
                }
            }
        } else if (ab_active_category == 'ab-e') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#ab_e-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        ab_e_continuous_five_zero = false;
                    }
                }
                if (ab_e_continuous_five_zero) {
                    makeActive(ab_active_category);
                }
            }
        } else if (ab_active_category == 'ab-p') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#ab_p-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        ab_p_continuous_five_zero = false;
                    }
                }
                if (ab_p_continuous_five_zero) {
                    makeActive(ab_active_category);
                }
            }
        } else if (ab_active_category == 'ab-ir') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#ab_ir-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        ab_ir_continuous_five_zero = false;
                    }
                }
                if (ab_ir_continuous_five_zero) {
                    makeActive(ab_active_category);
                }
            }
        } else if (ab_active_category == 'ab-pl') {
            if (score == 0) {
                var zero_ques_id = question_id;
                for (var i = 0; i < 4; i++) {
                    zero_ques_id--;
                    var prev_ques_ans = $('#ab_pl-ans-' + zero_ques_id).val();
                    if (prev_ques_ans && prev_ques_ans == 0) {

                    } else {
                        ab_pl_continuous_five_zero = false;
                    }
                }
                if (ab_pl_continuous_five_zero) {
                    makeActive(ab_active_category);
                }
            }
        }

    });

    function makeActive(sub_category = '') {
        if ($('#bayleyOne').hasClass('in')) {
            var cg = $('input[name="cg"]').val();
            bootbox.confirm("Cognitive (CG) - Raw Score:" + cg + "<br> Do you want to move on <b>Receptive Communication (RC)</b> ?", function(confirmed) {
                if (confirmed) {                    
                    $('a[href="#bayleyTwo"]').trigger('click');
                    $('.category-block').addClass('hide');
                    $('#rc-active-block').removeClass('hide');
                }
            });
        } else if ($('#bayleyTwo').hasClass('in')) {
            var rc = $('input[name="rc"]').val();
            bootbox.confirm("Receptive Communication (RC) - Raw Score:" + rc + "<br> Do you want to move on <b>Expressive Communication (EC)</b> ?", function(confirmed) {
                if (confirmed) {    
                    $('a[href="#bayleyThree"]').trigger('click');
                    $('.category-block').addClass('hide');
                    $('#ec-active-block').removeClass('hide');
                }
            });
        } else if ($('#bayleyThree').hasClass('in')) {
            var ec = $('input[name="ec"]').val();
            bootbox.confirm("Expressive Communication (EC) - Raw Score:" + ec + "<br> Do you want to move on <b>Fine Motor (FM)</b> ?", function(confirmed) {
                if (confirmed) {    
                    $('a[href="#bayleyFour"]').trigger('click');
                    $('.category-block').addClass('hide');
                    $('#fm-active-block').removeClass('hide');
                }
            });
        } else if ($('#bayleyFour').hasClass('in')) {
            var fm = $('input[name="fm"]').val();
            bootbox.confirm("Fine Motor (FM) - Raw Score:" + fm + "<br> Do you want to move on <b>Gross Motor (GM)</b> ?", function(confirmed) {
                if (confirmed) {    
                    $('a[href="#bayleyFive"]').trigger('click');
                    $('.category-block').addClass('hide');
                    $('#gm-active-block').removeClass('hide');
                }
            });
        } else if ($('#bayleyFive').hasClass('in')) {
            var gm = $('input[name="gm"]').val();
            bootbox.confirm("Gross Motor (GM) - Raw Score:" + gm + "<br> Do you want to move on <b>Social Emotional (SE)</b> ?", function(confirmed) {
                if (confirmed) {  
                    $('a[href="#bayleySix"]').trigger('click');
                    $('.category-block').addClass('hide');
                    $('#se-active-block').removeClass('hide');
                }
            });
        } else if ($('#bayleySix').hasClass('in')) {
            var se = $('input[name="se_raw_score"]').val();
            bootbox.confirm("Social Emotional (SE) - Raw Score:" + se + "<br> Do you want to move on <b>Adaptive Behavior (AB) (Receptive)</b> ?", function(confirmed) {
                if (confirmed) {  
                    $('a[href="#bayleySeven"]').trigger('click');
                    $('.category-block').addClass('hide');
                    $('#ab-active-block').removeClass('hide');
                }
            });
        } else if ($('#bayleySeven').hasClass('in')) {
            var reduce = $('#bayleyHeadingSeven').position().top;
            if (sub_category == 'ab-r') {
                var rec_raw_score = $('input[name="rec_raw_score"]').val();
                bootbox.confirm("Adaptive Behavior (AB) (Receptive) - Raw Score:" + rec_raw_score + "<br> Do you want to move on <b>Adaptive Behavior (AB) (Expressive)</b> ?", function(confirmed) {
                    if (confirmed) {  
                        var position = $('#ab-e').position().top + reduce;
                        $('html, body').animate({
                            scrollTop: position
                        }, 2000);
                    }
                });
            } else  if (sub_category == 'ab-e') {
                var exp_raw_score = $('input[name="exp_raw_score"]').val();
                bootbox.confirm("Adaptive Behavior (AB) (Expressive) - Raw Score:" + exp_raw_score + "<br> Do you want to move on <b>Adaptive Behavior (AB) (Personal)</b> ?", function(confirmed) {
                    if (confirmed) {    
                        var position = $('#ab-p').position().top + reduce;
                        $('html, body').animate({
                            scrollTop: position
                        }, 2000);
                    }
                });
            } else  if (sub_category == 'ab-p') {
                var per_raw_score = $('input[name="per_raw_score"]').val();
                bootbox.confirm("Adaptive Behavior (AB) (Personal) - Raw Score:" + per_raw_score + "<br> Do you want to move on <b>Adaptive Behavior (AB) (Interpersonal Relationships)</b> ?", function(confirmed) {
                    if (confirmed) {  
                        var position = $('#ab-ir').position().top + reduce;
                        $('html, body').animate({
                            scrollTop: position
                        }, 2000);
                    }
                });
            } else  if (sub_category == 'ab-ir') {
                var ipr_raw_score = $('input[name="ipr_raw_score"]').val();
                bootbox.confirm("Adaptive Behavior (AB) (Interpersonal Relationships) - Raw Score:" + ipr_raw_score + "<br> Do you want to move on <b>Adaptive Behavior (AB) (Play and Leisure)</b> ?", function(confirmed) {
                    if (confirmed) {  
                        var position = $('#ab-pl').position().top + reduce;
                        $('html, body').animate({
                            scrollTop: position
                        }, 2000);
                    }
                });
            } else  if (sub_category == 'ab-pl') {
                var pla_raw_score = $('input[name="pla_raw_score"]').val();
                bootbox.confirm("Adaptive Behavior (AB) (Play and Leisure) - Raw Score:" + pla_raw_score, function(confirmed) {
                    if (confirmed) {  
                        $('a[href="#bayleySeven"]').trigger('click');
                        $('.category-block').addClass('hide');
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                    }
                });
            }
        }
    }

    function setDefaultConfidenceInverval() {
        var confidence_interval = $('input[name="confidence_interval"]').val();
        if (confidence_interval == '') {
            $('input[name="confidence_interval"]').val(95);
        }
    }

    $('.note-input').on('change', function() {
        $(this).addClass('add-value');
    });

    $('input[name="rc_scaled_score"], input[name="ec_scaled_score"]').on('change', function() {
        var rc_scaled_score = $('input[name="rc_scaled_score"]').val();
        rc_scaled_score = $.isNumeric(rc_scaled_score) ? parseInt(rc_scaled_score) : 0;
        var ec_scaled_score = $('input[name="ec_scaled_score"]').val();
        ec_scaled_score = $.isNumeric(ec_scaled_score) ? parseInt(ec_scaled_score) : 0;
        var lang_scaled_score = rc_scaled_score + ec_scaled_score;
        $('input[name="lang_scaled_score"]').val(lang_scaled_score);
        $('input[name="lang_scaled_score_copy"]').val(lang_scaled_score);
        setDefaultConfidenceInverval();        
    });

    $('input[name="fm_scaled_score"], input[name="gm_scaled_score"]').on('change', function() {
        var fm_scaled_score = $('input[name="fm_scaled_score"]').val();
        fm_scaled_score = $.isNumeric(fm_scaled_score) ? parseInt(fm_scaled_score) : 0;
        var gm_scaled_score = $('input[name="gm_scaled_score"]').val();
        gm_scaled_score = $.isNumeric(gm_scaled_score) ? parseInt(gm_scaled_score) : 0;
        var mot_scaled_score = fm_scaled_score + gm_scaled_score;
        $('input[name="mot_scaled_score"]').val(mot_scaled_score);
        $('input[name="mot_scaled_score_copy"]').val(mot_scaled_score);
        setDefaultConfidenceInverval();        
    });

    $('input[name="cg_scaled_score"]').on('change', function() {
        $('input[name="cg_scaled_score_copy"]').val($('input[name="cg_scaled_score"]').val());
        setDefaultConfidenceInverval();
    });

    $('input[name="se_scaled_score"]').on('change', function() {
        $('input[name="se_scaled_score_copy"]').val($('input[name="se_scaled_score"]').val());
        setDefaultConfidenceInverval();        
    });

    $('input[name="rec_scaled_score"], input[name="exp_scaled_score"], input[name="per_scaled_score"], input[name="ipr_scaled_score"], input[name="pla_scaled_score"]').on('change', function() {
        var rec_scaled_score = $('input[name="rec_scaled_score"]').val();
        rec_scaled_score = $.isNumeric(rec_scaled_score) ? parseInt(rec_scaled_score) : 0;

        var exp_scaled_score = $('input[name="exp_scaled_score"]').val();
        exp_scaled_score = $.isNumeric(exp_scaled_score) ? parseInt(exp_scaled_score) : 0;

        var per_scaled_score = $('input[name="per_scaled_score"]').val();
        per_scaled_score = $.isNumeric(per_scaled_score) ? parseInt(per_scaled_score) : 0;

        var ipr_scaled_score = $('input[name="ipr_scaled_score"]').val();
        ipr_scaled_score = $.isNumeric(ipr_scaled_score) ? parseInt(ipr_scaled_score) : 0;

        var pla_scaled_score = $('input[name="pla_scaled_score"]').val();
        pla_scaled_score = $.isNumeric(pla_scaled_score) ? parseInt(pla_scaled_score) : 0;

        var adbe_scaled_score = rec_scaled_score + exp_scaled_score + per_scaled_score + ipr_scaled_score + pla_scaled_score;
        $('input[name="adbe_scaled_score"]').val(adbe_scaled_score);
        $('input[name="adbe_scaled_score_copy"]').val(adbe_scaled_score);

        var com_scaled_score = rec_scaled_score + exp_scaled_score;
        $('input[name="com_scaled_score"]').val(com_scaled_score);

        var soc_scaled_score = ipr_scaled_score + pla_scaled_score;
        $('input[name="soc_scaled_score"]').val(soc_scaled_score);

        setDefaultConfidenceInverval();        

    });

    $('input[name="per_scaled_score"]').on('change', function() {
        $('input[name="per_scaled_score_copy"]').val($('input[name="per_scaled_score"]').val());
    });

    var site_url = $('input[name="site_base_url"]').val();

    $('#export-bayley').on('click', function() {
        $(this).html('Export');
        window.location = site_url + '/neuro-develop/export?id=' + $('input[name="id"]').val();
    });

    $("#seenby_add").click(function() {
        option_select = $("select[name='seenby']").html();
        neo = '<select class="form-control full-width" name="seen_by[]">';
        neo += option_select;
        neo += '</select>';
        option = '<tr><td>' + neo + '</td>';
        option += '<td><span class="fa fa-trash btn btn-danger btn-view remove-neon"></span></td></tr>';
        $(".seen-by-div").append(option);
    });

    relationship();

    $('#relationship_to_child').on('change', function() {
        relationship();
    });

    function relationship()
    {
        if($("#relationship_to_child").val() == 'Other')
        {
            $('#other_relationship').parents('.form-group').slideDown();
        }
        else
        {
            $('#other_relationship').val('');
            $('#other_relationship').parents('.form-group').slideUp();
        }
    }

    $('.import_data').on('click', function() {
        var field_name = $(this).parents('.form-group').find('.tinymce-body').attr('id');
        var action_url = site_url+ '/neuro-develop/import?field='+field_name+'&id=' + $('input[name="id"]').val();
        bootbox.confirm("Do you want to import the data ?", function(confirmed) {
            if (confirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    url: action_url,
                    success: function(response) {
                        if (field_name == 'baby_behavior') {
                            var old_content = $('#baby_behavior').html();
                            if (response.baby_behavior !== undefined) {
                                var content = old_content + response.baby_behavior;
                                $('#baby_behavior').html(content);
                            }
                        } else if (field_name == 'home_program') {
                            var old_content = $('#home_program').html();
                            if (response.home_program !== undefined) {
                                var content = old_content + response.home_program;
                                $('#home_program').html(content);
                            }
                        }
                    }
                });
            }
        });         
    });

    $('input[name="cog_standard_score"]').on('change', function() {
        var cog_standard_score = parseInt($(this).val());
        $('input[name="cog_confidence_interval_start"]').val(cog_standard_score - 9);
        $('input[name="cog_confidence_interval_end"]').val(cog_standard_score + 9);
    });

    $('input[name="lang_standard_score"]').on('change', function() {
        var lang_standard_score = parseInt($(this).val());
        $('input[name="lang_confidence_interval_start"]').val(lang_standard_score - 9);
        $('input[name="lang_confidence_interval_end"]').val(lang_standard_score + 9);
    });

    $('input[name="mot_standard_score"]').on('change', function() {
        var mot_standard_score = parseInt($(this).val());
        $('input[name="mot_confidence_interval_start"]').val(mot_standard_score - 8);
        $('input[name="mot_confidence_interval_end"]').val(mot_standard_score + 8);
    });

});

