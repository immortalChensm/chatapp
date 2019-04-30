
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css"/>
    <style>
        h1, h2 {
            font-weight: normal;
        }

        #msg {
            margin-top: 10px;
        }
    </style>
    <style>
        *{
            padding: 0px;
            margin:0px;
        }
        .File-Box{
            position: relative;
            width:150px;
            height:150px;
            margin: 30px auto;
        }
        .File-Box input[type=file]{
            cursor:pointer;
            width:100%;
            height:100%;
            z-index: 2;
            opacity:0;
            position: absolute;
        }
        .Show-Box{
            display: block;
            z-index: 1;
            width:100%;
            height:100%;
            position: absolute;
            background:#dfdfdf;
            border:1px solid #cccccc;
        }
        .Show-Box div{
            font-size: 80px;
            color: #999999;
            text-align: center;
        }
        .Show-Box span{
            display: block;
            font-size: 14px;
            text-align: center;
            color: #666666;
            width:100%;
            line-height: 15px;
        }
        .File-Box:hover .Show-Box div,.File-Box:hover .Show-Box span{
            color:#90c0f5;
        }

        * {box-sizing: border-box}

        .container {
            width: 80%;
            background-color: #fff;
            margin:0 auto;
        }

        .skills {
            text-align: right;
            padding-right: 20px;
            line-height: 30px;
            color: white;
            padding-left:0px;
        }

        .css {width: 0%; background-color: #2196F3;}


    </style>

</head>
<body>
<div class="File-Box">
    <input id="fileSelector" type="file" class="btn btn-primary">
    <div class="Show-Box">
        <div>+</div>
        <span>选择文件</span>
    </div>
</div>

<div class="container">
    <div class="skills css" id="msg"></div>
</div>

<script src="{{asset("cos/common/jquery-3.3.1.min.js")}}"></script>
<script src="{{asset("cos/common/cos-auth.min.js")}}"></script>
<script>
    (function () {
        // 请求用到的参数
        var Bucket = 'chatapp-1258883738';
        var Region = 'ap-chengdu';
        var protocol = location.protocol === 'https:' ? 'https:' : 'http:';
        var prefix = protocol + '//' + Bucket + '.cos.' + Region + '.myqcloud.com/';

        // 对更多字符编码的 url encode 格式
        var camSafeUrlEncode = function (str) {
            return encodeURIComponent(str)
                .replace(/!/g, '%21')
                .replace(/'/g, '%27')
                .replace(/\(/g, '%28')
                .replace(/\)/g, '%29')
                .replace(/\*/g, '%2A');
        };

        // 计算签名
        var getAuthorization = function (options, callback) {
            // var url = 'http://127.0.0.1:3000/sts-auth' +
            var url = "{{url('admin/js/upload/key')}}";
            var xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.onload = function (e) {
                var credentials;
                try {
                    credentials = (new Function('return ' + xhr.responseText))().credentials;
                } catch (e) {}
                if (credentials) {
                    callback(null, {
                        XCosSecurityToken: credentials.sessionToken,
                        Authorization: CosAuth({
                            SecretId: credentials.tmpSecretId,
                            SecretKey: credentials.tmpSecretKey,
                            Method: options.Method,
                            Pathname: options.Pathname,
                        })
                    });
                } else {
                    console.error(xhr.responseText);
                    callback('获取签名出错');
                }
            };
            xhr.onerror = function (e) {
                callback('获取签名出错');
            };
            xhr.send();
        };

        // 上传文件
        var uploadFile = function (file, callback) {
            var Key = 'other/' + file.name; // 这里指定上传目录和文件名
            getAuthorization({Method: 'PUT', Pathname: '/' + Key}, function (err, info) {

                if (err) {
                    alert(err);
                    return;
                }

                var auth = info.Authorization;
                var XCosSecurityToken = info.XCosSecurityToken;
                var url = prefix + camSafeUrlEncode(Key).replace(/%2F/, '/');
                var xhr = new XMLHttpRequest();
                xhr.open('PUT', url, true);
                xhr.setRequestHeader('Authorization', auth);
                XCosSecurityToken && xhr.setRequestHeader('x-cos-security-token', XCosSecurityToken);
                xhr.upload.onprogress = function (e) {
                    //console.log('上传进度 ' + (Math.round(e.loaded / e.total * 10000) / 100) + '%');
                    $("#msg").text((Math.round(e.loaded / e.total * 10000) / 100) + '%');
                    $("#msg").css("width",(Math.round(e.loaded / e.total * 10000) / 100)-20 + '%');


                };
                xhr.onload = function () {
                    if (xhr.status === 200 || xhr.status === 206) {
                        var ETag = xhr.getResponseHeader('etag');
                        callback(null, {url: url, ETag: ETag});
                    } else {
                        callback('文件 ' + Key + ' 上传失败，状态码：' + xhr.status);
                    }
                };
                xhr.onerror = function () {
                    callback('文件 ' + Key + ' 上传失败，请检查是否没配置 CORS 跨域规则');
                };
                xhr.send(file);
            });
        };

        // 监听表单提交
        document.getElementById('fileSelector').onchange = function (e) {
            var file = document.getElementById('fileSelector').files[0];
            if (!file) {
                document.getElementById('msg').innerText = '未选择上传文件';
                return;
            }

            file && uploadFile(file, function (err, data) {
                console.log(err || data);
                //document.getElementById('msg').innerText = err ? err : ('上传成功，ETag=' + data.ETag);
                //if ((Math.round(e.loaded / e.total * 10000) / 100) == 100){
                window.opener.document.getElementById("upload-image-view").innerHTML = data;
                //}
            });
        };
    })();
</script>

</body>
</html>