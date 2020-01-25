<?php

namespace CrudProject\Classes\Extorior; 

use CrudProject\Classes\AccessControl;
use CrudProject\Classes\Models\Posts;

class ProcessDemoPage
{
  
    public function handleExteriorPages()
    {   
        if (isset($_GET['wp_crudproject_preview']) && $_GET['wp_crudproject_preview']) {
            $hasDemoAccess = AccessControl::hasTopLevelMenuPermission();
            $hasDemoAccess = apply_filters('crudproject/can_see_demo_post', $hasDemoAccess);
            if($hasDemoAccess) {
                $postId = intval($_GET['wp_crudproject_preview']);
                $this->loadDefaultPageTemplate();
                $this->renderPreview($postId);
            }
        }
    }

    public function renderPreview($postId)
    {
       
       $post = Posts::getPostDB($postId);
        if ($post) {
            add_action('pre_get_posts', array($this, 'pre_get_posts'), 100, 1);
            add_filter('post_thumbnail_html', '__return_empty_string');
            add_filter('get_the_excerpt', function ($content) use ($post) {
                if (in_the_loop()) {
                    $content = '<div style="text-align: center" class="demo"><h4>WP CRUD Project Demo Preview ( From ID: ' . $post->ID . ' )</h4></div><hr />';
                    $content .= do_shortcode('[crud_project_post id="' . $post->ID . '"]');
                }
               return $content;
            },999, 1);
            add_filter('the_title', function ($title) use ($post) {
                if (in_the_loop()) {
                    return $post->post_title = "";
                }
               
                return $title;
            }, 100, 1);
            add_filter('the_content', function ($content) use ($post) {
                if (in_the_loop()) {
                    $content = '<div style="text-align: center" class="demo"><h4>WP CRUD Project Demo Preview ( From ID: ' . $post->ID . ' )</h4></div><hr />';
                    $content .= do_shortcode('[crud_project_post id="' . $post->ID . '"]');
                }
                return $content;
            },999,1);
        }
    }
    

    private function loadDefaultPageTemplate()
    {
        add_filter('template_include', function ($original) {
            return locate_template(array('page.php', 'single.php', 'index.php'));
        }, 999);
    }

    /**
     * Set the posts to one
     *
     * @param  WP_Query $query
     *
     * @return void
     */
    public function pre_get_posts($query)
    {
        if ($query->is_main_query()) {
            $query->set('posts_per_page', 1);
            $query->set('ignore_sticky_posts', true);
        }
    }

}