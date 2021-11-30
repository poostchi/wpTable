<?php 

/**
 * Plugin Name: WP Lovely Table
 * Plugin URI:
 * Description: A Lovely HTML Users Table (Demo Project for Inpsyde)
 * Version: 0.1
 * Author: Ali Poostchi
 * Author URI:
 * License: MIT
 */

namespace LovelyTable;

if (!class_exists(LovelyTable::class) && is_readable(__DIR__.'/vendor/autoload.php')){
    require_once __DIR__.'/vendor/autoload.php';
}

class_exists(LovelyTable::class) && LovelyTable::init();