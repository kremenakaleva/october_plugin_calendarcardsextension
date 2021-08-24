<?php namespace Pensoft\Calendarcardsextension\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePensoftCalendarcardsextensionSectionsSpeakers extends Migration
{
    public function up()
    {
        Schema::create('pensoft_calendarcardsextension_sections_speakers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('sections_id');
            $table->integer('profiles_id');
            $table->primary(['sections_id','profiles_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pensoft_calendarcardsextension_sections_speakers');
    }
}
