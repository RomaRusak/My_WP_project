<?php

class PostsController {
    private $custom_post_type_one;
    private $custom_post_type_two;

    public function __construct(
        CustomPostTypeOne $custom_post_type_one,
        CustomPostTypeTwo $custom_post_type_two,
    )
    {
        $this->custom_post_type_one = $custom_post_type_one;
        $this->custom_post_type_two = $custom_post_type_two;
    }

    public function init_posts() {
        add_action('init', [$this, 'create_custom_post_types']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes'],);
        add_action('save_post', [$this, 'save_posts_meta'], 10, 2);
    }

     public function create_custom_post_types() {
        $this->custom_post_type_one->create_post();
        $this->custom_post_type_two->create_post();
    }

    public function add_meta_boxes() {
        $this->custom_post_type_one->add_meta_boxes();
        $this->custom_post_type_two->add_meta_boxes();
    }
   
    public function save_posts_meta($post_id, $post) {
        $this->save_meta_field($post_id, 'custom_post1_field1', $_POST['custom_post1_field1'] ?? null);
        $this->save_meta_field($post_id, 'custom_post2_field1', $_POST['custom_post2_field1'] ?? null);
        $this->save_meta_field($post_id, 'custom_post1_field2', $_POST['custom_post1_field2'] ?? null);
    }

    private function save_meta_field($post_id, $field_name, $value) {
        if (empty($value)) {
            return;
        }

        if ($value === '') {
            delete_post_meta($post_id, $field_name);
            return;
        }

        update_post_meta($post_id, $field_name, sanitize_text_field($value));
    }
}