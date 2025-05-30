<?php
/*
Plugin Name: myPlugin
Plugin URI: https://wordpress.org/
Description: my Plugin description
Version: 1.0
Author: Raman
*/

require_once plugin_dir_path(__FILE__) . './inc/TaxonomiesController.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomTaxonomyOne.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomPostTypeOne.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomPostTypeTwo.php';
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
        $this->posts_controller->init_posts();
        $this->taxonomies_controller->init_taxonomies();
    }
}

if (class_exists('MyPlugin')) {
    $custom_post_type_one = new CustomPostTypeOne();
    $custom_post_type_two = new CustomPostTypeTwo();
    $posts_controller = new PostsController($custom_post_type_one, $custom_post_type_two);
    
    $custom_taxonomy_one = new CustomTaxonomyOne();
    $taxonomies_controller = new TaxonomiesController($custom_taxonomy_one);

    $myPlugin = new MyPlugin($posts_controller,$taxonomies_controller,);

    $myPlugin->init();
}
