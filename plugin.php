<?php
/*
    Plugin Name: et_appchase_core_dynadev
    Plugin URI:
    Description: plugin that facilitates turn a bunch of our "WP Dynamic Development Tools", like Advanced Custom Fields & Custom Post Types - UI, into a form that doesn't rely on database exports
    Author: JJ Rohrer
    Author URI: https://github.com/jjrohrer
    Version: 0.0.2
    Depends:
*/
class ClsDynaDev {
    /* Ok - acf is a littler confusing.  In your theme, if you make an 'acf-json', all of your configs will automatically
    be saved there upon 'save'.
    Now, you can tell acf to look for other load points, like we do here.  But note that there is still only the
    original save point in the theme.
    Also, you can export json, but you'll need to rename the stuff by looking to get the key, like
        "key": "group_551df86a9cfe2",
    and then name the file
        group_551df86a9cfe2.json

    You can also almost round-trip the file by 'syncing', but keep in mind you can still only export of save to
    the theme.

    It should be noted you can save to someplace other than your theme, but still, you can only save to one single
    place.

    I'm still a little confused by the workflow here.
    */


    static function be_configured_for_acf($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it){
        $dirname = dirname($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it);
        add_filter('acf/settings/load_json', function($paths) use ($dirname){
            //http://www.advancedcustomfields.com/resources/local-json/
            // append path
            $paths[] = $dirname. '/DynaDevConfig/acf-json';

            // return
            return $paths;
        });
    }

    static function be_configured_for_acf_options_page($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it){
        $dirname = dirname($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it);
        add_filter('acf_options_page/settings/load_json', function($paths) use ($dirname){
            // append path
            $paths[] = $dirname. '/DynaDevConfig/acf_options_page';

            // return
            return $paths;
        });
    }

    static function be_configured_for_cpt_ui($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it){
        $dirname = dirname($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it);
        require($dirname.'/DynaDevConfig/cpt-ui/inc.php');
    }
    static function be_configured_for_cac($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it){
        $dirname = dirname($__FILE__or__DIR__of_calling_plugin_that_needs_configs_associated_with_it);
        add_action( 'init', function() use ($dirname) {
            require($dirname.'/DynaDevConfig/cac/inc.php');
        });
    }
}

/* usage
class ClsAcfOptionsAdderTest {
    function __construct() {
        ClsDynaDevSyncHelper::be_configured_for_acf_options_page(__FILE__);
        ClsDynaDevSyncHelper::be_configured_for_acf(__FILE__);
        ClsDynaDevSyncHelper::be_configured_for_cpt_ui(__FILE__);
        ClsDynaDevSyncHelper::be_configured_for_cpt_ui(__FILE__); // modify the export code to be closure.  IMPORTANT: Also store an export file
        ClsDynaDevSyncHelper::be_configured_for_cac(__FILE__);
    }
}

new ClsAcfOptionsAdderTest();
*/


