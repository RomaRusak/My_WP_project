<?php

require_once plugin_dir_path(__FILE__) . '../interfaces/TaxonomyCreatableInterface.php';

class CustomTaxonomyTwo implements TaxonomyCreatableInterface{
    private $custom_taxonomy_name = 'custom-taxonomy-2';

    public function init() {
        add_action('init', [$this, 'create_taxonomy']);
    }

    public function create_taxonomy() {
        $args = [
            'label' => 'Custom Taxonomy 2',
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
        ];

        register_taxonomy($this->custom_taxonomy_name , ['custom_post2'], $args);
    }
}