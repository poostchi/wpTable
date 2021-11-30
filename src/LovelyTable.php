<?php

/**
 * Lovely Table Class File
 *
 * Php version 7.1+
 *
 * @category  WP_Plugin
 * @package   WP_Lovely_Table_Plugin
 * @author    Ali Poostchi <poostchi@gmail.com>
 * @copyright 2021 Ali Poostchi
 * @license   https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link      https://github.com/poostchi
 **/

declare(strict_types=1);

namespace LovelyTable;

use LovelyTable\Config;
use LovelyTable\Settings;

/**
 *  LovelyTable Class
 *  Initilize the plugin, setup the endpoint and administration settings page
 *
 * @category  WP_Plugin
 * @package   WP_Lovely_Table_Plugin
 * @author    Ali Poostchi <poostchi@gmail.com>
 * @copyright 2021 Ali Poostchi
 * @license   https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link      https://github.com/poostchi
 **/
final class LovelyTable
{
    /**
     * Initialize the plugin
     *
     * @return void
     */
    public static function init()
    {
        // add settings
        if (is_admin()) {
            new Settings();
        }

        // add ajax calls
        add_action(
            'wp_ajax_nopriv_userDetail',
            [ get_called_class(), 'userDetail' ]
        );
        add_action(
            'wp_ajax_userDetail',
            [ get_called_class(), 'userDetail' ]
        );

        // add endPoint
        self::addEndPoint();
    }

    /**
     * Setup endpoint
     *
     * @return void
     */
    private function addEndPoint()
    {

        add_action(
            'template_redirect',
            static function () {

                // check for the endpoint URI
                $serverUrl = isset($_SERVER['REQUEST_URI']) ?
                    esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])) : "";

                if (
                    basename(
                        parse_url($serverUrl, PHP_URL_PATH)
                    ) === Config::endPointName()
                ) {
                    global $wp_query;
                    $wp_query->is_404 = false;
                    header("HTTP/1.1 200 OK");

                    // add Lovely Table plugin stylesheet
                    wp_register_style(
                        'lovelyTableStylesheet',
                        plugins_url('assets/main.css', __DIR__),
                        [],
                        "1.0"
                    );
                    wp_enqueue_style('lovelyTableStylesheet');

                    include __DIR__ . '/Template.php';
                    die;
                };
            }
        );
    }

    /**
     * Get users list from 3rd Party API
     *
     * @return string(json) list of the users or false
     */
    public function userList(): string
    {
        $url = Config::apiUsersPage();
        return self::getServiceData($url);
    }

    /**
     * Call the 3rd Party API
     *
     * @param $url 3rd party endpoint URL
     *
     * @return string(json) list of the users or false
     */
    private function getServiceData(string $url): string
    {

        $fileName = basename(parse_url($url, PHP_URL_PATH));
        $filePath = __DIR__ . "/../cache/" . $fileName . ".json";

        // check for cached file
        if (file_exists($filePath)) {
            // cache file exists, check for cache time
            if (filemtime($filePath) + Config::cacheTime() > strtotime("now")) {
                $result = file_get_contents($filePath);
                return $result;
            }
        }

        // if cached file doesn't exist or it is expired, open it using CURL

        // set options for curl
        $options = [
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => false,  // don't follow redirects
            CURLOPT_CONNECTTIMEOUT => 30,    // time-out on connect
            CURLOPT_TIMEOUT => 30,    // time-out on response
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        $curl = curl_init($url);
        curl_setopt_array($curl, $options);

        $content = curl_exec($curl);
        $errors = curl_error($curl);
        curl_close($curl);

        if ($errors) {
            return "";
        }
        // save cache file
        file_put_contents($filePath, $content);
        return $content;
    }

    /**
    AJAX call for get the users' characteristics
     *
    @return void
     **/
    public function userDetail()
    {

        if (!isset($_REQUEST['nonce'])) {
            wp_send_json_success(["error" => true]);
            die;
        }

        if (!wp_verify_nonce(wp_unslash(sanitize_key($_REQUEST['nonce'])), 'lovely-table-nonce')) {
            wp_send_json_success(["error" => true]);
            die;
        }

        if (isset($_REQUEST['userId']) && (int) $_REQUEST['userId'] > 0) {
            $userId = (int) $_REQUEST['userId'];
            $url = Config::apiDetailsPage($userId);
            $output = self::getServiceData($url);

            if ($output) {
                wp_send_json_success(json_decode($output));
                die;
            }
        }

        wp_send_json_success(["error" => true]);
        die;
    }
}
