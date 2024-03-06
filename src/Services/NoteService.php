<?php

namespace App\Services;

use DateTimeImmutable;

class NoteService
{
    private $notes = array();

    public function __construct()
    {
        $this->notes = array(
            array(
                'description' => 'Nota 1',
                'createdAt' => new DateTimeImmutable("2018-05-2"),
                'idCategory' => 1
            ),
            array(
                'description' => 'Nota 2',
                'createdAt' => new DateTimeImmutable("2013-05-2"),
                'idCategory' => 2
            ),
            array(
                'description' => 'Nota 3',
                'createdAt' => new DateTimeImmutable("2017-05-2"),
                'idCategory' => 1
            ),
            array(
                'description' => 'Nota 4',
                'createdAt' => new DateTimeImmutable("2015-05-2"),
                'idCategory' => 2
            ),
            array(
                'description' => 'Nota 5',
                'createdAt' => new DateTimeImmutable("2017-05-2"),
                'idCategory' => 1
            )
        );
    }

    public function getNotes()
    {
        return $this->notes;
    }
}
