<?php namespace Pensoft\Calendarcardsextension\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRecordsTable Migration
 */
class CreateRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('pensoft_calendarcardsextension_records', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pensoft_calendarcardsextension_records');
    }
}
