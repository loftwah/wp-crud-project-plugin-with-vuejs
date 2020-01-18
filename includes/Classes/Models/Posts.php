<?php

namespace CrudProject\Classes\Models; 

// use WPPayForm\Classes\Entry\Entry;
// use WPPayForm\Classes\GeneralSettings;
// use WPPayForm\Classes\ArrayHelper;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax Handler Class
 * @since 1.0.0
 */
class Posts
{
    // get posts on database
    public static function getPostsDB($args = array())
    {
     
        $postsQuery = CRUDProjectFormDB()->table('posts')
            ->orderBy('ID', 'DESC')
            ->limit($args['posts_per_page'])
            // ->offset($args['offset'])
            ->where('post_type', 'post')
            ->where('post_status', 'publish');
           
            if (!empty($args['s'])) {
                $postsQuery->where(function ($q) use ($args) {
                    $q->where('post_title', 'LIKE', "%{$args['s']}%");
                    $q->orwhere('post_content', 'LIKE', "%{$args['s']}%");
                    $q->orWhere('ID', 'LIKE', "%{$args['s']}%");
                });
            }

        $posts =  $postsQuery->get();
        $total = $postsQuery->count();
       
        return array(
            'posts' => $posts,
            'total' => $total
        );
    }


    // post create
    public static function createPostDB($data)
    {
       
        $data['post_type'] = 'post';
        $data['post_status'] = 'publish';
        $id = wp_insert_post($data);
        return $id;

    }

    //Edit Post 
    public static function EditPostDB($editPostID)
    {
        $post = get_post($editPostID, 'OBJECT');
        return $post;
    }

    // Update Post
    public static function updatePostDB($postId, $data)
    {
       
        $data['ID'] = $postId;
        $data['post_type'] = 'post';
        $data['post_status'] = 'publish';
        return wp_update_post($data);
    }

   
    public static function deletePostDB($postId)
    {
        wp_delete_post($postId, true);
        CRUDProjectFormDB()->table('posts')
            ->where('ID', $postId)
            ->delete();

        return true;
    }


   
}