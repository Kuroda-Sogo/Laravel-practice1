<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Group extends Model
{
    #編集されるテーブル名を自分で決める(そうしないと自動で決まる)
    protected $table = 'groups';
    #割り当て許可で編集できる変数を指定
    protected $guarded = ['id'];  

    public function Users()
    {
        return $this->hasmany(User::class);
    }
}