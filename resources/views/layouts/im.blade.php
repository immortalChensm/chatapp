
<script src="{{asset("H5/js/lib/jquery/jquery.js")}}" type="text/javascript"></script>
<script src="{{asset("H5/js/lib/jquery/jquery-ui.js")}}" type="text/javascript"></script>
<script src="{{asset("H5/js/lib/lodash.min.js")}}" type="text/javascript"></script>
<script src="{{asset("H5/js/lib/bootstrap/bootstrap.js")}}" type="text/javascript"></script>
<script src="{{asset("H5/js/lib/bootstrap/bootstrap-table.js")}}" type="text/javascript"></script>
<script src="{{asset("H5/js/lib/bootstrap/bootstrap-collapse.js")}}" type="text/javascript"></script>
<script src="{{asset("H5/js/lib/xss.js")}}" type="text/javascript"></script>

<!--TLS web sdk(只用于托管模式，独立模式不用引入)-->

<script src="https://tls.qcloud.com/libs/api.min.js" type="text/javascript"></script>
<!--用于获取文件MD5 js api(发送图片时用到)-->

<script src="{{asset("H5/js/lib/md5/spark-md5.js")}}" type="text/javascript"></script>
<!--web im sdk-->

<script src="{{asset("H5/sdk/webim.js")}}" type="text/javascript"></script>
<!--<script type="text/javascript" src="sdk/webim.min.js"></script>-->

<script src="{{asset("H5/sdk/json2.js")}}" type="text/javascript"></script>
<!--web im sdk 登录 示例代码-->

<script src="{{asset("H5/js/login/login.js")}}" type="text/javascript"></script>
<!--web im sdk 登出 示例代码-->

<script src="{{asset("H5/js/logout/logout.js")}}" type="text/javascript"></script>
<!--web im 解析一条消息 示例代码-->

<script src="{{asset("H5/js/common/show_one_msg.js")}}" type="text/javascript"></script>
<!--web im demo 基本逻辑-->

<script src="{{asset("H5/js/base.js")}}" type="text/javascript"></script>
<!--web im sdk 资料管理 api 示例代码-->

<script src="{{asset("H5/js/profile/profile_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 好友管理 api 示例代码-->

<script src="{{asset("H5/js/friend/friend_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 好友申请管理 api 示例代码-->

<script src="{{asset("H5/js/friend/friend_pendency_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 好友黑名单管理 api 示例代码-->

<script src="{{asset("H5/js/friend/friend_black_list_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 最近联系人 api 示例代码-->

<script src="{{asset("H5/js/recentcontact/recent_contact_list_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 群组管理 api 示例代码-->

<script src="{{asset("H5/js/group/group_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 群成员�����理 api 示例代码-->

<script src="{{asset("H5/js/group/group_member_manager.js")}}" type="text/javascript"></script>
<!--web im sdk 加群申请管理 api 示例代码-->

<script src="{{asset("H5/js/group/group_pendency_manager.js")}}" type="text/javascript"></script>
<!--web im 切换聊天好友或群组 示例代码-->

<script src="{{asset("H5/js/switch_chat_obj.js")}}" type="text/javascript"></script>
<!--web im sdk 获取c2c获取群组历史消息 示例代码-->

<script src="{{asset("H5/js/msg/get_history_msg.js")}}" type="text/javascript"></script>
<!--web im sdk 发送普通消息(文本和表情) api 示例代码-->

<script src="{{asset("H5/js/msg/send_common_msg.js")}}" type="text/javascript"></script>
<!--web im sdk 上传和发送图片消息 api 示例代码-->

<script src="{{asset("H5/js/msg/upload_and_send_pic_msg.js")}}" type="text/javascript"></script>
<!--web im sdk 上传和发送文件消息 api 示例代码-->

<script src="{{asset("H5/js/msg/upload_and_send_file_msg.js")}}" type="text/javascript"></script>
<!--web im sdk 切换播放语音消息 示例代码-->

