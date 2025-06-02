<?php

interface FactoryInterface {
    public function create(string $type, array $constructor_args = []);
}