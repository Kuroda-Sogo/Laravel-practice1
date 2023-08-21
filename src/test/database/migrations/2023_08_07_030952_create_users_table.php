<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Schemaファサードで posts テーブルの作成
      Schema::create('users', function (Blueprint $table) {
    
      // カラムを作成していく
      $table->increments('id');
      $table->integer("group_id");
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
      });
    }
    public function down()
    {
      // テーブル削除（ロールバック）
      Schema::drop('users');
    }
}
