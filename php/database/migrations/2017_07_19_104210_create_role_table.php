<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        role_id  role_name role_auth_ids  role_auth_ac
        Schema::create('role',function (Blueprint $table){
            $table->increments("role_id")->comment("主键");
            $table->string("role_name",20)->comment("角色名称");
            $table->string("role_auth_ids",128)->comment("权限ids,1,2,5");
            $table->text("role_auth_ac",128)->comment("控制器-操作,控制器-操作,控制器-操作");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists("role");
    }
}
