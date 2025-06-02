<?php

require_once plugin_dir_path(__FILE__) . '/interfaces/FactoryInterface.php';

class CustomPostsFactory implements FactoryInterface {

    private $customPostTypeOneClass;
    private $customPostTypeTwoClass;

    public function __construct(
        string $custom_post_type_one_class,
        string $custom_post_type_two_class,
    ) {
        $this->customPostTypeOneClass = $custom_post_type_one_class;
        $this->customPostTypeTwoClass = $custom_post_type_two_class;
    }

    public function create(string $type, array $constructor_args = []) {
        switch ($type) {
            case 'one':
                return new $this->customPostTypeOneClass($constructor_args);
            case 'two':
                return new $this->customPostTypeTwoClass($constructor_args);
        }
    }
}