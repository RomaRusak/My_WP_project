<?php

require_once plugin_dir_path(__FILE__) . '../interfaces/PostCreatbleInterface.php';
require_once plugin_dir_path(__FILE__) . '../interfaces/PostCustFieldsCreateableInterface.php';

class CustomPostTypeOne implements PostCreatbleInterface, PostCustFieldsCreateableInterface{
    private $custom_post_type = null; 
    private $custom_field1_name = null;
    private $custom_field2_name = null;

    public function __construct(
        array $constructor_args
    )
    {
        $this->custom_post_type = $constructor_args['custom_post_type'];
        $this->custom_field1_name = $constructor_args['custom_field1_name'];
        $this->custom_field2_name = $constructor_args['custom_field2_name'];
    }
    
    public function create_post() {
        register_post_type( $this->custom_post_type, [
            'labels' => [
                'name'               => 'My Custom Posts 1',
                'singular_name'      => 'My Custom Post 1',
                'add_new'            => 'Add New My Custom Post 1',
                'add_new_item'       => 'Add New My Custom Post 1', 
                'edit_item'          => 'Edit My Custom Post 1',
                'new_item'           => 'New My Custom Post 1',
                'view_item'          => 'View My Custom Post 1',
                'search_items'       => 'Search My Custom Posts 1', 
                'not_found'          => 'No My Custom Posts 1 Found', 
                'not_found_in_trash' => 'No My Custom Posts 1 Found in Trash', 
                'menu_name'          => 'My Custom Posts 1',
		    ],
            'public' => true, 
            'show_in_rest' => true,
            'supports' => ['title', 'editor'],
        ]);
    }

    public function add_custom_acf_fields() {
        acf_add_local_field_group([
            'key'    => 'custom_post1_first_group',
            'title'  => 'Custom Field for Post1',
            'fields' => [
                    [
                        'key' => 'post1_field1_text',
                        'label' => 'text Field',
                        'name' => $this->custom_field1_name,
                        'type' => 'text',
                        'maxlength' => '20',
                        'placeholder' => 'Enter your text',
                        'wrapper' => [
                            'width' => '20%',
                        ],
                    ],
                    [
                        'key' => 'post1_field2_relationsip',
                        'label' => 'related post Field',
                        'name' => $this->custom_field2_name,
                        'type' => 'relationship',
                        'post_type' => 'custom_post2',
                        'filters' => ['post_type'],
                    ],
            ],
            'location' => [
                    [
                        [
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => $this->custom_post_type,
                        ],
                    ],
                ],

        ]);

        add_filter('acf/fields/relationship/query', function ($args) {
             $args['meta_query'] = [
                [
                    'key' => 'custom_post2_field1',
                    'value' => 'type_2',
                    'compare' => '='
                ]
            ];
            return $args;
        }, 10, 3);
    }

    public function add_meta_boxes() {
        /*
        add_meta_box('custom-type-1-metabox', 'Custom post 1 setting', function($post) {
            $field_name = $this->custom_field1_name;
            $field_1_value = get_post_meta($post->ID, $field_name, true) ?? '';
            ?>
            <label for="<?=$field_name ?>">
            Field 1
            <input 
            type="text" 
            id="<?=$field_name ?>" 
            name="<?=$field_name ?>"
            value="<?=$field_1_value;?>"
            >
            </label>
            <?php
        }, $this->custom_post_type);
        */

        /*
        add_meta_box('custom-type-3-metabox', 'Related post 2', function($post) {
 
         $all_type2_posts = get_posts([
             'post_type'   => 'custom_post2',
             'meta_query' => [
                 [
                     'key' => 'custom_post2_field1',
                     'value' => 'type 2'
                 ],
             ]
         ]);
 
         $field_name = $this->custom_field2_name;
         $field_2_value = (int) get_post_meta($post->ID, $field_name, true) ?? '';
 
         $options = array_map(function($post) {
             return [
                 'id' => $post->ID,
                 'post_title' => $post->post_title,
             ];
         
         }, $all_type2_posts);
             ?>
                 <label for="<?=$field_name ?>">
                    <select name="<?=$field_name ?>" id="<?=$field_name ?>">
                         <option value="">Select related post</option>
                          <?php
                             foreach ($options as $value) {
                                 $isSelected = ($field_2_value === $value['id']) ? 'selected' : '';
                                 $option_value = $value['id'];
                                 $option_label = $value['post_title'] . ", post id: " . $value['id'];
 
                                 echo "<option value='{$option_value}' {$isSelected}>{$option_label}</option>";
                             }
                         ?>
                    </select>
                 </label>
             <?php
        }, $this->custom_post_type);
        */
    }

   
}

