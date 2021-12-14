<?php 

/**
 * Plugin Name: WP Lovely Table
 * Plugin URI: https://github.com/poostchi/wpTable
 * Description: A Lovely HTML Users Table
 * Version: 0.1
 * Author: Ali Poostchi
 * Author URI:https://github.com/poostchi
 * License: MIT
 */

namespace LovelyTable;

if (!class_exists(LovelyTable::class) && is_readable(__DIR__.'/vendor/autoload.php')){
    require_once __DIR__.'/vendor/autoload.php';
}

class_exists(LovelyTable::class) && LovelyTable::init();
