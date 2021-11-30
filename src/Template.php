<?php

/**
       * Template File.
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

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <script type="text/javascript" 
        src="<?php echo esc_url(plugin_dir_url(__DIR__) . 'assets/main.js')?>"></script>
    
    <?php wp_head(); ?>
    
    <script>
        var ajaxURL= "<?php echo esc_url(admin_url('admin-ajax.php'))?>";
        var wpNonce= "<?php echo esc_html(wp_create_nonce('lovely-table-nonce'))?>";
    </script>
</head>

<body <?php body_class(); ?>>

<div class="loader">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
</div>

<div class="popup">
    <div class="popup-body">
        <div class="popup-div">
            <label>Name:</label>
            <span class="popup-name"></span>
        </div>
        <div class="popup-div">
            <label>Email:</label>
            <span class="popup-email"></span>
        </div>
        <div class="popup-div">
            <label>Phone:</label>
            <span class="popup-phone"></span>
        </div>
        <div class="popup-div">
            <label>Website:</label>
            <span class="popup-website"></span>
        </div>
        <div class="popup-div">
            <label>Company:</label>
            <span class="popup-company"></span>
        </div>
        <div class="popup-div">
            <label>Address:</label>
            <span class="popup-address"></span>
        </div>
        <div class="popup-map"></div>
        
        <button class="close-button">Close</button>
    </div>
</div>

<table class="<?php echo esc_attr(LovelyTable\Config::customClass())?>">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Username</th></tr>
    </thead>
    <tbody>
        <?php
        $usersArray = LovelyTable\LovelyTable::userList();
        if (!$usersArray) {
            ?>
                <tr><td colspan="3">Error while loading the data..</td></tr>
            <?php
        }
        $jsonArr = json_decode($usersArray);
        foreach ($jsonArr as $user) {
            ?>
                <tr>
                    <td><a href="#<?php echo esc_attr($user->id)?>">
                        <?php echo esc_attr($user->id)?></a>
                    </td>
                    <td><a href="#<?php echo esc_attr($user->id)?>">
                        <?php echo esc_html($user->name)?></a>
                    </td>
                    <td><a href="#<?php echo esc_attr($user->id)?>">
                        <?php echo esc_html($user->username)?></a>
                    </td>
                </tr>
                <?php
        }
        ?>
    </tbody>
</table>

</body>
</html>
