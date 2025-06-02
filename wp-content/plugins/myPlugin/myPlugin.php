<?php
/*
Plugin Name: myPlugin
Plugin URI: https://wordpress.org/
Description: my Plugin description
Version: 1.0
Author: Raman
*/

require_once plugin_dir_path(__FILE__) . './inc/TaxonomiesController.php';
require_once plugin_dir_path(__FILE__) . './inc/taxonomies/CustomTaxonomyOne.php';
require_once plugin_dir_path(__FILE__) . './inc/taxonomies/CustomTaxonomyTwo.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomPostsFactory.php';
require_once plugin_dir_path(__FILE__) . './inc/posts/CustomPostTypeOne.php';
require_once plugin_dir_path(__FILE__) . './inc/posts/CustomPostTypeTwo.php';
require_once plugin_dir_path(__FILE__) . './inc/PostsController.php';


class MyPlugin {

    private $posts_controller = null;
    private $taxonomies_controller = null;

    public function __construct(
        PostsController      $posts_controller,
        TaxonomiesController $taxonomies_controller,
    )
    {
        $this->posts_controller      = $posts_controller;
        $this->taxonomies_controller = $taxonomies_controller;
    }

    public function init() {
        $this->taxonomies_controller->init_taxonomies();

        $this->posts_controller->init_self();
        $this->posts_controller->init_posts();
    }
}

if (class_exists('MyPlugin')) {
    $custom_posts_factory = new CustomPostsFactory(CustomPostTypeOne::class, CustomPostTypeTwo::class);

    $posts_controller = new PostsController(
        $custom_posts_factory,
        [
            'custom_post_type' => 'custom_post1',
            'custom_field1_name' => 'custom_post1_field1',
            'custom_field2_name' => 'custom_post1_field2',
        ],
        [
            'custom_post_type' => 'custom_post2',
            'custom_field2_name' => 'custom_post2_field1',
        ],    
    );
    
    $custom_taxonomy_one = new CustomTaxonomyOne();
    $custom_taxonomy_two = new CustomTaxonomyTwo();
    $taxonomies_controller = new TaxonomiesController(
        $custom_taxonomy_one,
        $custom_taxonomy_two,
    );

    $myPlugin = new MyPlugin($posts_controller,$taxonomies_controller,);

    $myPlugin->init();
}
