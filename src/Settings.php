<?php

/**
 * Settings File
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
 *  Settings Class
 *  Add Settings page on the WP administration
 *
 * @category  WP_Plugin
 * @package   WP_Lovely_Table_Plugin
 * @author    Ali Poostchi <poostchi@gmail.com>
 * @copyright 2021 Ali Poostchi
 * @license   https://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @link      https://github.com/poostchi
 **/

class Settings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action('admin_menu', [ $this, 'addPluginPage' ]);
        add_action('admin_init', [ $this, 'pageInit' ]);
    }

    /**
     * Add options page
     *
     * @return void
     */
    public function addPluginPage()
    {
        // This page will be under "Settings"
        add_options_page(
            'Lovely Table',
            'Lovely Table',
            'manage_options',
            'lovely-table-admin',
            [ $this, 'createAdminPage' ]
        );
    }

    /**
     * Options page callback
     *
     * @return void
     */
    public function createAdminPage()
    {
        // Set class property
        $this->options = get_option('lovely_table_option');
        ?>
        <div class="wrap">
            <h1>Lovely Table Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields('lovely_table_option_group');
                do_settings_sections('lovely-table-admin');
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings fields
     *
     * @return void
     */
    public function pageInit()
    {
        register_setting(
            'lovely_table_option_group', // Option group
            'lovely_table_option', // Option name
            [ $this, 'sanitize' ] // Sanitize
        );

        add_settings_section(
            'lovely_table_section_id', // ID
            '', // Title
            [ $this, 'printSectionInfo' ], // Callback
            'lovely-table-admin' // Page
        );

        add_settings_field(
            'endpoint_page',
            'Endpoint Page',
            [ $this, 'endpointPageCallback' ],
            'lovely-table-admin',
            'lovely_table_section_id'
        );

        add_settings_field(
            'cache_time', // ID
            'Cache Time (seconds)', // Title
            [ $this, 'cacheTimeCallback' ], // Callback
            'lovely-table-admin', // Page
            'lovely_table_section_id' // Section
        );

        add_settings_field(
            'custom_table_class', // ID
            'Custom Table Class', // Title
            [ $this, 'customTableClassCallback' ], // Callback
            'lovely-table-admin', // Page
            'lovely_table_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     *
     * @return array sanitized fields
     */
    public function sanitize(array $input): array
    {
        $newInput = [];
        if (isset($input['cache_time']) && $input['cache_time'] !== "") {
            $newInput['cache_time'] = absint($input['cache_time']);
        }

        if (isset($input['endpoint_page'])) {
            $newInput['endpoint_page'] = sanitize_key($input['endpoint_page']);
        }

        if (isset($input['custom_table_class'])) {
            $newInput['custom_table_class'] = sanitize_key($input['custom_table_class']);
        }

        return $newInput;
    }

    /**
     * Print the Section text
     *
     * @return void
     */
    public function printSectionInfo()
    {
        print 'Please update your lovely table settings below:';
    }

    /**
     * Render the field
     *
     * @return void
     */
    public function cacheTimeCallback()
    {
        printf(
            '<input type="text" placeholder="' . (Config::CACHE_TIME) . '" 
                id="cache_time" name="lovely_table_option[cache_time]" value="%s"/>',
            isset($this->options['cache_time']) ?
                esc_attr($this->options['cache_time']) : ''
        );
    }

    /**
     * Render the field
     *
     * @return void
     */
    public function endpointPageCallback()
    {
        printf(
            '<input type="text" placeholder="' . (Config::END_POINT_PAGE) . '"  
        id="endpoint_page" name="lovely_table_option[endpoint_page]" value="%s" />
        <p class="description">' . get_site_url() . "/[Endpoint Page]</p>",
            isset($this->options['endpoint_page']) ?
            esc_attr($this->options['endpoint_page']) : ''
        );
    }

    /**
     * Render the field
     *
     * @return void
     */
    public function customTableClassCallback()
    {
        printf(
            '<input type="text" placeholder=""  id="custom_table_class" 
            name="lovely_table_option[custom_table_class]" value="%s" />',
            isset($this->options['custom_table_class']) ?
            esc_attr($this->options['custom_table_class']) : ''
        );
    }
}
?>