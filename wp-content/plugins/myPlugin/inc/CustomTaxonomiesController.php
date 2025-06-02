<?php

require_once plugin_dir_path(__FILE__) . 'interfaces/FactoryInterface.php';

class CustomTaxonomiesController {
    private $custom_taxonomy_one       = null;
    private $custom_taxonomy_two       = null;
    private $custom_taxonomies_factory = null;
    
    public function __construct(
        FactoryInterface $custom_taxonomies_factory
    )
    {
        $this->custom_taxonomies_factory = $custom_taxonomies_factory;
    }

    public function init_self() {
        $this->custom_taxonomy_one = $this->custom_taxonomies_factory->create('one');
        $this->custom_taxonomy_two = $this->custom_taxonomies_factory->create('two');
    }
    
    public function init_taxonomies() {
        $this->custom_taxonomy_one->init();
        $this->custom_taxonomy_two->init();
    }
}