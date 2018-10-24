<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Room extends Model
{
    function insertToRedis() {
        return Redis::keys('user:profile:*');
    }
}
