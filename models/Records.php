<?php namespace Pensoft\Calendarcardsextension\Models;

use Carbon\Carbon;
use Model;
use Pensoft\Calendar\Models\Entry;
use Pensoft\Cardprofiles\Models\Profiles;
Use Illuminate\Support\Facades\DB;

/**
 * Records Model
 */
class Records extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table associated with the model
     */
    public $table = 'pensoft_calendarcardsextension_records';

    /**
     * @var array guarded attributes aren't mass assignable
     */
    protected $guarded = ['*'];

    /**
     * @var array fillable attributes are mass assignable
     */
    protected $fillable = [];

    /**
     * @var array rules for validation
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array jsonable attribute names that are json encoded and decoded from the database
     */
    protected $jsonable = [];

    /**
     * @var array appends attributes to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array hidden attributes removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


	public static function events(){
		$entries = Db::table('christophheich_calendar_entries')
			->select(Db::raw('christophheich_calendar_entries.*, string_agg(pensoft_cardprofiles_items.names, \', \') AS speakers, pensoft_calendarcardsextension_eventtypes.name'))
			->join('pensoft_cardprofiles_entries', 'pensoft_cardprofiles_entries.entry_id', '=', 'christophheich_calendar_entries.id')
			->join('pensoft_cardprofiles_items', 'pensoft_cardprofiles_items.id', '=', 'pensoft_cardprofiles_entries.profiles_id')
			->join('pensoft_calendarcardsextension_eventtypes', 'christophheich_calendar_entries.type', '=', DB::raw('pensoft_calendarcardsextension_eventtypes.id::varchar'))
			->groupByRaw('christophheich_calendar_entries.id, pensoft_calendarcardsextension_eventtypes.name')
			->orderBy('christophheich_calendar_entries.start', 'asc')
			->get();

		foreach ($entries as $entry){
			$entry->subsections = self::subsections($entry->id);
		}
		return $entries;
	}

	public static function speakers($date){
		$speakers = Db::table('pensoft_cardprofiles_items')
			->select(Db::raw('pensoft_cardprofiles_items.*, christophheich_calendar_entries.start::date, christophheich_calendar_entries.end::date'))
			->join('pensoft_cardprofiles_entries', 'pensoft_cardprofiles_entries.profiles_id', '=', 'pensoft_cardprofiles_items.id')
			->join('christophheich_calendar_entries', 'christophheich_calendar_entries.id', '=', 'pensoft_cardprofiles_entries.entry_id')
			->distinct('pensoft_cardprofiles_items.id')
			->whereDate('christophheich_calendar_entries.start', '>=', $date )
			->whereDate('christophheich_calendar_entries.end', '<=', $date )
			->orderBy('pensoft_cardprofiles_items.id')
			->get();

		foreach ($speakers as $speaker){
			$speaker->participations = Entry::join('pensoft_cardprofiles_entries', 'pensoft_cardprofiles_entries.entry_id', '=', 'christophheich_calendar_entries.id')
				->where('pensoft_cardprofiles_entries.profiles_id', '=', $speaker->id)
				->orderBy('christophheich_calendar_entries.start')
				->get();
			$speaker->add_data = Profiles::where('id', $speaker->id)->first();
		}
		return $speakers;
	}

	public static function subsections($eventId){

		$sections = Db::table('pensoft_calendarcardsextension_sections')
			->select(Db::raw('pensoft_calendarcardsextension_sections.*, string_agg(pensoft_cardprofiles_items.names, \', \') AS speakers'))
			->join('pensoft_calendarcardsextension_sections_speakers', 'pensoft_calendarcardsextension_sections_speakers.sections_id', '=', 'pensoft_calendarcardsextension_sections.id')
			->join('pensoft_cardprofiles_items', 'pensoft_cardprofiles_items.id', '=', 'pensoft_calendarcardsextension_sections_speakers.profiles_id')
			->where('entry_id', $eventId)
			->groupByRaw('pensoft_calendarcardsextension_sections.id')
			->get();


		return $sections;
	}

}
