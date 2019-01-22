<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Room;

class RoomController extends Controller
{
	public function index() 
	{
        // $userArray = array();

        // $userList = Redis::keys('user:profile:*');
        // $countuserList = count($userList);

        // for ($i=0; $i < $countuserList; $i++){
        //     $userArray['user:profile:'.$i] = Redis::get('user:profile:'.$i);
        // }

        // return $userArray;

        $allroom = Redis::smembers('room');

        return $allroom;
	}

    public function room($id=0) 
    {
        // $user = Redis::get('user:profile:'.$id);
        
        // return $user;

        return view('Welcome');
    }

    public function createPage()
    {
        return view('room.create');
    }

    public function create(Request $request)
    {
        $roomid = md5(microtime());
        $roomname = $request->input('firstname');
        $roomObj = new \stdClass;
        $roomObj->roomid = $roomid;
        $roomObj->roomname = $roomname;
        Redis::sadd('room', json_encode($roomObj, JSON_UNESCAPED_SLASHES));
    }

    /**
     * test
     */
    public function test()
    {
        return view('socket');
    }

    public function leave()
    {
        // return view('socket');
        phpinfo();
    }
}
