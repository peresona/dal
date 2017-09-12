var nowLoading = false;
/* 앱 초기화 */
function _succFn(){}
/* 모바일 전용 */
function mheader(mode){
    if(mode == 'show'){
        hybrid_menubar('hide');
        $('header.forsub').show();
        $('body').attr('style','padding-top:53px !important');
        $('body').addClass('mheader');
    } else if(mode == 'hide'){
        $('header.forsub').hide();
        $('body').attr('style','padding-top:0px !important');
        hybrid_menubar('show');
        $('body').removeClass('mheader');
    }
}
/* 모바일 전용 */

function morebox(layer) {
    if (getId(layer).style.display == 'block') {
        getId(layer).style.display = 'none';
    } else {
        getId(layer).style.display = 'block';
    }
}

function scroll_changing() {
    var scroll = $(window).scrollTop();
    if (!toplimits) var toplimits = 50;
    var scroll_limit = toplimits;
    if (scroll >= scroll_limit) {
        $("header").addClass("active");
        $("#bottom_topbtn").css('background-size', '50px 50px');
        $("#bottom_topbtn").fadeIn('fast');

    } else {
        $("header").removeClass("active");
        $("#bottom_topbtn").fadeOut('fast');
    }
}
// 2차 직업박스
function select_job(num) {
    var form_data = {
        need: 'job_select',
        cate: num
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=getData",
        data: form_data,
        success: function(response) {
            results = JSON.parse(response);
            $('#m_job_category2').show();
            $('#m_job_category2').html(results.options);
        }
    });
}
// 수강신청 박스 클릭
function apply_group(group_num, school_name) {
    $('#modal_apply input[type="text"], #modal_apply input#group_num').val('');
    if (std_info.sc_name) {
        $('#modal_apply input[name="sc_name"]').val(std_info.sc_name);
        $('#modal_apply input[name="std_grade"]').val(std_info.grade);
        $('#modal_apply input[name="std_class"]').val(std_info.class);
        $('#modal_apply input[name="std_num"]').val(std_info.num);
        $('#modal_apply input[name="std_name"]').val(std_info.name);
    }
    if (school_name) {
        $('#modal_apply input[name="sc_name"]').val(school_name);
    }


    $('#modal_apply input#group_num').val(group_num);
    if (group_num) $('#modal_apply').show();
    else alert('오류가 발생하였습니다.');
}

// 일정 상세 보기
function classDayDetail(selectDate) {
    var form_data = {
        need: 'popup_classDayDetail',
        selectDay: selectDate
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=getData",
        data: form_data,
        success: function(response) {
            var results = $.parseJSON(response);
            var datas = results.result;
            if (results.code == '100') {
                $('[data-inhtml="modal_classDay_ul"]').html("Loading");
                $('[data-inhtml="modal_classDay_ul"]').html(datas.day_list);

                $('#modal_classDay').show();
            }
        }
    });
}

function more_job_icons(indexs, obj) {
    var form_data = {
        need: 'jobs_icon',
        index: indexs
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=getData",
        data: form_data,
        success: function(response) {
            var results = $.parseJSON(response);
            if (results.code == '100') {
                $('[data-inhtml="jobs_icon"]').append(results.inhtml);
            }
            if (results.num != 18) {
                $('.d_job_more[data-inbutton]').remove();
            }
        }
    });
}

function more_apply_lists(indexs, obj) {
    var form_data = {
        need: 'apply_lists',
        index: indexs
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=getData",
        data: form_data,
        success: function(response) {
            var results = $.parseJSON(response);
            if (results.code == '100') {
                $('[data-inhtml="apply_lists"]').append(results.inhtml);
                $('[data-moreapply]').data('moreapply', $('[data-moreapply]').data('moreapply') + results.num);
            }
            if (results.num != 6) {
                $('.d_job_more[data-moreapply]').remove();
            }
        }
    });
}

function popup_jobs(job_num) {
    var form_data = {
        need: 'popup_job',
        uid: job_num
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=getData",
        data: form_data,
        success: function(response) {
            var results = $.parseJSON(response);
            var datas = results.result;
            //console.log(datas);
            if (results.code == '100') {
                $('[data-inhtml="modal_job_memo"]').html("Loading");
                $('[data-inhtml="modal_job_assoc"]').html("Loading");
                $('[data-inhtml="modal_job_mentor"]').html("Loading");

                $('[data-inhtml="modal_job_no"]').prop('href', '/jblog/?job=' + job_num);
                $('[data-inhtml="modal_job_name"]').html(datas.name);
                $('[data-inhtml="modal_job_memo"]').html(datas.intro);
                $('[data-inhtml="modal_job_assoc"]').html(datas.assoc);
                $('[data-inhtml="modal_job_mentor"]').html(datas.mentor);
                $('[data-popupJobNo]').val(job_num);

                if ($('[data-inhtml="modal_job_follow"]')) {
                    if (datas.is_my == 'not') {
                        $('[data-inhtml="modal_job_follow"]').hide();
                    } else if (datas.is_my == 0) {
                        $('[data-inhtml="modal_job_follow"]').prop('href', '/?r=home&m=dalkkum&a=myjob&act=regis&job_seq=' + job_num);
                        $('[data-inhtml="modal_job_follow"] input[type="button"]').prop('value', ' + 관심 직업 설정');
                    } else if (datas.is_my > 0) {
                        $('[data-inhtml="modal_job_follow"]').prop('href', '/?r=home&m=dalkkum&a=myjob&act=delete&job_seq=' + job_num);
                        $('[data-inhtml="modal_job_follow"] input[type="button"]').prop('value', ' - 관심 직업 해제');
                    }
                }
                $('#modal_job').show();
            }
        }
    });
}

