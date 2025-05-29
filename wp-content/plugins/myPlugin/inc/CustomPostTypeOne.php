<?php

class CustomPostTypeOne {
    public function create_post() {
        register_post_type( 'my-custom-type-1', [
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
        $property_1_value = get_post_meta($post->ID, 'property_1', true) ?? '';
            ?>
                <label for="property_1">
                    property 1
                    <input 
                    type="text" 
                    id="property_1" 
                    name="property_1"
                    value="<?=$property_1_value;?>"
                    >
                </label>
            <?php
       }, 'my-custom-type-1');
    }
}

