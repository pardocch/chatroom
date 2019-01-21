<?php 
$map = array();

// 建立 websocket 物件，監聽 0.0.0.0:9501 連接埠
$ws = new swoole_websocket_server("0.0.0.0", 9501); // 0.0.0.0 等於 localhost
 
// 監聽 WebSocket 連接打開事件
$ws->on('open', function (swoole_websocket_server $ws, $request) {
	file_put_contents( __DIR__ .'/log.txt' , $request->fd);
});
 
// 監聽 WebSocket 訊息事件
$ws->on('message', function (swoole_websocket_server $ws, $frame) {
	global $client;
	var_dump($frame->data);
	$data = json_decode($frame->data, true);
	$m = file_get_contents( __DIR__ .'/log.txt');
	switch ($data['type']) {
		case 'connect':
			// print_r($data);
			break;
		case 'message':
			// print_r($data);
			for ($i=1; $i <= $m; $i++) { 
				if ($ws->exist($i) && $frame->fd !== $i) {
					// echo PHP_EOL.' i is '.$i.' data is '.$data['message'].' m = '.$m;
					$ws->push($i, $data['message']);
				}
			}
			break;
		default:
			# code...
			break;
	}
});
 
// 今天 WebSocket 連接關閉事件
$ws->on('close', function ($ws, $fd) {
    echo PHP_EOL."client-{$fd} is closed\n";
});
 
$ws->start();