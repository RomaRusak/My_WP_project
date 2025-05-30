<?php

class TaxonomiesController {
    private $custom_taxonomy_one = null;
    
    public function __construct(
        CustomTaxonomyOne $custom_taxonomy_one
    )
    {
        $this->custom_taxonomy_one = $custom_taxonomy_one;
    }
    
    public function init_taxonomies() {
        $this->custom_taxonomy_one->init();
    }
}