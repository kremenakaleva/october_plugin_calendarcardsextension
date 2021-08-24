<?php namespace Pensoft\Calendarcardsextension\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePensoftCardprofilesEntriesTable extends Migration
{
	public function up()
	{
		if (!Schema::hasTable('pensoft_cardprofiles_entries')) {
			Schema::create('pensoft_cardprofiles_entries', function(Blueprint $table)
			{
				$table->engine = 'InnoDB';
				$table->integer('profiles_id');
				$table->integer('entry_id');
				$table->primary(['profiles_id', 'entry_id']);
			});
		}
	}

	public function down()
	{
		Schema::dropIfExists('pensoft_cardprofiles_entries');
	}
}
