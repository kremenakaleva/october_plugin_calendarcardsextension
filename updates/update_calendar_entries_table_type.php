<?php namespace Pensoft\Calendarcardsextension\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateCalendarEntriesTableType extends Migration
{
	public function up()
	{
		if (!Schema::hasColumn('christophheich_calendar_entries', 'type')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->integer('type')->change();
			});
		}
	}

	public function down()
	{
		if (Schema::hasColumn('christophheich_calendar_entries', 'type')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->string('type')->change();
			});
		}
	}
}
