<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Media extends ORM {

    protected $_table_name = 'media';

    // Relationships

    // Validation rules
    protected $_rules = array(
        'type' => array(
            'not_empty' => NULL,
        ),
        'hash' => array(
            'not_empty' => NULL,
            'exact_length' => array(32),
        ),
        'filename' => array(
            'not_empty' => NULL,
        ),
        'extension' => array(
            'not_empty' => NULL,
        ),
        'path' => array(
            'not_empty' => NULL,
        ),
    );

    public function save_media_files($media_array, $module, $module_id, $title, $user) {
        $errors = array();

        $config = Kohana::config('application');
        $tmp_dir = $config->tmp_upload_dir;
        $upload_directory = $config->upload_dir;

        foreach ($media_array AS $file) {
            $fileinfo = explode('|', $file);
            $directory = $upload_directory.Inflector::plural($fileinfo[0]).DS.$title;
            if ( ! file_exists(realpath($directory))) {
                if ( ! mkdir($directory)) {
                    $errors[] = __('Cannot create directory').': '.$directory;
                    continue;
                }
            }
            $tmp_file = realpath($fileinfo[4]);

            $filename = Text::slugify($fileinfo[2]);
            $extension = strtolower($fileinfo[3]);

            $newfile = $filename.'.'.$extension;
            $newfile = realpath($directory).DS.$newfile;

            if (copy($tmp_file, $newfile)) {
                unlink($tmp_file);
            }

            $this->module = $module;
            $this->module_id = $module_id;
            $this->type = $fileinfo[0];
            $this->hash = $fileinfo[1];
            $this->filename = $filename;
            $this->extension = $extension;
            $this->path = $directory;
            $this->created = DB::expr('NOW()');
            $this->created_by = $user->id;
            
            if ($this->check()) {
                $this->save();
            }
            else {
                $errors = $this->validate()->errors('validate');
            }
            $this->clear();
        }
        if ( ! empty($errors)) {
            return $errors;
        }
        return TRUE;
    }

    public function get_media($module, $module_id, $type = NULL) {
        if ($type) {
            return $this
                ->where('module','=',$module)
                ->and_where('module_id','=',$module_id)
                ->and_where('type','=',$type)
                ->find_all();
        } else {
            return $this
                ->where('module','=',$module)
                ->and_where('module_id','=',$module_id)
                ->find_all();
        }
    }

    public function get_media_sql($module, $module_id, $type = NULL) {
        $sql = "SELECT * FROM media WHERE module = '{$module}' AND module_id = {$module_id} AND type = '{$type}' ";
        $result = DB::query(Database::SELECT, $sql)
            ->as_object(TRUE)
            ->execute()
            ->as_array();
        return $result;
    }

}