<?php namespace Pensoft\Calendarcardsextension\Updates;

use phpDocumentor\Reflection\Types\True_;
use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateCardprofilesTable extends Migration
{
	public function up()
	{
		if (!Schema::hasColumn('pensoft_cardprofiles_items', 'keynote')) {
			Schema::table('pensoft_cardprofiles_items', function($table)
			{
				$table->boolean('keynote')->default(true);
			});
		}
	}

	public function down()
	{
		if (Schema::hasColumn('pensoft_cardprofiles_items', 'keynote')) {
			Schema::table('pensoft_cardprofiles_items', function($table)
			{
				$table->dropColumn('keynote');
			});
		}
	}
}