<script src="{{asset("H5/js/msg/switch_play_sound_msg.js")}}" type="text/javascript"></script>
<!--web im sdk 发送自定义消息 api 示例代码-->

<script src="{{asset("H5/js/msg/send_custom_msg.js")}}" type="text/javascript"></script>
<!--web im sdk 发送群自定义通知 api 示例代码-->

<script src="{{asset("H5/js/msg/send_custom_group_notify_msg.js")}}" type="text/javascript"></script>
<!--web im 监听新消息(c2c或群) 示例代码-->

<script src="{{asset("H5/js/msg/receive_new_msg.js")}}" type="text/javascript"></script>
<!--web im 监听群系统通知消息 示例代码-->

<script src="{{asset("H5/js/msg/receive_group_system_msg.js")}}" type="text/javascript"></script>
<!--web im 监听好友系统通知消息 示例代码-->

<script src="{{asset("H5/js/msg/receive_friend_system_msg.js")}}" type="text/javascript"></script>
<!--web im 监听资料系统通知消息 示例代码-->

<script src="{{asset("H5/js/msg/receive_profile_system_msg.js")}}" type="text/javascript"></script>


<script src="{{asset("H5/js/lib/BenzAMRRecorder.js")}}" type="text/javascript"></script>
<!-- web im 让h5支持播放amr录音文件 -->

