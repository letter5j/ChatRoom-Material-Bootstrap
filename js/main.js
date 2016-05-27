var TIMER_INTERVAL = 1000;

$(document).ready(function () {

    $(window).load(function () {
        $('#checkModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#change_room').hide();
        setTimeout(timerFunc, TIMER_INTERVAL);
    });

    $("#send_btn").click(function () {
        $.ajax({
            url: 'send.php',
            type: 'POST',
            data: {
                nick: $('#user_nick').val(),
                room_code: $('#room_code').val(),
                content: $('#content').val()
            }
        });

        $('#content').val("");
    });

    // 剛進入跳出視窗後送出的動作
    $("#input_submit").click(function () {
        $('#textNick').text($('#user_nick').val());
        if ($('#room_code').val() != "") {
            changeRoom(false);
        } else {
            changeRoom(true);
        }
        $('#checkModal').modal('hide');
    });

    // 送出房號
    $("#newroom_submit").click(function () {
        if ($('#newroom_code').val() != "") {
            $('#room_code').val($('#newroom_code').val());
            changeRoom(false);
        } else {
            
            $("#check_room").prop("checked" , "true");

            changeRoom(true);
        }
        $('#change_room').hide();
    });

    // 改變是否使用房號開關
    $("#check_room").change(function () {
        if ($(this).is(":checked")) {
            changeRoom(true);
            $('#change_room').hide();
            return;
        }
        $('#change_room').show();
        $('#newroom_code').val("").focus();
    });
});

function timerFunc() {

    $.ajax({
        url: "update.php",
        type: "POST",
        data: {
            room_code: $('#room_code').val(),
            tid: $('#tid').val()
        },
        dataType: "json",
        success: function (JData) {

            var NumOfJData = JData.length;
            for (var i = 0; i < NumOfJData; i++) {
                $('#chatRoom').append("<div class=\"well well-md messageBoxContainer\">" +
                    "<div class=\"row messageBox\">" +
                    "<div class=\"col-sm-10 col-md-10 col-lg-10\">" +
                    "<div class=\"message_username\">" + JData[i]["nick"] + " (IP:" + JData[i]["ip"] + ")</div>" +
                    "<div class=\"message_text\">" + JData[i]["content"] + "</div>" +
                    "</div>" +
                    "<div class=\"col-sm-2 col-md-2 col-lg-2\">" +
                    "<div class=\"message_sent pull-right\">" +
                    "<i class=\"material-icons\">alarm</i> " + JData[i]["timestamp"] +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>");

                $('#tid').val(JData[i]["tid"]);

            }
			if(NumOfJData > 0)	$('#chatRoom').animate({scrollTop: $('#chatRoom').prop("scrollHeight")}, 500);
            
        },
        error: function () {
            //alert("ERROR!!!");
        }
    });

    setTimeout(timerFunc, TIMER_INTERVAL);
}

function changeRoom(public) {
    $('#tid').val("0");
    $('#chatRoom').html("");
    if (public) {
        $('#textRoomCode').text("PUBLIC ROOM");
        $('#room_code').val("");
        $("#check_roomText").text("是");
        $("#roomStatus").text("Public");
    } else {
        $('#textRoomCode').text($('#room_code').val());
        //$("#check_room").removeAttr("checked");
        $("#check_room").prop('checked',false);
        $("#check_roomText").text("否");
        $("#roomStatus").text("Private");

    }
}