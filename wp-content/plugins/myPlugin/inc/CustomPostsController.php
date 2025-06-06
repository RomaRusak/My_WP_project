<?php

require_once plugin_dir_path(__FILE__) . 'interfaces/FactoryInterface.php';

class CustomPostsController {
    private $custom_posts_factory = null;
    private $custom_post_type_one = null;
    private $custom_post_type_two = null;
    private $custom_post_type_one_data = [];
    private $custom_post_type_two_data = [];

    public function __construct(
        FactoryInterface   $custom_posts_factory,
        array              $custom_post_type_one_data,
        array              $custom_post_type_two_data
    )
    {
        $this->custom_posts_factory = $custom_posts_factory;

        $this->custom_post_type_one_data = $custom_post_type_one_data;
        $this->custom_post_type_two_data = $custom_post_type_two_data;
    }

    public function init_self() {
        $this->custom_post_type_one = $this->custom_posts_factory->create('one', $this->custom_post_type_one_data);

        $this->custom_post_type_two = $this->custom_posts_factory->create('two', $this->custom_post_type_two_data);
    }


    public function init_posts() {

        add_action('init', [$this, 'create_custom_post_types']);

        add_action( 'acf/init', [$this, 'add_custom_acf_fields']);
        
        add_action('add_meta_boxes', [$this, 'add_meta_boxes'],);
        add_action('save_post', [$this, 'save_posts_meta'], 10, 2);
    }

    public function create_custom_post_types() {
        $this->custom_post_type_one->create_post();
        $this->custom_post_type_two->create_post();
    }

    public function add_custom_acf_fields() {
        $this->custom_post_type_one->add_custom_acf_fields();
        $this->custom_post_type_two->add_custom_acf_fields();
    }

    public function add_meta_boxes() {
        $this->custom_post_type_one->add_meta_boxes();
        $this->custom_post_type_two->add_meta_boxes();
    }
   
    public function save_posts_meta($post_id) {
        // $this->save_meta_field(
        //     $post_id, 
        //     $this->custom_post_type_one_data['custom_field1_name'], 
        //     $_POST[$this->custom_post_type_one_data['custom_field1_name']] ?? null
        // );

        // $this->save_meta_field(
        //     $post_id, 
        //     $this->custom_post_type_two_data['custom_field2_name'], 
        //     $_POST[$this->custom_post_type_two_data['custom_field2_name']] ?? null);

        // $this->save_meta_field(
        //     $post_id, 
        //     $this->custom_post_type_one_data['custom_field2_name'], 
        //     $_POST[$this->custom_post_type_one_data['custom_field2_name']] ?? null);

        // $this->save_related_terms($post_id, 'custom-taxonomy-2');
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