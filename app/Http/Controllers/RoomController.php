<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Room;

class RoomController extends Controller
{
	public function index() 
	{
        $userArray = array();

        $userList = Redis::keys('user:profile:*');
        $countuserList = count($userList);

        for ($i=0; $i < $countuserList; $i++){
            $userArray['user:profile:'.$i] = Redis::get('user:profile:'.$i);
        }

        return $userArray;
		// return view('room/index', compact('userList'));
	}

    public function room($id=0) 
    {
        $user = Redis::get('user:profile:'.$id);
        return $user;
        // return view('room/create', compact('id'));
    }

    public function create(Request $request, $id=0)
    {
    	$input_value = $request->input('firstname');
    	echo $input_value;

    	Redis::set('user:profile:'.$id, $input_value);
    	return redirect()->action('RoomController@room', ['id' => $id]);
    }

    public function save()
    {
        
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
