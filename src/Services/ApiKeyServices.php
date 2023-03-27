<?php
namespace App\Services;

use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Component\HttpFoundation\Request;

Class ApiKeyServices{
    /**
     * @param Request $request
     * @return bool 
     */
    public function chechApiKey(Request $request): Bool
    {
        $API_KEY = $request->headers->get('API-KEY');

        if (strlen($API_KEY))
            $output = true;
        else 
            $output = false;

        return $output;
    }
}