function popup_mentor(mentor_num) {
    var form_data = {
        need: 'popup_mentor',
        uid: mentor_num
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=getData",
        data: form_data,
        success: function(response) {
            var results = $.parseJSON(response);
            var datas = results.result;
            if (results.code == '100') {
                // 로딩으로 우선 변경
                $('[data-inhtml="modal_mentor_video"]').html("");
                $('[data-inhtml="modal_mentor_nameline"]').html("Loading");
                $('[data-inhtml="modal_mentor_intro"]').html("Loading");
                $('[data-inhtml="modal_mentor_career"]').html("Loading");
                $('[data-inhtml="modal_mentor_fanbtn_follow"]').prop('href', '/?r=home&m=member&a=friend_follow&mode=mblog&fuid=&mbruid=' + mentor_num);
                $('[data-inhtml="modal_mentor_fanbtn_unfollow"]').prop('href', '/?r=home&m=member&a=friend_unfollow&mode=mini&fuid=' + datas.fuid + '&mbruid=' + mentor_num);
                $('[data-inhtml="modal_mentor_moreinfo"]').prop('href', '/mblog/?mentor=' + mentor_num);
                $('[data-mentornum]').val(mentor_num);
                // 사진 변경
                if (datas.pic) {
                    $('[data-inhtml="modal_mentor_pic"]').css('background', 'url(\'/_var/simbol/' + datas.pic + '\') top center no-repeat');
                    $('[data-inhtml="modal_mentor_pic"]').css('background-size', 'cover');
                } else {
                    $('[data-inhtml="modal_mentor_pic"]').css('background', 'url(\'/_var/simbol/default.jpg\') top center no-repeat');
                    $('[data-inhtml="modal_mentor_pic"]').css('background-size', 'cover');
                }

                // 데이터 삽입
                $('[data-inhtml="modal_mentor_nameline"]').html(datas.nameline);

                if(datas.i_video) $('[data-inhtml="modal_mentor_video"]').html('<iframe width="100%" height="240" src="http://play.smartucc.kr/player.php?origin='+datas.i_video+'" frameborder="0" allowfullscreen></iframe>');

                // 팬 버튼
                if (datas.fanmode == "Y") {
                    $('[data-inhtml="modal_mentor_fanbtn"]').addClass('active');
                    $('[data-inhtml="modal_mentor_fanbtn"]').removeClass('me');
                } else if (datas.fanmode == "N") {
                    $('[data-inhtml="modal_mentor_fanbtn"]').removeClass('active');
                    $('[data-inhtml="modal_mentor_fanbtn"]').removeClass('me');
                } else if (datas.fanmode == "me") {
                    $('[data-inhtml="modal_mentor_fanbtn"]').removeClass('active');
                    $('[data-inhtml="modal_mentor_fanbtn"]').addClass('me');
                }


                $('[data-inhtml="modal_mentor_intro"]').html(datas.intro);
                $('[data-inhtml="modal_mentor_career"]').html(datas.career);

                $('#modal_mentor').show();
            }
        }
    });
}

/* 아이폰 대응 모달 클로져 */

function modal_opener(what){
    $('#' + what).show();
}
function modal_closer(what){
    $('#' + what).hide();
}

function list_shower(myobj, target){
    var hider = $(target).css('display');
    if (hider == 'none') {
        $(target).slideDown();
        $(myobj).addClass('active');
    } else {
        $(target).slideUp();
        $(myobj).removeClass('active');
    }
}

/* 아이폰 대응 끝 */



