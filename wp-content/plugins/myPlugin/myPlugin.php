<?php
/*
Plugin Name: myPlugin
Plugin URI: https://wordpress.org/
Description: my Plugin description
Version: 1.0
Author: Raman
*/

require_once plugin_dir_path(__FILE__) . './inc/CustomTaxonomiesController.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomTaxonomiesFactory.php';
require_once plugin_dir_path(__FILE__) . './inc/taxonomies/CustomTaxonomyOne.php';
require_once plugin_dir_path(__FILE__) . './inc/taxonomies/CustomTaxonomyTwo.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomPostsFactory.php';
require_once plugin_dir_path(__FILE__) . './inc/posts/CustomPostTypeOne.php';
require_once plugin_dir_path(__FILE__) . './inc/posts/CustomPostTypeTwo.php';
require_once plugin_dir_path(__FILE__) . './inc/CustomPostsController.php';


class MyPlugin {

    private $custom_posts_controller      = null;
    private $custom_taxonomies_controller = null;

    public function __construct(
        CustomPostsController      $custom_posts_controller,
        CustomTaxonomiesController $custom_taxonomies_controller
    )
    {
        $this->custom_posts_controller      = $custom_posts_controller;
        $this->custom_taxonomies_controller = $custom_taxonomies_controller;
    }

    public function init() {
        $this->custom_taxonomies_controller->init_self();
        $this->custom_taxonomies_controller->init_taxonomies();

        $this->custom_posts_controller->init_self();
        $this->custom_posts_controller->init_posts();
    }
}

if (class_exists('MyPlugin')) {
    $custom_posts_factory = new CustomPostsFactory(CustomPostTypeOne::class, CustomPostTypeTwo::class);

    $custom_posts_controller = new CustomPostsController(
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

    $custom_taxonomies_factory = new CustomTaxonomiesFactory(CustomTaxonomyOne::class, CustomTaxonomyTwo::class);
    $custom_taxonomies_controller = new CustomTaxonomiesController($custom_taxonomies_factory);

    $myPlugin = new MyPlugin($custom_posts_controller, $custom_taxonomies_controller);

    $myPlugin->init();
}