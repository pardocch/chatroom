<!-- welcome.blade.php -->

<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <title>Laravel</title>
    <style>
        .chat-contain-field {
            text-align: center;
        }
        .chat-contain-field-border {
            border: 1px solid #9d9d9d;
            max-height: 80vh;
            min-height: 80vh;
            background-color: #f0f0f0;
            padding: 10px 10px;
            overflow-y: scroll;
        }
        /* first */
        .chat-block {
            clear: both;
        }
        /* 其他人的留言 */
        .cf {
            border-bottom-right-radius: 1.3em;
            border-top-right-radius: 1.3em;
            border-bottom-left-radius: 1.3em;
            border-top-left-radius: 1.3em;
            max-width: 50%;
            margin-bottom: 5px;
            background-color: #5a6268;
            color: white;
        }
        .ct {
            text-align: left;
            padding: 10px 30px;
        }
        /* 自己的留言 */
        .mf {
            float: right;
            border-bottom-right-radius: 1.3em;
            border-top-right-radius: 1.3em;
            border-bottom-left-radius: 1.3em;
            border-top-left-radius: 1.3em;
            max-width: 50%;
            margin-bottom: 5px;
            background-color: #2779bd;
            color: white;
        }
        .mt {
            text-align: right;
            padding: 10px 30px;
        }
        /*發送欄*/
        .chat-text-field {
            margin-top: -1px;
            text-align: center;
        }
        .chat-text-box {
            width: 100%;
            resize: none;
        }
        #sendbtn {
            display: inline-block;
        }
        /*工具欄*/
        .chat-toolbar-field {
            text-align: right;
            border: 1px solid #9d9d9d;
            margin-top: -10px;
            padding: 10px 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>chatroom demo</h1>
        <div class="chat-contain-field">
            <div class="chat-contain-field-border">
            </div>
        </div>
        <div class="chat-text-field">
            {{--<input type="text" id="content">--}}
            <textarea class="chat-text-box" id="content" cols="30" rows="3"></textarea>
        </div>
        <div class="chat-toolbar-field">
            <button class="btn btn-primary" id="sendbtn" onclick="send()">send</button>
        </div>
    </div>
</body>
<script>
    let room_id = '';
    let user_id = '';

    // let wsServer = 'ws://127.0.0.1:9501';
    // let wsServer = 'ws://192.168.0.126:9501';
    let wsServer = 'ws://3b9fb9c2.ngrok.io'
    let websocket = new WebSocket(wsServer);
    websocket.onopen = function (evt) {
        console.log("成功連接到 WebSocket 服務");
        let data = {
            room_id: room_id,
            user_id: user_id,
            type: 'connect'
        };
        websocket.send(JSON.stringify(data));
    };

    websocket.onclose = function (evt) {
        console.log("關閉連接服務");
    };

    websocket.onmessage = function (evt) {
        console.log('接收伺服器數據: ' + evt.data);
        appendMessage( evt.data , 'other');
    };

    websocket.onerror = function (evt, e) {
        console.log('發生錯誤: ' + evt.data);
    };

    function send() {
        let content = document.getElementById('content');
        let data = {
            message: content.value,
            room_id: room_id,
            user_id: user_id,
            type: 'message'
        };
        // websocket.send( content.value );
        websocket.send( JSON.stringify(data) );
        appendMessage( content.value , 'self');
        content.value = '';
    }
    function appendMessage(message, target) {
        let group = document.querySelector('.chat-contain-field-border');
        let newChatBlock = document.createElement("div");
        newChatBlock.className = "chat-block";
        message = message.replace(/\n/g,'<br />');
        switch (target) {
            case 'self':
                    group.appendChild(newChatBlock);
                let newMf = document.createElement("div");
                    newMf.className = "col-md-offset-6 col-md-6 mf";
                    newChatBlock.appendChild(newMf);
                let newMt = document.createElement("div");
                    newMt.className = "mt";
                    newMt.innerHTML = message;
                ;
                    newMf.appendChild(newMt);
                break;
            default:
                group.appendChild(newChatBlock);
                let newCf = document.createElement("div");
                newCf.className = "cf";
                newChatBlock.appendChild(newCf);
                let newCt = document.createElement("div");
                newCt.className = "ct";
                newCt.innerHTML = message;
                newCf.appendChild(newCt);
                break;
        }
    }
    document.addEventListener('keydown', (e) => {
        if (e.which == 13) {
            e.preventDefault();
            if (e.shiftKey == 1) {
                document.getElementById('content').value += '\r\n';
            } else {
                send();
            }
        }
    });
</script>
</html>