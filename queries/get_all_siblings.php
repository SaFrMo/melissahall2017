<?php
    global $post;

    $formatted = serializer_standard($post);

    $args = array(
        'posts_per_page'    => -1,
        'post_type'         => 'page',
        'post_parent'       => $post->post_parent,
        'orderby'           => 'menu_order',
        'order'             => 'ASC',
        'exclude'           => $post->ID
    );
    $sibling_post_objects = get_posts($args);
    $formatted['siblings'] = array();

    foreach( $sibling_post_objects as $sibling_post_object ){
        $formatted['siblings'][] = serializer_standard($sibling_post_object);
    }

    $formatted['next'] = serializer_standard($next);
    $formatted['prev'] = serializer_standard($prev);

    $data = array( $formatted );
