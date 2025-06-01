<?php

class TaxonomiesController {
    private $custom_taxonomy_one = null;
    private $custom_taxonomy_two = null;
    
    public function __construct(
        CustomTaxonomyOne $custom_taxonomy_one,
        CustomTaxonomyTwo $custom_taxonomy_two,
    )
    {
        $this->custom_taxonomy_one = $custom_taxonomy_one;
        $this->custom_taxonomy_two = $custom_taxonomy_two;
    }
    
    public function init_taxonomies() {
        $this->custom_taxonomy_one->init();
        $this->custom_taxonomy_two->init();
    }
}