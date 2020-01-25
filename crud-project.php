<?php

/*
Plugin Name: CRUD Project
Plugin URI: #
Description: A WordPress boilerplate plugin with Vue js.
Version: 1.0.0
Author: #
Author URI: #
License: GPLv2 or later
Text Domain: crud_project
*/


/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 *
 * Copyright 2019 Plugin Name LLC. All rights reserved.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('CRUDPROJECT_VERSION')) {
    define('CRUDPROJECT_VERSION_LITE', true);
    define('CRUDPROJECT_VERSION', '1.1.0');
    define('CRUDPROJECT_MAIN_FILE', __FILE__);
    define('CRUDPROJECT_URL', plugin_dir_url(__FILE__));
    define('CRUDPROJECT_DIR', plugin_dir_path(__FILE__));
    define('CRUDPROJECT_UPLOAD_DIR', '/crud_project');

require CRUDPROJECT_DIR.'includes/autoload.php';
    class CrudProject
    {
        public function boot()
        {
            if (is_admin()) {
                $this->adminHooks();
            }
            $this->textDomain();
            $this->commonActions();

           $this->registerShortcodes();
        }

        public function adminHooks()
        {
            //Register Admin menu
            $menu = new \CrudProject\Classes\Menu();
            $menu->register();

            // Menu page callback function load
            add_action('crud_project/render_admin_app', function () {
                $adminApp = new \CrudProject\Classes\AdminApp();
                $adminApp->bootView();
            });

            // load AdminAjaxHandler
            $ajaxHandler = new \CrudProject\Classes\AdminAjaxHandler();
            $ajaxHandler->registerEndpoints();

          
            wp_enqueue_script(
                'crud_project_vue_loaded',
                CRUDPROJECT_URL . 'assets/js/boot.js',
                array( 'jquery' ),
                CRUDPROJECT_VERSION,
                true
            );
        }

        public function textDomain()
        {
            load_plugin_textdomain('crud_project', false, basename(dirname(__FILE__)) . '/languages');
        }


        public function commonActions()
        {   
            // Handle Extorior Pages
            add_action('init', function () {
                $demoPage = new \CrudProject\Classes\Extorior\ProcessDemoPage();
                $demoPage->handleExteriorPages();
            });
        }

        // shortcode register
        public function registerShortcodes()
        {   
            // Register the shortcode 
            add_shortcode('crud_project_post', function ($args) {
              
                $args = shortcode_atts(array(
                    'id'   => '',
                ), $args);

                if (!$args['id']) {
                    return;
                }

                $builder = new \CrudProject\Classes\Builder\Render(); 
                return $builder->render($args['id']);
            });
        }
    }

    add_action('plugins_loaded', function () {
        (new CrudProject())->boot();
    });

    register_activation_hook(__FILE__, function ($newWorkWide) {
        //require_once(CRUDPROJECT_DIR . 'includes/Classes/Activator.php');
        $activator = new \CrudProject\Classes\Activator();
        $activator->migrateDatabases($newWorkWide);
    });

} else {
    add_action('admin_init', function () {
        deactivate_plugins(plugin_basename(__FILE__));
    });
}
