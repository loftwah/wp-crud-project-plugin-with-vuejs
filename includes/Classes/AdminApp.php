<?php


namespace CrudProject\Classes;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin App Renderer and Handler
 * @since 1.0.0
 */
class AdminApp
{
    public function bootView()
    {
        echo "<div id='crud_project_app'></div>";
    }
}
