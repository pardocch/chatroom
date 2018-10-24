<?php

namespace App\Console\Commands;

use function foo\func;
use Illuminate\Console\Command;

class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');
        switch ($action) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'restart':
                $this->restart();
                break;
        }
//        $this->start();
    }
    private function start()
    {
        $ws = \swoole_websocket_server(config('swoole.host'), config('swoole.port'));
        $ws->on('open', function($ws, $request){
            var_dump($request->fd, $request->get, $request->server);
            $ws->push($request->fd, "Hello, Welcome\n");
        });

        $ws->on('message', function($ws, $frame){
            echo "Message: {$frame->data}\n";
            $ws->push($frame->fd, $frame->data);
        });

        $ws->on('close', function($ws, $fd){
            echo "Client-{$fd} is closed\n";
        });
        $ws->start();
    }

    private function stop()
    {
    }

    private function restart()
    {

    }
}
