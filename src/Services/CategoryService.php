<?php

namespace App\Services;

class CategoryService
{
    private $categories = array();

    public function __construct()
    {
        $this->categories = array(
            array(
                'category' => 'Categoria 1',
                'description' => 'Descripción de la categoría 1',
            ),
            array(
                'category' => 'Categoria 5',
                'description' => 'Descripción de la categoría 5',
            )
        );
    }

    public function getNotes()
    {
        return $this->categories;
    }
}
