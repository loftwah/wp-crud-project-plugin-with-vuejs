<?php

namespace CrudProject\Classes;

use CrudProject\Classes\Models\Posts;
// use WPPayForm\Classes\Tools\GlobalTools;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax Handler Class
 * @since 1.0.0
 */
class AdminAjaxHandler
{  
    public function registerEndpoints()
    {
        
        add_action('wp_ajax_crud_project_admin_ajax', array($this, 'handleEndPoint'));
    }


    public function handleEndPoint()
    {
        
        $route = sanitize_text_field($_REQUEST['route']);
        $validRoutes = array(
            'get_posts'     => 'getPosts',
            'edit_post'     => 'editPost',
            'update_post'   => 'updatePost',
            'create_post'   => 'createPost',
            'delete_post'   => 'deletePost',
        );
        if (isset($validRoutes[$route])) {
            do_action('crud_project/doing_ajax_events_' . $route);
            return $this->{$validRoutes[$route]}();
        }
    }

    // get All posts
    protected function getPosts()
    {
        $perPage = absint($_REQUEST['per_page']);
        $pageNumber = absint($_REQUEST['page_number']);
        $searchString = sanitize_text_field($_REQUEST['search']);
        $args = array(
            'posts_per_page' => $perPage,
            'offset'         => $perPage * ($pageNumber - 1),
        );

        if ($searchString) {
            $args['s'] = $searchString;
        }
        
        $args = apply_filters('crudproject/get_all_posts_args', $args);
        $posts = Posts::getPostsDB($args); 

        wp_send_json_success($posts);
    }

    // Edit Post
    protected function editPost(){
        $editPostID = absint($_REQUEST['post_id']);
        $editPost   = Posts::EditPostDB($editPostID);
        wp_send_json_success(array(
            'post' => $editPost
        ), 200);

    }

    // update post
    protected function updatePost(){

        $postId = intval($_REQUEST['post_id']);
        $title = sanitize_text_field($_REQUEST['post_title']);
        if (!$postId || !$title) {
            wp_send_json_error(array(
                'message' => __('Please provide post title', 'crud_project')
            ), 423);
        }

        $postData = array(
            'post_title'   => $title,
            'post_content' => wp_kses_post($_REQUEST['post_content'])
        );

        do_action('crudproject/before_update_post', $postId, $postData);
       
        Posts::updatePostDB($postId, $postData);
        
        do_action('crudproject/after_update_post', $postId, $postData);

        wp_send_json_success(array(
            'message' => __('Post successfully updated', 'crud_project')
        ), 200);
    }

    // create post
    protected function createPost(){
       $postTitle = sanitize_text_field($_REQUEST['post_title']);
       if(!$postTitle) {
            $postTitle = "";
            return;
       }
       $postContent = sanitize_text_field($_REQUEST['post_content']);

       $data = array(
           'post_title' => $postTitle,
           'post_content' => $postContent
       );

       do_action('crudproject/before_create_post', $data);

       $postId = Posts::createPostDB($data);

        if (is_wp_error($postId)) {
            wp_send_json_error(array(
                'message' => __('Something is wrong when createding the post. Please try again', 'crud_project')
            ), 423);
            return;
        }

        do_action('crudproject/after_create_post', $postId, $data);

        wp_send_json_success(array(
            'message' => __('Post successfully created.', 'crudproject'),
            'post_id' => $postId,
        ), 200);


    }


    protected function deletePost(){
       
        $postId = intval($_REQUEST['post_id']);
        
        do_action('crudproject/before_post_delete', $postId);
       
        Posts::deletePostDB($postId);
        
        do_action('crudproject/after_post_delete', $postId);
        wp_send_json_success(array(
            'message' => __('Successfully deleted the post', 'crud_project')
        ), 200);
    }

 
}