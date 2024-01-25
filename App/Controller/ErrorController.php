<?php

namespace App\Controller;

class ErrorController
{
    public function error(string $errorMessage): void
    {
        $message = $errorMessage;

        require(__DIR__ . '/../../templates/error/error.php');
    }
}
