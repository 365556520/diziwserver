<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chat Client</title>
</head>
<body>
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script>

    window.onload = function () {
        var nick = prompt("Enter your nickname");
        var input = document.getElementById("input");
        input.focus();

        // 初始化客户端套接字并建立连接
        var socket = new WebSocket("ws://server.diziw.cn/ws");
        // 连接建立时触发
        socket.onopen = function (event) {
            console.log(event);
        };

        // 接收到服务端推送时执行
        socket.onmessage = function (event) {
            console.log(event.data);
            var msg = event.data;
            var node = document.createTextNode(msg);
            var div = document.createElement("div");
            div.appendChild(node);
            document.body.insertBefore(div, input);
            input.scrollIntoView();
        };
        // 连接关闭时触发
        socket.onclose = function (event) {
            console.log("Connection closed ...");
        };
        input.onchange = function () {
            var msg = nick + ": " + input.value;
            // 将输入框变更信息通过 send 方法发送到服务器
            socket.send(msg);
            input.value = "";
        };
    }
</script>
<div>
    <input id="input" style="width: 100%;">
</div>

</body>
</html>
