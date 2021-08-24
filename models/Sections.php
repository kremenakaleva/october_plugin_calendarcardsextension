<?php namespace Pensoft\Calendarcardsextension\Models;

use Model;
use Pensoft\Cardprofiles\Models\Profiles;

/**
 * Model
 */
class Sections extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pensoft_calendarcardsextension_sections';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

	public $belongsTo = [
		'entry' => 'Pensoft\Calendar\Models\Entry'
	];

	public $belongsToMany = [
		'speakers'       => [Profiles::class, 'table' => 'pensoft_calendarcardsextension_sections_speakers'],
	];
}
