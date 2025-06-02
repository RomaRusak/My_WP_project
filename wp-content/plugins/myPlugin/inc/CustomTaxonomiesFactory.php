<?php

require_once plugin_dir_path(__FILE__) . '/interfaces/FactoryInterface.php';

class CustomTaxonomiesFactory implements FactoryInterface {

    private $customTaxonomyOneClass;
    private $customTaxonomyTwoClass;

    public function __construct(
        string $custom_taxonomy_one_class,
        string $custom_taxonomy_two_class,
    ) {
        $this->customTaxonomyOneClass = $custom_taxonomy_one_class;
        $this->customTaxonomyTwoClass = $custom_taxonomy_two_class;
    }

    public function create(string $type, array $constructor_args = []) {
        switch ($type) {
            case 'one':
                return new $this->customTaxonomyOneClass($constructor_args);
            case 'two':
                return new $this->customTaxonomyTwoClass($constructor_args);
        }
    }
}