/**
 * game公共的js库
 * void 0替代undefined
 * 放大模式实现对象的方法和属性注入，实现动态挂载
 * author: heige
 * time: 2017-01-05
 */
(function(mod, win, doc) {
    //浏览器对象
    var browser = {
        versions: function() {
            var u = navigator.userAgent;
            return {
                trident: u.indexOf("Trident") > -1,
                presto: u.indexOf("Presto") > -1,
                webKit: u.indexOf("AppleWebKit") > -1,
                gecko: u.indexOf("Gecko") > -1 && -1 == u.indexOf("KHTML"),
                mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/),
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) || !!u.match(/iphone|ipod|ipad|Mac/gi),
                android: u.indexOf("Android") > -1 || !!u.match(/Android|Adr|Linux/gi),
                iPhone: u.indexOf("iPhone") > -1 || u.indexOf("Mac") > -1,
                iPad: u.indexOf("iPad") > -1,
                iPod: "ipod" == u.match(/iPod/i),
                webApp: -1 == u.indexOf("Safari"),
                isweixin: "micromessenger" == u.match(/MicroMessenger/i),
                ua: u
            }
        }()
    };

    //获取手机设备类型
    function getDeviceSystem() {
        var system = "android";
        if (browser.versions.ios || browser.versions.iPhone || browser.versions.iPad || browser.versions.iPod) {
            system = 'ios';
        }

        return system;
    };

    //获取ios系统版本
    function getIosVersion() {
        var version, verinfo = browser.versions.ua.match(/os [\d._]*/gi);
        if (null != verinfo && verinfo.length > 0) {
            version = verinfo.toString().replace(/[^0-9|_.]/gi, "").replace(/_/gi, ".");
        }

        return void 0 !== version && version.length > 0 ? version : "";
    };

    //微信中a--->b,从b返回a页面，需要执行Futuregames.initWxPage(title,url);
    //该段js放在b页面
    //用法如下：
    /*
     //a--->b,b--->a
     Futuregames.initWxPage(title,a_url);

     //a--->b,b---->c
     Futuregames.pushHistory(title,page_a_url);
     Futuregames.closeWxPage("http://www.baidu.com");
     */
    var obj = {
        pushHistory: function(title, page_a_url) {
            var state = {
                title: title || doc.title,
                url: page_a_url || location.href,
            };
            win.history.pushState(state, state.title, state.url);
        },
        closeWxPage: function(url) {
            win.addEventListener("popstate", function(e) { //回调函数中实现需要的功能
                if (typeof wx != "undefined" && typeof wx.closeWindow == 'function') {
                    wx.closeWindow();
                }

                location.href = url || location.host; //在这里指定其返回的地址
            }, false);
            return false;
        },
        //weixin初始化返回或关闭操作
        initWxPage: function(title, page_a_url) { //本游戏中page_a_url 为/
            return false;
            var iosVersion = getIosVersion().replace(/\./g, "");
            var system = getDeviceSystem();
            // ios 9.0.0以下的系统不调用微信初始化
            if ("ios" == system && "" != iosVersion && parseFloat(iosVersion) < 900) {
                return false;
            }

            this.pushHistory(title || (doc.title || ''), page_a_url || '/');
            this.closeWxPage(page_a_url || '/');
        },
    };

    //对外暴露的方法
    mod.browser = browser;
    mod.getDeviceSystem = getDeviceSystem;
    mod.getIosVersion = getIosVersion;
    mod.pushHistory = obj.pushHistory;
    mod.closeWxPage = obj.closeWxPage;
    mod.initWxPage = obj.initWxPage;

})(window.Futuregames = window.Futuregames || {}, window, document);

var glboldataxx = [];


function opnemm(html, id) {
    if (!glboldataxx[id + html]) {
        $.get('/index.php/portal/index/' + html + '/room/' + room, function(data) {
            glboldataxx[id + html] = data;
            $('#' + id).html(data);
            $('#' + id).show();
            $('#scroll-box2').hide(); 
            $('.yuyinButton').addClass('yuyinButtonImg');  
        });
    
    } else {
        if (id != 'message') {
            console.log(glboldataxx[id + html]);
            //$('#' + id).html(glboldataxx[id + html]);
        }

        $('#' + id).show();
    }
}

