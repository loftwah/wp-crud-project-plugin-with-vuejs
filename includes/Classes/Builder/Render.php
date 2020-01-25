<?php


namespace CrudProject\Classes\Builder; 
use CrudProject\Classes\Models\Posts;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Class
 * @since 1.0.0
 */
class Render
{
    public function render($postId)
    {
       
        $post = Posts::getPostDB($postId);
        
        if (!$post) {
            return;
        }
        ob_start();
            $this->renderPreview($post);
        $html = ob_get_clean();

        return apply_filters('crudproject/rendered_post_html', $html);
    }


    public function renderPreview($post)
    {
        ?>
            <div class="crud_project_post">
                <div class="title"> 
                    <h1> <?php echo $post->post_title; ?> </h1> 
                </div>
                <div class="content">
                    <p> <?php echo $post->post_content; ?> </p>
                </div>
            </div>

        <?php
    }



}


