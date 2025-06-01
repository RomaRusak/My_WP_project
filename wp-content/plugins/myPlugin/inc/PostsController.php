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

        $this->save_related_terms($post_id, 'custom-taxonomy-2');
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

    private function save_related_terms($post_id, $taxonomy_name) {
        $all_terms = get_terms([
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false, 
        ]);

        $selected_term_ids = [];
        
        foreach($all_terms as $term_data) {
            $term_id = $term_data->term_id;
            $input_name = 'related_term_' . $term_id;
            
            if (!array_key_exists($input_name, $_POST)) {
                continue;
            }

            $input_value = $_POST[$input_name];

            if ($input_value === 'on') {
                $selected_term_ids[] = $term_id;
            }
        }

        wp_set_post_terms($post_id, $selected_term_ids, $taxonomy_name);
    }
}