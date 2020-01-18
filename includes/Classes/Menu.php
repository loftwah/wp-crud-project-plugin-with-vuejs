<?php

namespace CrudProject\Classes;


class Menu
{
    public function register()
    {
        add_action( 'admin_menu', array($this, 'addMenus') );
        add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
    }

    public function addMenus()
    {
        $menuPermission = AccessControl::hasTopLevelMenuPermission();
        if (!$menuPermission) {
            return;
        }

        $title = __('Crud Project', 'crud_project');
        global $submenu;
        add_menu_page(
            $title,
            $title,
            $menuPermission,
            'crud_project',
            array($this, 'render'),
            'dashicons-admin-site',
            25
        );

        $submenu['crud_project']['my_profile'] = array(
            __('Plugin Dashboard', 'crud_project'),
            $menuPermission,
            'admin.php?page=crud_project#/',
        );
        $submenu['crud_project']['settings'] = array(
            __('Settings', 'crud_project'),
            $menuPermission,
            'admin.php?page=crud_project#/settings',
        );
        $submenu['crud_project']['supports'] = array(
            __('Supports', 'crud_project'),
            $menuPermission,
            'admin.php?page=crud_project#/supports',
        );
    }

    public function render() {
        do_action('crud_project/render_admin_app');
        wp_enqueue_script(
            'crud_project',
            CRUDPROJECT_URL . 'assets/js/crud_project.js',
            array( 'jquery' ),
            CRUDPROJECT_VERSION,
            true
        );
    }

    public function enqueueAssets()
    {

            wp_enqueue_script('crud_project_boot', CRUDPROJECT_URL.'assets/js/boot.js', array('jquery'), CRUDPROJECT_VERSION, true);
            // 3rd party developers can now add their scripts here
            do_action('crud_project/booting_admin_app');
            wp_enqueue_script('crud_project_admin_app', CRUDPROJECT_URL.'assets/js/crud_project.js', array('wppayform_boot'), CRUDPROJECT_VERSION, true);
            // wp_enqueue_style('crud_project_admin_app', CRUDPROJECT_URL.'assets/css/crud_project-admin.css', array(), CRUDPROJECT_VERSION);

            $pluginNameAdminVars = apply_filters('crud_project/admin_app_vars',array(
                // 'image_upload_url' => admin_url('admin-ajax.php?action=wpf_global_settings_handler&route=wpf_upload_image'),
                'assets_url' => CRUDPROJECT_URL.'assets/',
                'ajaxurl' => admin_url('admin-ajax.php')
            ));

            wp_localize_script('crud_project_boot', 'CrudProjectAdmin', $pluginNameAdminVars);
        
    }

}
