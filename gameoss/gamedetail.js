/*设置底部导航*/
function initIndicator() {
    return '<div class="indicator"><div class="indicator-wrapper"><span class="indicator-spin"><div class="spinner-snake"></div></span></div></div>';
}
function initNav() {
    $("#get_recharge").on("click", function () {
        var url = "index.php?ac=gamerecharge";
        var html = $.trim($("#recharge-detail").html());
        if (html == "") {
            $("#recharge-detail").html(initIndicator());
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function (data) {
                    if (data.status == "success") {
                        $("#recharge-detail").html(data.msg);
                    } else {
                        pop_alert("", "", data.msg);
                        $(".alert_box p.close").hide();
                    }
                }
            });
        }
    })
    $("#get_record").on("click", function () {
        var url = "index.php?ac=gamerecord&gameId=" + gameId;
        var html = $.trim($("#record-detail").html());
        if (html == "") {
            $("#record-detail").html(initIndicator());
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function (data) {
                    if (data.status == "success") {
                        $("#record-detail").html(data.msg);
                    } else {
                        pop_alert("", "", data.msg);
                        $(".alert_box p.close").hide();
                    }
                }
            });
        }
    })
    $("#get_statistics").on("click", function () {
        var url = "index.php?ac=gamestatistics&gameId=" + gameId;
        var html = $.trim($("#statistics-detail").html());
        if (html == "") {
            get_statistics(url);
        }
    })

    $("#get_feedback").on("click", function () {
        var url = "index.php?ac=gamefeedback&gameId=" + gameId;
        var html = $.trim($("#feedback-detail").html());
        if (html == "") {
            get_feedback(url);
        }
    });


}

function get_statistics(url) {
    $("#statistics-detail").html(initIndicator());
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                $("#statistics-detail").html(data.msg);
                $(".innings_list a,#statistics-detail .btn-back").on("click", function () {
                    url = $(this).attr("href");
                    get_statistics(url);
                    return false;
                });
                submit_feedback();
            } else {
                pop_alert("", "", data.msg);
                $(".alert_box p.close").hide();
            }
        }
    });
}

function submit_feedback() {
    $("#feedbackForm").submit(function (e) {
        var message = $(this).find("#message").val();
        var name = $(this).find("#name").val();
        var telphone = $(this).find("#telphone").val();
        var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
        if (message == "") {
            pop_alert("tips", "", "请输入您要反馈的问题");
            return false;
        }
        if (name == "") {
            pop_alert("tips", "", "请输入您的姓名");
            return false;
        }
        if (telphone == "") {
            pop_alert("tips", "", "请输入您的手机号码");
            return false;
        } else if (!myreg.test(telphone)) {
            pop_alert("tips", "", "请输入有效的手机号码");
            return false;
        }
        
        var url = $(this).attr("action");
        var data = $(this).serialize();
        var btnsubmit = $("#btnsubmit").val();
        data = data + "&btnsubmit=" + btnsubmit;
        $.ajax({
            type: "post",
            url: url,
            data: data,
            dataType: "json",
            error: function (data) {
                alert("请重新进入");
            },
            success: function (data) {
                if (data.status == "success") {
                    $(".pop_bg").hide();
                    $(".aui-dialog").addClass("aui-hide").removeClass("show");
                    pop_alert("", "", data.msg);

                } else {
                    alert(data.msg);
                }
            }
        });
        return false;
    });
}
function get_feedback(url) {
    $("#feedback-detail").html(initIndicator());
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                $("#feedback-detail").html(data.msg);
                $(".feedback-header a").on("click", function () {
                    url = $(this).attr("href");
                    get_feedback(url);
                    return false;
                });
                submit_feedback();
            } else {
                pop_alert("", "", data.msg);
                $(".alert_box p.close").hide();
            }
            
        }
    });
};

/**
 * LBS drawRing 
 * Date: 2015-04-24
 * ==================================
 * opts.parent 插入到哪里 一个JS元素对象
 * opts.width 宽度 = 2* (半径+弧宽)  
 * opts.radius 半径
 * opts.arc 弧宽
 * opts.count 数量
 * opts.perent 百分比 
 * opts.color 弧渲染颜色 [底色,进度色]
 * opts.textColor 文字渲染颜色
 * opts.textSize 文字渲染大小
 * opts.animated 是否以动画的方式绘制 默认false
 * opts.after 绘制完成时执行函数
 * ==================================
 **/
 
function drawRing(opts) {
    var _opts = {
        parent: document.body,
        width: 100,
        radius: 45,
        arc: 5,
        count: 0,
        perent: 100,
        color: ['#ccc', '#042b61'],
        titleColor: '#c89c2c',
        textColor: '#000',
        textSize: '14px',
        animated: false,
        after: function () { }
    }, k;
    for (k in opts) _opts[k] = opts[k];

    var parent = _opts.parent,
        width = _opts.width,
        radius = _opts.radius,
        arc = _opts.arc,
        count = _opts.count,
        perent = parseFloat(_opts.perent),
        color = _opts.color,
        titleColor = _opts.titleColor,
        textSize = _opts.textSize,
        textColor = _opts.textColor,
        c = document.createElement('canvas'),
        ctx = null,
        x = perent,
        animated = _opts.animated,
        after = _opts.after;

    parent.appendChild(c);
    ctx = c.getContext("2d");
    ctx.canvas.width = width;
    ctx.canvas.height = width;

    function clearFill() {
        ctx.clearRect(0, 0, width, width);
    }

    function fillBG() {
        ctx.beginPath();
        ctx.lineWidth = arc;
        ctx.strokeStyle = color[0];
        ctx.arc(width / 2, width / 2, radius, 0, 2 * Math.PI);
        ctx.stroke();
    }

    function fillArc(x) {
        ctx.beginPath();
        ctx.lineWidth = arc;
        ctx.strokeStyle = color[1];
        ctx.arc(width / 2, width / 2, radius, -90 * Math.PI / 180, (x * 3.6 - 90) * Math.PI / 180);
        ctx.stroke();
    }

    function fillText(x) {
        ctx.font = textSize + ' Arial';
        ctx.textBaseline = "bottom";
        ctx.textAlign = 'center';
        ctx.fillStyle = titleColor;
        ctx.fillText('总牌局', width / 2, 1.2 * width / 4);
        ctx.fillText('胜率', width / 2, 2.8 * width / 4);
        ctx.fillStyle = textColor;
        ctx.fillText(count, width / 2, 1.8 * width / 4);
        ctx.fillText(x.toFixed(1) + '%', width / 2, 3.5 * width / 4);
    }

    function fill(x) {
        fillBG();
        fillArc(x);
        fillText(x);
    }

    if (!animated) return fill(perent);

    fill(x);
    !function animate() {
        if (++x > perent) return after && after();
        setTimeout(animate, 10);
        clearFill();
        fill(x);
    }();
}
$(document).ready(function () {
    initNav();

    $(".game-btn").bind("click", function() {
        var _this=$(this);
        $(_this).addClass("click");
        setTimeout(function() {
            $(_this).removeClass("click");
        }, 250)
    })
})