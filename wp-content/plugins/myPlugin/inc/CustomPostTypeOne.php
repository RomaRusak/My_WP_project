<?php

use function PHPSTORM_META\type;

class CustomPostTypeOne {
    private $custom_post_type = 'custom_post1'; 
    
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

    public function add_meta_boxes() {
       add_meta_box('custom-type-1-metabox', 'Custom post 1 setting', function($post) {
        $field_1_value = get_post_meta($post->ID, 'custom_post1_field1', true) ?? '';
            ?>
                <label for="custom_post1_field1">
                    Field 1
                    <input 
                    type="text" 
                    id="custom_post1_field1" 
                    name="custom_post1_field1"
                    value="<?=$field_1_value;?>"
                    >
                </label>
            <?php
       }, $this->custom_post_type);

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

        $field_2_value = (int) get_post_meta($post->ID, 'custom_post1_field2', true) ?? '';

        $options = array_map(function($post) {
            return [
                'id' => $post->ID,
                'post_title' => $post->post_title,
            ];
        
        }, $all_type2_posts);
            ?>
                <label for="custom_post1_field2">
                   <select name="custom_post1_field2" id="custom_post1_field2">
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
    }

   
}