<script type="text/javascript">

    function resolveMsgSession(userMsg)
    {
        //var userMsg = (msgList[msgList.length-1]);
       // console.log(userMsg);
        var sessUserId = "#msgDiv_"+userMsg['sess']['_impl']['id'];
        var msgTime = formatMsgTimeStamp(userMsg.time);
        switch(userMsg['elems'][0]['type']){
            case "TIMTextElem":
                var expr = /\[[^[\]]{1,3}\]/mg;
                var msgContent = userMsg['elems'][0]['content']['text'];
                var emotions = userMsg['elems'][0]['content']['text'].match(expr);
                if (emotions) {
                    msgContent = '[表情]';
                }else{
                    msgContent = userMsg['elems'][0]['content']['text'].substr(0,5)+'...';
                }
                $(sessUserId).html(msgContent+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            case "TIMImageElem":
                $(sessUserId).html("[图片]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            case "TIMFileElem":
                $(sessUserId).html("[文件]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            case "TIMVideoFileElem":
                $(sessUserId).html("[视频]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            case "TIMSoundElem":
                $(sessUserId).html("[语音]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            case "TIMFaceElem":
                $(sessUserId).html("[表情]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            case "TIMLocationElem":
                $(sessUserId).html("[位置]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
            default:
                $(sessUserId).html("[消息]"+"<div class='msgTime'>"+msgTime+"</div>");
                break;
        }
    }
    function formatMsgTimeStamp(time){
        if (!time)
            return;
        //ar lastTime = sessionStorage.getItem('lastTimeLine');
        var msgTimeStamp = new Date(time * 1000);//历史信息毫秒时间戳
        var year = msgTimeStamp.getFullYear();
        var mou = msgTimeStamp.getMonth()+1;
        var day = msgTimeStamp.getDate();
        var hours = msgTimeStamp.getHours();
        var minutes = msgTimeStamp.getMinutes();
        var curTimeStamp = new Date();//当前毫秒时间戳
        var curYear = curTimeStamp.getFullYear();
        var curDate = (curTimeStamp.getMonth()+1) + curTimeStamp.getDate();//当前月份+天数
        var msgDate = mou + day;//历史消息月份+天数
        hours < 10 ? hours = '0' + hours : null;
        minutes < 10 ? minutes = '0' + minutes : null;
        day < 10 ? day = '0' + day : null;
        mou < 10 ? mou = '0' + mou : null;
        var newTime = '';
        var leadTime = curDate - msgDate;
        switch (leadTime) {
            case 0:
                newTime = hours + ':' +minutes ;
                break;
            case 1:
                newTime = '昨天 ' + hours + ':' +minutes ;
                break;
            case 2:
                newTime = '前天 ' + hours + ':' +minutes ;
                break;
            default:
                newTime = mou + '-' + day + ' ' + hours + ':' +minutes ;
                break;
        }
        if (curYear-year>1) {
            newTime = year + '-' + mou + '-' + day + ' ' + hours + ':' +minutes ;
        }
        return newTime;
    }

    function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
        }
        return(false);
    }

    function getCosFile(headurl,cbk)
    {
        $.ajax({
            url:"http://47.110.136.62:9501/api/cosfile/url",
            type:'GET',
            dataType:'json',
            //async:false,
            data:{
                fileKey:headurl
            },
            success:function (res) {
                if (res.result.code==1){
                    cbk(res.result.data);
                }
            }
        });
    }

    // 将以下两个参数替换成您的配置

    var sdkAppID = '1400195688'; // 填写第一步获取到的 sdkappid
    //var accountType = ''; // 填写第二步设置账号体系集成获取到的 accountType , 已废弃

    // 登录帐号
    var identifier = 'kefu', // 填写第三步输入的 identifier，由您指定，可以在登录页面直接输入


        // userSig = 'eJxNjl1PgzAYhf8LtxptgW7FxAvGII5Ny9xYZmLSdLTDNxsFoXMfxv8uTha9fZ5zTs6nNZ-MbkSWlTttuDlWyrqzkHV9xiCVNrAGVbcQk46KqgLJheFOLf*FG7nhZ-WTdRHCHulR2kl1qKBWXKxNt0WIjdCl*qHqBkrdChthgm0HoT9poFC-lT7FPdu93Gggb-FjmAajgY6Cw3j2TlUp*tXKX7JsG8N4Nw1zFl8JzFZMRGHwNpSuD6FfnAYvy-j1duGp5yR1NqPh9Jh7kUvn*wdvgSc6SZ72hU6BbdG99fUNnlpV3g__'; //填写第三步生成的userSig，可以在登录页面直接输入



        userSig = '{{session('imToken')}}';

    //帐号模式，0-表示独立模式，1-表示托管模式(托管模式已经停用，请使用独立模式集成帐号)
    var accountMode = 0;

    //当前用户身份
    var loginInfo = {
        'sdkAppID': sdkAppID, //用户所属应用id,必填
        // 'accountType': accountType, //用户所属应用帐号类型，必填 , 已废弃
        'identifier': identifier, //当前用户ID,必须是否字符串类型，必填
        'userSig': userSig,
        //当前用户身份凭证，必须是字符串类型，必填
        'identifierNick': null, //当前用户昵称，不用填写，登录接口会返回用户的昵称，如果没有设置，则返回用户的id
        'headurl': 'img/me.jpg' //当前用户默认头像，选填，如果设置过头像，则可以通过拉取个人资料接口来得到头像信息
    };

    var AdminAcount = 'admin';
    var selType = webim.SESSION_TYPE.C2C; //当前聊天类型
    var selToID = null; //当前选中聊天id（当聊天类型为私聊时，该值为好友帐号，否则为群号）
    var selSess = null; //当前聊天会话对象
    var recentSessMap = {}; //保存最近会话列表
    var reqRecentSessCount = 50; //每次请求的最近会话条数，业务可以自定义

    var isPeerRead = 1; //是否需要支持APP端已读回执的功能,默认为0。是：1，否：0。

    //默认好友头像
    var friendHeadUrl = "{{asset("H5/img/friend.jpg")}}"; //仅demo使用，用于没有设置过头像的好友
    //默认群头像
    var groupHeadUrl = 'img/group.jpg'; //仅demo使用，用于没有设置过群头像的情况


    //存放c2c或者群信息（c2c用户：c2c用户id，昵称，头像；群：群id，群名称，群头像）
    var infoMap = {}; //初始化时，可以先拉取我的好友和我的群组信息


    var maxNameLen = 12; //我的好友或群组列表中名称显示最大长度，仅demo用得到
    var reqMsgCount = 15; //每次请求的历史消息(c2c获取群)条数，仅demo用得到

    var pageSize = 15; //表格的每页条数，bootstrap table 分页时用到
    var totalCount = 200; //每次接口请求的条数，bootstrap table 分页时用到

    var emotionFlag = false; //是否打开过表情选择框

    var curPlayAudio = null; //当前正在播放的audio对象

    var getPrePageC2CHistroyMsgInfoMap = {}; //保留下一次拉取好友历史消息的信息
    var getPrePageGroupHistroyMsgInfoMap = {}; //保留下一次拉取群历史消息的信息

    var defaultSelGroupId = null; //登录默认选中的群id，选填，仅demo用得到

    //监听（多终端同步）群系统消息方法，方法都定义在receive_group_system_msg.js文件中
    //注意每个数字代表的含义，比如，
    //1表示监听申请加群消息，2表示监听申请加群被同意消息，3表示监听申请加群被拒绝消息
    var onGroupSystemNotifys = {
        "1": onApplyJoinGroupRequestNotify, //申请加群请求（只有管理员会收到）
        "2": onApplyJoinGroupAcceptNotify, //申请加群被同意（只有申请人能够收到）
        "3": onApplyJoinGroupRefuseNotify, //申请加群被拒绝（只有申请人能够收到）
        "4": onKickedGroupNotify, //被管理员踢出群(只有被踢者接收到)
        "5": onDestoryGroupNotify, //群被解散(全员接收)
        "6": onCreateGroupNotify, //创建群(创建者接收)
        "7": onInvitedJoinGroupNotify, //邀请加群(被邀请者接收)
        "8": onQuitGroupNotify, //主动退群(主动退出者接收)
        "9": onSetedGroupAdminNotify, //设置管理员(被设置者接收)
        "10": onCanceledGroupAdminNotify, //取消管理员(被取消者接收)
        "11": onRevokeGroupNotify, //群已被回收(全员接收)
        "15": onReadedSyncGroupNotify, //群消息已读同步通知
        "255": onCustomGroupNotify, //用户自定义通知(默认全员接收)
        "12": onInvitedJoinGroupNotifyRequest //邀请加群(被邀请者接收,接收者需要同意)
    };

    //监听好友系统通知函数对象，方法都定义在receive_friend_system_msg.js文件中
    var onFriendSystemNotifys = {
        "1": onFriendAddNotify, //好友表增加
        "2": onFriendDeleteNotify, //好友表删除
        "3": onPendencyAddNotify, //未决增加
        "4": onPendencyDeleteNotify, //未决删除
        "5": onBlackListAddNotify, //黑名单增加
        "6": onBlackListDeleteNotify //黑名单删除
    };

    var onC2cEventNotifys = {
        "92": onMsgReadedNotify, //消息已读通知,
        "96": onMultipleDeviceKickedOut
    };

    //监听资料系统通知函数对象，方法都定义在receive_profile_system_msg.js文件中
    var onProfileSystemNotifys = {
        "1": onProfileModifyNotify //资料修改
    };

    //监听连接状态回调变化事件
    var onConnNotify = function (resp) {
        var info;
        switch (resp.ErrorCode) {
            case webim.CONNECTION_STATUS.ON:
                webim.Log.warn('建立连接成功: ' + resp.ErrorInfo);
                break;
            case webim.CONNECTION_STATUS.OFF:
                info = '连接已断开，无法收到新消息，请检查下你的网络是否正常: ' + resp.ErrorInfo;
                // alert(info);
                webim.Log.warn(info);
                break;
            case webim.CONNECTION_STATUS.RECONNECT:
                info = '连接状态恢复正常: ' + resp.ErrorInfo;
                // alert(info);
                webim.Log.warn(info);
                break;
            default:
                webim.Log.error('未知连接状态: =' + resp.ErrorInfo);
                break;
        }
    };

    //IE9(含)以下浏览器用到的jsonp回调函数
    function jsonpCallback(rspData) {
        webim.setJsonpLastRspData(rspData);
    }

    //监听事件
    var listeners = {
        "onConnNotify": onConnNotify //监听连接状态回调变化事件,必填
        ,
        "jsonpCallback": jsonpCallback //IE9(含)以下浏览器用到的jsonp回调函数，
        ,
        "onMsgNotify": onMsgNotify //监听新消息(私聊，普通群(非直播聊天室)消息，全员推送消息)事件，必填
        ,
        "onBigGroupMsgNotify": onBigGroupMsgNotify //监听新消息(直播聊天室)事件，直播场景下必填
        ,
        "onGroupSystemNotifys": onGroupSystemNotifys //监听（多终端同步）群系统消息事件，如果不需要监听，可不填
        ,
        "onGroupInfoChangeNotify": onGroupInfoChangeNotify //监听群资料变化事件，选填
        ,
        "onFriendSystemNotifys": onFriendSystemNotifys //监听好友系统通知事件，选填
        ,
        "onProfileSystemNotifys": onProfileSystemNotifys //监听资料系统（自己或好友）通知事件，选填
        ,
        "onKickedEventCall": onKickedEventCall //被其他登录实例踢下线
        ,
        "onC2cEventNotifys": onC2cEventNotifys //监听C2C系统消息通道
        ,
        "onAppliedDownloadUrl": onAppliedDownloadUrl //申请文件/音频下载地址的回调
        ,
        "onLongPullingNotify": function (data) {
            console.debug('onLongPullingNotify', data)
        }
    };

    var isAccessFormalEnv = true; //是否访问正式环境

    var isLogOn = false; //是否开启sdk在控制台打印日志

    //初始化时，其他对象，选填
    var options = {
        'isAccessFormalEnv': isAccessFormalEnv, //是否访问正式环境，默认访问正式，选填
        'isLogOn': isLogOn //是否开启控制台打印日志,默认开启，选填
    }



    //var msgflow = document.getElementsByClassName("msgflow")[0];
    var msgflow = $(".msgflow").eq(0);
    // var bindScrollHistoryEvent = {
    //     init: function () {
    //         msgflow.onscroll = function () {
    //             if (msgflow.scrollTop == 0) {
    //                 msgflow.scrollTop = 10;
    //                 if (selType == webim.SESSION_TYPE.C2C) {
    //                     getPrePageC2CHistoryMsgs();
    //                 } else {
    //                     getPrePageGroupHistoryMsgs();
    //                 }
    //
    //             }
    //         }
    //     },
    //     reset: function () {
    //         //msgflow.onscroll = null;
    //     }
    // };
    var bindScrollHistoryEvent = {
        init: function () {
            $(msgflow).scroll(function () {
                if (msgflow.scrollTop == 0) {
                    msgflow.scrollTop = 10;
                    if (selType == webim.SESSION_TYPE.C2C) {
                        getPrePageC2CHistoryMsgs();
                    } else {
                        getPrePageGroupHistoryMsgs();
                    }

                }
            })
        },
        reset: function () {
            msgflow.onscroll = null;
        }
    };


    // webimLogin();
    // $('#select_app_dialog').modal('show');
    //$('#login_dialog').modal('show');
    if (!userSig){
        window.close();
    }else{
        webim.login(
            loginInfo, listeners, options,
            function(resp) {
                loginInfo.identifierNick = resp.identifierNick; //设置当前用户昵称
                loginInfo.headurl = resp.headurl; //设置当前用户头像
                getCosFile(resp.headurl,function (url) {
                    loginInfo.headurl = url;
                });
                initDemoApp();
            },
            function(err) {
                alert(err.ErrorInfo);

            }
        );
    }

</script>