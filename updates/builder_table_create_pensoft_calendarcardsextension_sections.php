<?php namespace Pensoft\Calendarcardsextension\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePensoftCalendarcardsextensionSections extends Migration
{
    public function up()
    {
        Schema::create('pensoft_calendarcardsextension_sections', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('entry_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('link')->nullable();
            $table->string('moderator')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pensoft_calendarcardsextension_sections');
    }
}
