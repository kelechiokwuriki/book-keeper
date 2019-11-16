<?php


namespace App\Services;


use App\Interfaces\Formatter;

trait FormatterService
{
    public function format($data, Formatter $formatter) {
        return $formatter->format($data);
    }
}