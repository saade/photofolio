<?php

namespace SaadeMotion\Photofolio\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        \Validator::extend('slug', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value);
        }, 'Slug pode conter apenas letras, números e hífens.');
    }
}
