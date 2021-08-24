<?php namespace Pensoft\Calendarcardsextension;

use Backend;
use System\Classes\PluginBase;
use Cms\Classes\Theme;
use Pensoft\Calendar\Controllers\Entries as EntriesController;
use Pensoft\Calendar\Models\Entry;
use Pensoft\Cardprofiles\Controllers\Profiles as ProfilesController;
use Pensoft\Cardprofiles\Models\Profiles;

/**
 * Calendarcardsextension Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Calendarcardsextension',
            'description' => 'No description provided yet...',
            'author'      => 'Pensoft',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
	public function boot()
	{
		if(class_exists('\Pensoft\Calendar\Controllers\Entries')){
			EntriesController::extendFormFields(function($form, $model){
				if (!$model instanceof \Pensoft\Calendar\Models\Entry) {
					return;
				}

				$form->addFields([
					'type' => [
						'label' => 'Type',
						'comment' => 'Workshop or Interactive session',
						'type' => 'dropdown',
						'options' => \Pensoft\Calendarcardsextension\Models\Eventtype::all()->lists('name', 'id'),
					],
				]);

			});
		}

		//Extending Entry Model and add speakers relation
		Entry::extend(function($model) {
			$theme = Theme::getActiveTheme();
			$model->belongsToMany['speakers'] = [
				'Pensoft\Cardprofiles\Models\Profiles',
				'table' => 'pensoft_cardprofiles_entries',
				'order' => 'names'
			];
			if (!$model instanceof Entry) return;

		});

		// extend calendar to assign multiple card profile users
		if(class_exists('\Pensoft\Calendar\Controllers\Entries')){
			EntriesController::extendFormFields(function($form, $model){
				if (!$model instanceof \Pensoft\Calendar\Models\Entry) {
					return;
				}

				$form->addFields([
					'speakers' => [
						'label' => 'Speakers',
						'emptyOption' => '-- choose --',
						'span'  => 'auto',
						'type'  => 'relation',
						'select'  => 'CONCAT(names, \' - \', department)',
						'options' => \Pensoft\Cardprofiles\Models\Profiles::all()->lists('item', 'id'),
						'nameFrom' => 'item'
					],
				]);
			});
		}

		//Extending Profiles Model and add event entry relation
		Profiles::extend(function($model) {
			$theme = Theme::getActiveTheme();
			$model->belongsToMany['events'] = [
				'Pensoft\Calendar\Models\Entry',
				'table' => 'pensoft_cardprofiles_entries',
				'order' => 'title'
			];
			if (!$model instanceof Profiles) return;

		});

		// extend card profiled to be assign tp multiple calendar entries
		if(class_exists('\Pensoft\Cardprofiles\Controllers\Profiles')){
			ProfilesController::extendFormFields(function($form, $model){
				if (!$model instanceof \Pensoft\Cardprofiles\Models\Profiles) {
					return;
				}

				$form->addFields([
					'events' => [
						'label' => 'Speaker at the event(s)',
						'emptyOption' => '-- choose --',
						'span'  => 'auto',
						'type'  => 'relation',
						'select'  => 'CONCAT(title, \' - \', start)',
						'options' => \Pensoft\Calendar\Models\Entry::all()->lists('entry', 'id'),
						'nameFrom' => 'entry',
						'order' => 'start',
					],
					'keynote' => [
						'label' => 'Keynote',
						'type'  => 'checkbox',
						'default' => true,
					],
				]);

			});
		}



		\Event::listen('backend.menu.extendItems', function($manager)
		{

			// Remove users from backend menu
			$manager->removeMainMenuItem('Rainlab.User', 'user');


		});

	}

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Pensoft\Calendarcardsextension\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'pensoft.calendarcardsextension.some_permission' => [
                'tab' => 'Calendarcardsextension',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'calendarcardsextension' => [
                'label'       => 'Calendarcardsextension',
                'url'         => Backend::url('pensoft/calendarcardsextension/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['pensoft.calendarcardsextension.*'],
                'order'       => 500,
            ],
        ];
    }
}
