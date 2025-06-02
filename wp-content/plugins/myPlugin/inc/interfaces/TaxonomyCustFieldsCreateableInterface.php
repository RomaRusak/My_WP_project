<?php

interface TaxonomyCustFieldsCreateableInterface {
    public function add_meta_box();
    public function save_meta_box(int $term_id);
}