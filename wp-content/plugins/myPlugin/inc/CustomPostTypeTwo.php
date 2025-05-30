<?php

class CustomPostTypeTwo {
    private $custom_post_type = 'custom_post2'; 

    public function create_post() {
        register_post_type( $this->custom_post_type, [
            'labels' => [
                'name'               => 'My Custom Posts 2',
                'singular_name'      => 'My Custom Post 2',
                'add_new'            => 'Add New My Custom Post 2',
                'add_new_item'       => 'Add New My Custom Post 2', 
                'edit_item'          => 'Edit My Custom Post 2',
                'new_item'           => 'New My Custom Post 2',
                'view_item'          => 'View My Custom Post 2',
                'search_items'       => 'Search My Custom Posts 2', 
                'not_found'          => 'No My Custom Posts 2 Found', 
                'not_found_in_trash' => 'No My Custom Posts 2 Found in Trash', 
                'menu_name'          => 'My Custom Posts 2',
		],
            'public' => false, 
            'show_ui' => true, 
            'show_in_menu' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor'],
        ]);
    }

    public function add_meta_boxes() {
        add_meta_box('custom-type-2-metabox', 'Custom post 2 setting', function($post) {
            $field_1_value = get_post_meta($post->ID, 'custom_post2_field1', true) ?? '';
            $options = [
                'type 1',
                'type 2',
                'type 3',
            ];
            ?>
                <label for="custom_post2_field1">
                    Field 1
                    <select name="custom_post2_field1" id="custom_post2_field1">
                        <option value="">Select</option>
                        <?php
                            foreach ($options as $value) {
                                $isSelected = ($field_1_value === $value) ? 'selected' : '';
                                echo "<option value='{$value}' {$isSelected}>{$value}</option>";
                            }
                        ?>
                    </select>
                </label>
            <?php
       }, $this->custom_post_type);
    }
}