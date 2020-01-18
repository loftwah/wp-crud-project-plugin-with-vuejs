<?php

if(!function_exists('wpFluent')) {
    include CRUDPROJECT_DIR . 'includes/libs/wp-fluent/wp-fluent.php';
}

function CRUDProjectFormDB()
{
    if (!function_exists('wpFluent')) {
        include CRUDPROJECT_DIR . 'includes/libs/wp-fluent/wp-fluent.php';
    }
    return wpFluent();
}


