<?php namespace Pensoft\Calendarcardsextension\Models;

use Model;

/**
 * Model
 */
class Eventtype extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pensoft_calendarcardsextension_eventtypes';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
