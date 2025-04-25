<?php

namespace Nuazsa\MailSender\Services;

/**
 * @author Nur Azis Saputra <nurazissaputra.com>
 */
class View
{
    public static function render(string $view, array $model = []) 
    {
        require __DIR__ . '/../View/' . $view . '.php';
    }
}