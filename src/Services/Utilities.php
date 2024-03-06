<?php

namespace App\Services;

use DateTime;
use DateTimeImmutable;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class Utilities
{
    function __construct(
        #[Autowire('%imageFile%')]
        private string $imageFile,
    ) {
    }

    public function getFile()
    {
        return $this->imageFile;
    }

    public function formatDate(DateTimeImmutable $date)
    {
        $fechaActual = new DateTimeImmutable();
        return $fechaActual->diff($date)->format(("%R%a dias %H horas %I minutos %S segundos"));
    }
}