function emojiButton() {
    $('#scroll-box').hide(); 
    $('#scroll-box2').show(); 
    $('.emojiButton').addClass('emojiButtonImg');  
    $('.yuyinButton').removeClass('yuyinButtonImg');
   }

   function yuyinButton() {
    $('#scroll-box2').hide(); 
    $('#scroll-box').show();  
    $('.yuyinButton').addClass('yuyinButtonImg');   
    $('.emojiButton').removeClass('emojiButtonImg');  
   }

   
function selectChange(type, id, index) {
    glboldataxx[mb][type] = index;
    $('.' + type).find('img').hide();
    $('#' + id).find('img').show();
}

function selectChanges(type, id, index) {
    glboldataxx[mb][type] = index;
    if ($('#' + id).children('img').css('display') == 'block') {
        $('#' + id).children('img').hide();
    } else {
        $('#' + id).children('img').show();
    }
}

function zhengzkf() {
    alert('敬请期待');
}

function cancelCreate() {
    $('#room').hide();
}
//addfunction
function eagddd366() {
    $('#dagf3dee').hide();
}

// 选择房间
function selectBankerMode(index, id) {
    glboldataxx[mb][index] = index;
    $(".bankerUnSelected").find('img').attr('src', './img/banker_unselected.png')
    $('.selectPart').eq(2).hide();
    $('.selectPart').eq(6).hide();
    $('.selectPart').eq(1).show();

    if (index == 1) {
        $('#' + id).find('img').attr('src', './img/banker_selected.png')
    }
    if (index == 2) {
        $('#' + id).find('img').attr('src', './img/banker_selected.png')
        $('.selectPart').eq(6).show();
    }
    if (index == 3) {
        $('#' + id).find('img').attr('src', './img/banker_selected.png')
    }
    if (index == 4) {
        $('#' + id).find('img').attr('src', './img/banker_selected.png')
    }
    if (index == 5) {
        $('#' + id).find('img').attr('src', './img/banker_selected.png')
        $('.selectPart').eq(2).show();
        $('.selectPart').eq(1).hide();
    }
}

//addfunction
function eee366() {
    $('#ssa').hide();
}

function shoujibd() {
    $('#validePhone').show();
}

function alertgl() {
    $('#valert').show();
}

function alertqx() {
    $('#valert').hide();
}
//功能管理  页面
function guanlign() {
    window.location.href = '../gongnsm.html';
}

//个人中心    积分
$(function() {

    $('.daoluan').on('click', function() {
        $('.gameListItem').css('z-index', '99');
        $(this).siblings().css('z-index', '9999');
    })

    $('.phoneMask').on('click', function() {
        $('#validePhone').hide();
    })

})
// 红包旋转功能
function xuanzhuan() {

    $('.btnOpen').find('img').addClass('transf')

    setTimeout(function() {

        $('#ropen').show();

    }, 1000);
}

// 公共弹框
function public(data) {
    $('#' + data).hide();
}
// 快捷语音
function sendmsg(msg, id) {
    send('sendmsg', {
        msg: msg,
        id: id
    });
    $('#message').hide();
}

function sendemoji(msg, id) {
    send('sendemoji', {
        msg: msg,
        id: id
    });
    $('#message').hide();
}


var ji;

function djs(sj) {
    clearTimeout(ji);
    var now = sj - Math.ceil(new Date() / 1000) - (0 - timewc) - 1;
    if (now > 0) {
        // if(now<=3){
        //   mp3play('mp3daojishi');
        // }
        ji = setTimeout('djs(' + sj + ')', 1000);
        $('.clock').show();
        $('#divRobBankerText').show();
        $('#djs').text(now);
    } else {
        cleardjs();
    }
}

function cleardjs() {
    clearTimeout(ji);
    $('.clock').hide()
    $('#divRobBankerText').hide();
    $('.gongg').hide();
}

/**
 * 无用代码以下是
 */
//==========================开市
function testxxyx() {
    return 'hahha';
}

function testhah() {
    return '1232';
}

//===========================结束
