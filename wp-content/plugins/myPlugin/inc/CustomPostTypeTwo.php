<?php

class CustomPostTypeTwo {
    public function create_post() {
        register_post_type( 'my-custom-type-2', [
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
            $property_2_value = get_post_meta($post->ID, 'property_2', true) ?? '';
            $options = [
                'type 1',
                'type 2',
                'type 3',
            ];
            ?>
                <label for="property_2">
                    property 2
                    <select name="property_2" id="property_2">
                        <option value="">Select property 2</option>
                        <?php
                            foreach ($options as $value) {
                                $isSelected = ($property_2_value === $value) ? 'selected' : '';
                                echo "<option value='{$value}' {$isSelected}>{$value}</option>";
                            }
                        ?>
                    </select>
                </label>
            <?php
       }, 'my-custom-type-2');
    }
}