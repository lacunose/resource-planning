<?php

namespace App;

use Str;
use Lacunose\Acl\Models\User as Model;
use Lacunose\Acl\Models\Access;

use Lacunose\Subscribe\Models\Plan;
use Laravel\Passport\HasApiTokens;

class User extends Model {
	use HasApiTokens;

    protected $appends  = [];

    /*
     * relationship has many chats
     */
    public function subs() {
        return $this->setConnection(config()->get('web.db.tacl'))->hasMany(Plan::class)->orderby('ended_at', 'asc');
    }
}
