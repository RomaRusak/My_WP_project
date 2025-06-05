<?php

require_once plugin_dir_path(__FILE__) . '../interfaces/TaxonomyCreatableInterface.php';
require_once plugin_dir_path(__FILE__) . '../interfaces/TaxonomyCustFieldsCreateableInterface.php';
require_once plugin_dir_path(__FILE__) . '../interfaces/TaxonomyCustFieldsEditableInterface.php';

class CustomTaxonomyOne implements TaxonomyCreatableInterface, TaxonomyCustFieldsCreateableInterface, TaxonomyCustFieldsEditableInterface{

    private $custom_taxonomy_name = 'custom-taxonomy-1';
    private $custom_field1_name = 'taxonomy1_field_1';
    private $custom_field2_name = 'taxonomy1_field_2';

    public function init() {

        
        add_action('init', [$this, 'create_taxonomy']);

        add_action( 'acf/init', [$this, 'add_custom_acf_fields']);

        add_action($this->custom_taxonomy_name  . '_add_form_fields', [$this, 'add_meta_box']);
        add_action($this->custom_taxonomy_name . "_edit_form_fields", [$this, 'edit_custom_fields']);

        add_action('created_' . $this->custom_taxonomy_name , [$this, 'save_meta_box'], 10, 1);
        add_action('edited_' . $this->custom_taxonomy_name , [$this, 'save_meta_box'], 10, 1);
    }

    function add_custom_acf_fields() {
        acf_add_local_field_group([
            'key'    => 'acf_img_field',
            'title'  => 'Custom Field for Taxonomy',
            'fields' => [
                    [
                        'key' => 'taxonomy1_field_1_image',
                        'label' => 'Image Field',
                        'name' => $this->custom_field1_name,
                        'type' => 'image',
                        'return_format' => 'url',
                        'min_width' => 0,
                        'max_height' => 2000,
                    ],
            ],
            'location' => [
                    [
                        [
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => $this->custom_taxonomy_name,
                        ],
                    ],
                ],
            
        ]);
    }


    public function create_taxonomy() {
        $args = [
            'label' => 'Custom Taxonomy 1',
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ];

        register_taxonomy($this->custom_taxonomy_name , ['custom_post1'], $args);
    }

    public function add_meta_box() {
        $custom_taxonomy1_field2 = ['name' => $this->custom_field2_name, 'value' => false];
        ?>
            <div class="form-field" style="display: flex; align-items: center; gap: 10px">
                <label for="<?= $custom_taxonomy1_field2['name'] ?>">Custom Field 2</label>
                <input 
                type="hidden" 
                name="<?= $custom_taxonomy1_field2['name'] ?>" 
                value="off"
                >
                <input 
                type="checkbox" 
                name="<?= $custom_taxonomy1_field2['name'] ?>" 
                id="<?= $custom_taxonomy1_field2['name'] ?>" 
                <?php if ($custom_taxonomy1_field2['value']) {echo 'checked';}?>
                >
            </div>
            <!-- <div class="form-field" style="display: flex; align-items: center; gap: 10px">
                <label for="image_field">
                    Image field
                </label>
                <input type="file" name="image_field" id="image_field"/>
            </div> -->
        <?php
    }

    public function save_meta_box($term_id) { 
        if (!isset($_POST[$this->custom_field2_name])) {
            return;
        }

        $field_2_value = $_POST[$this->custom_field2_name] === 'on' ? 1 : 0;

        update_term_meta( $term_id, $this->custom_field2_name, $field_2_value);
    }

    public function edit_custom_fields($term) {
        $custom_taxonomy1_field2_value = get_term_meta( $term->term_id, $this->custom_field2_name, true);
        ?>
		<tr class="form-field">
			<th scope="row" valign="top"><label>Custom Field 2</label></th>
			<td>
                <input 
                type="hidden" 
                name="<?= $this->custom_field2_name; ?>" 
                value="off"
                >
				<input 
                type="checkbox" 
                name="<?= $this->custom_field2_name; ?>" 
                <?= $custom_taxonomy1_field2_value ? 'checked' : ''; ?>
                >
                <br />
				<span class="description">Custom Field 2 description</span>
			</td>
		</tr>
		<
	<?php
    }
}

