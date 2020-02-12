<?php

class adminPage
{
    // functions
    public function kd_create_cpt()
    {

        $labels = array(
            'name'                  => 'KD Parallax',
            'singular_name'         => 'KD Parallax',
            'menu_name'             =>  'KD Parallax'
        );

        $args = array(
            'label'                 => 'KD Parallax',
            'description'           => 'Add beautiful parallax effect to your web page',
            'labels'                => $labels,
            'supports'              => false,
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-tide',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );

        register_post_type('kd-parallax', $args);
    }

}