function more_icons_inpopup(need,indexs,obj,mode,keyword,category){
        var form_data = {
            need: need,
            obj: obj,
            index: indexs,
            mode: mode,
            keyword: keyword,
            category: category,
            limits: '15',
            selecter : 'Y'
        };
        $.ajax({
            type: "POST",
            url: "/?r=home&m=dalkkum&a=getData",
            data: form_data,
            success: function(response) {
                var results = $.parseJSON(response);
                console.log(results);
                    if(results.code=='100') {
                        if(mode=='my') $('.'+obj+'.more').remove();
                        $('[data-inhtml="'+obj+'"]').append(results.inhtml);

                    }
                    if(results.num != 15) {
                        $('[data-more="'+obj+'"]').remove();
                    }else{
                        var morebtn = '<span class="icon d_job_more btn" data-more="'+obj+'" onclick="more_icons_inpopup(\''+need+'\',\''+(parseInt(indexs)+parseInt(results.num))+'\',\''+obj+'\',\''+mode+'\',\''+keyword+'\',\''+category+'\');"></span>';
                        $('[data-more="'+obj+'"]').remove();
                        $('[data-inhtml="'+obj+'"]').append(morebtn);
                    }
                nowLoading = false;
            }
        });
}

// 라이브러리 이후 실행될 것
function inMyLibAfter(code, target){
    //console.log(code);
    //console.log(target);
}
// 나의 라이브러리에 추가 취소
function inMyLib(option,option2,guid,target){
    var form_data = {
        act: 'libin',
        option: option+'_'+option2,
        guid: guid
    };
    $.ajax({
        type: "POST",
        url: "/?r=home&m=dalkkum&a=etcAction",
        data: form_data,
        success: function(response) {
            var results = $.parseJSON(response);
                console.log(results);
                if(results.code=='101') {
                    $('[data-'+target+'="'+guid+'"]').addClass("except");
                    $('[data-'+target+'="'+guid+'"]').removeClass("adder");
                    $('[data-'+target+'="'+guid+'"]').val("제외");
                    $('[data-'+target+'="'+guid+'"]').attr("onclick","inMyLib('"+option+"','out',"+guid+",'"+target+"');");
                } else if(results.code=='102') {
                    $('[data-'+target+'="'+guid+'"]').removeClass("except");
                    $('[data-'+target+'="'+guid+'"]').addClass("adder");
                    $('[data-'+target+'="'+guid+'"]').val("추가");
                    $('[data-'+target+'="'+guid+'"]').attr("onclick","inMyLib('"+option+"','in',"+guid+",'"+target+"');");
                }
                if(results.msg) alert(results.msg);
                inMyLibAfter(results.code, $('[data-'+target+'="'+guid+'"]'));
        }
    });
}



$(document).mouseup(function(e) {
    var container2 = $("#d_drawer.show, #apply_popup_wrap");
    if (container2.has(e.target).length == 0) { 
        container2.removeClass('show');
        if($('body').hasClass('mheader')) hybrid_menubar('hide'); 
         else hybrid_menubar('show');
    }
});

$(document).mousedown(function(e) {
    $('.modal_bg > div').each(function() {
        if ($(this).parent().css('display') == 'block') {
            var l_position = $(this).offset();
            l_position.right = parseInt(l_position.left) + ($(this).width());
            l_position.bottom = parseInt(l_position.top) + parseInt($(this).height());

            if ((l_position.left <= e.pageX && e.pageX <= l_position.right) &&
                (l_position.top <= e.pageY && e.pageY <= l_position.bottom)) {
                //alert( 'popup in click' );
            } else {
                $(this).parent().hide();
            }
        }
    });
});

// ul 멘토 및 직업 중앙 정렬
function ULresizer(obj) {
    if (obj.length > 0) {
        var list_width = 105;
        var outerWidth = $(window).outerWidth() - 40;
        var resultWidth = Math.floor(outerWidth / list_width);
        var maxli = obj.children('li').length;
        if (resultWidth > maxli) resultWidth = maxli;
        obj.css('width',(list_width * resultWidth)+'px');
    }

}
function all_reUL(){
    if($('ul[data-inhtml="allJobList"]')) ULresizer($('ul[data-inhtml="allJobList"]'));
    if($('ul[data-inhtml="allMentorList"]')) ULresizer($('ul[data-inhtml="allMentorList"]'));
    if($('ul[data-inhtml="myJobList"]')) ULresizer($('ul[data-inhtml="myJobList"]'));
    if($('ul[data-inhtml="myMentorList"]')) ULresizer($('ul[data-inhtml="myMentorList"]'));
    if($('ul[data-inhtml="explorerJobList"]')) ULresizer($('ul[data-inhtml="explorerJobList"]'));
    if($('ul[data-inhtml="explorerMentorList"]')) ULresizer($('ul[data-inhtml="explorerMentorList"]'));
}
$(function(){   // 이미지 Lazy 처리
    //$('img').Lazy();

    scroll_changing();

    $(window).scroll(function() {
        scroll_changing();
    });

    $(window).resize(function() {
        all_reUL();
    });

    all_reUL();


    // 나의 관심 무한 스크롤
    $('#allMentorListContent, #allJobListContent').scroll(function(){
        if ($(this).innerHeight() + $(this).scrollTop() + 100 >=  $(this).find('ul').outerHeight() && !nowLoading) {
            $(this).find('span[data-more]').click(); nowLoading =  true;
        }

    });
    
});

