<?php

/**
 * Config File
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

/**
 *  Config Class
 *  Get the settings values
 *
 * @category  WP_Plugin
 * @package   WP_Lovely_Table_Plugin
 * @author    Ali Poostchi <poostchi@gmail.com>
 * @copyright 2021 Ali Poostchi
 * @license   https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link      https://github.com/poostchi
 **/
class Config
{

    public const API_PAGE = "https://jsonplaceholder.typicode.com/users";

    // default values
    public const END_POINT_PAGE = "my-lovely-table";
    public const CACHE_TIME = 3600;// in seconds

    /**
     * Get the API URL for users page
     *
     * @return URL string
     */
    public function apiUsersPage(): string
    {
        return self::API_PAGE;
    }

    /**
     * Get the API URL for characteristics page
     *
     * @param $userID int ID of the selected user
     *
     * @return URL string
     */
    public function apiDetailsPage(int $userId): string
    {
        return self::API_PAGE . "/$userId";
    }

    /**
     * Get endpoint page
     * Using default value if it is not set in settings page
     *
     * @return string
     */
    public function endPointName(): string
    {
        $options = get_option('lovely_table_option');

        if (isset($options['endpoint_page']) && $options['endpoint_page'] !== "") {
            return $options['endpoint_page'];
        }

        return self::END_POINT_PAGE;
    }

    /**
     * Get cache time (seconds)
     * Using default value if it is not set in settings page
     *
     * @return int
     */
    public function cacheTime(): int
    {
        $options = get_option('lovely_table_option');
        if (isset($options['cache_time']) && $options['cache_time'] !== "") {
            return $options['cache_time'];
        }

        return self::CACHE_TIME;
    }

    /**
     * Get custom table class (css)
     *
     * @return string class name
     */
    public function customClass(): string
    {
        $options = get_option('lovely_table_option');
        if (isset($options['custom_table_class'])) {
            return $options['custom_table_class'];
        }

        return "";
    }
}
