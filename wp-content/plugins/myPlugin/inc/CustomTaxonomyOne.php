<?php

class CustomTaxonomyOne {

    private $custom_taxonomy_name = 'custom-taxonomy-1';
    private $custom_field2_name = 'field 2';

    public function __construct()
    {
        add_action('init', [$this, 'create_taxonomy']);
        add_action($this->custom_taxonomy_name  . '_add_form_fields', [$this, 'add_meta_box']);
        add_action('created_' . $this->custom_taxonomy_name , [$this, 'save_meta_box'], 10, 1);
        add_filter('manage_edit-' . $this->custom_taxonomy_name . '_columns', [$this, 'add_custom_taxonomy_column']);
    }

    public function create_taxonomy() {
        $args = [
            'label' => 'Custom Taxonomy 1',
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ];

        register_taxonomy($this->custom_taxonomy_name , ['my-custom-type-1'], $args);
    }

    public function add_meta_box($term_name) {
        $custom_taxonomy_1_field_2 = ['name' => $this->custom_field2_name, 'value' => true];
        ?>
            <div class="form-field" style="display: flex; align-items: center; gap: 10px">
                <label for="<?= $custom_taxonomy_1_field_2['name'] ?>">Custom Field 2</label>
                <input 
                type="hidden" 
                name="<?= $custom_taxonomy_1_field_2['name'] ?>" 
                value="off"
                >
                <input 
                type="checkbox" 
                name="<?= $custom_taxonomy_1_field_2['name'] ?>" 
                id="<?= $custom_taxonomy_1_field_2['name'] ?>" 
                <?php if ($custom_taxonomy_1_field_2['value']) {echo 'checked';}?>
                >
            </div>
        <?php
    }

    public function save_meta_box($term_id) {
       if (!isset($_POST[$this->custom_field2_name])) {
        return;
       }

       $field_2_value = $_POST[$this->custom_field2_name] === 'on' ? true: false;

       update_term_meta( $term_id, $this->custom_field2_name, $field_2_value);
    }

    public function add_custom_taxonomy_column($columns) {
        $columns['custom_field_2'] = $this->custom_field2_name;
        return $columns;
    }
}

