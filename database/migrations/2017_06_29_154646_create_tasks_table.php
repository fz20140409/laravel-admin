<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('任务名称');
            $table->string('minute')->default('*')->comment('分钟0-59');
            $table->string('hour')->default('*')->comment('小时0-23');
            $table->string('day')->default('*')->comment('天1-31');
            $table->string('month')->default('*')->comment('月份1-12');
            $table->string('week')->default('*')->comment('星期几0-7');
            $table->tinyInteger('command_type')->default(1)->comment('命令的类型:1表示laravel命令，2表示系统命令');
            $table->string('command')->comment('执行的命令');
            $table->string('description')->nullable()->comment('任务描述');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
