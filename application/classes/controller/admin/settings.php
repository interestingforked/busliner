<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Settings extends Controller_Admin_Application {

    public $auth_required = array('admin');

    public function action_index() {
        $this->template->title = __('Settings');
        $content = $this->template->content = View::factory('admin/settings/index');
        $settings = ORM::factory('Setting')->find_all();
        if ($_POST) {
            foreach ($settings AS $setting) {
                if ( ! isset($_POST[$setting->key])) {
                    $value = 0;
                } else {
                    $value = $_POST[$setting->key];
                }
                $setting = ORM::factory('Setting')->save_value($setting->key, $value);
            }
            $this->template->success = 'All settings are saved!';
        }

        $settings = ORM::factory('Setting')->find_all();
        
        $content->settings = $settings;
    }

}
