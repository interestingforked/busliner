<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller {

    public function action_send($url = NULL) {
        $content = View::factory('elements/send');
        $message = '';
        if ($_POST) {
            $header = "Content-type: text/html; charset=UTF-8 \r\n" .
                "MIME-Version: 1.0 \r\n" .
                "From: webmaster@es.gov.lv \r\n" .
                'X-Mailer: PHP/' . phpversion();
            $subject = __('Jums nosūtīta saite uz rakstu es.gov.lv mājas lapā!');
            $text = View::factory('elements/send_mail', array('data' => $_POST))->render();

            mail($_POST['email'], $subject, $text, $header);
            $message = HTML::flash_message(__('Ziņa nosūtīta!'), HTML::ACCEPT);
        }

        $data = Session::instance()->get('send');
        $content->url = URL::site($data['url'], TRUE);
        $content->title = $data['title'];
        $content->message = $message;
        $this->request->response = $content->render();
    }

    public function action_rss($category = 'news') {
        $content = NULL;
        switch ($category) {
            case 'news':
                $result = ORM::factory('News')
                    ->where('status', '=', 'published')
                    ->and_where('rss_enabled', '=', '1')
                    ->order_by('created', 'DESC')
                    ->limit(20)
                    ->find_all();
                break;
            case 'events':
                $result = ORM::factory('Event')
                    ->where('status', '=', 'published')
                    ->and_where('rss_enabled', '=', '1')
                    ->order_by('created', 'DESC')
                    ->limit(20)
                    ->find_all();
                break;
            default:
                $result = NULL;
        }
        if ($result) {
            $info = array(
                'title' => __('www.es.gov.lv - Latvija Eiropas Savienībā'),
                'pubDate' => date("D, d M Y H:i:s +0300"),
            );
            $items = array();
            foreach ($result AS $item) {
		$intro = ($item->intro) ? $item->intro : Text::limit_words(preg_replace("/(\n)|(\r)|(&nbsp;)/i"," ",strip_tags($item->body)), 75, ' ...');
                $items[] = array(
                    'title' => $item->title,
                    'link' => URL::site($category . DS . $item->slug, TRUE),
                    'description' => $intro,
                    'pubDate' => date("D, d M Y H:i:s +0300", strtotime($item->created)),
                );
            }
            $content = Feed::create($info, $items);
            $this->request->headers = array('Content-Type' => 'text/xml');
        }
        $this->request->response = $content;
    }

    public function action_check_domain($domain) {
        $check = Whois::factory()->check_domain($domain);
        $this->request->response = ($check) ? 1 : 0;
    }

    public function action_geoip($address) {
        $check = Whois::factory()->check_ip($address);
        $this->request->response = $check;
    }
    
    public function action_download($file) {
        $directory = Kohana::config('application')->downloads_uploads;
        $file = $directory.$file;
        if (file_exists($file)) {
            $filename = explode('/', $file);
            $filename = end($filename);
            
            $extension = explode('.', $filename);
            $extension = end($extension);
            
            $mimetype = File::mime_by_ext($extension);
            
            $fp = fopen($file, 'r');

            header('Cache-Control: public');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.$filename);
            header('Content-Type: '.$mimetype);
            header('Content-Transfer-Encoding: binary');
            
            fpassthru($fp);
            fclose($fp);
            
            exit;
            
        } else {
            if (isset($_SERVER['HTTP_REFERER'])) {
                Request::instance()->redirect($_SERVER['HTTP_REFERER']);
            } else {
                Request::instance()->redirect('/');
            }
        }
    }

}

// End Application
