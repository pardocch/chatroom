<?php
namespace App\Console\Commands;

use App\Room;
use App\User;
use Illuminate\Console\Command;
//use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Redis;

class Swoole1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swoole:action {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole command';

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Room
     */
    protected $room;

    /**
     * Swoole constructor.
     * @param Message $message
     * @param User $user
     * @param Roomjoin $room
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