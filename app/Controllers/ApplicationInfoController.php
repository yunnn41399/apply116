<?php
namespace App\Controllers;
use App\Controllers\BaseController;
class ApplicationInfoController extends BaseController
{
    public function index()
    {
        return view(
            'Home/application_info'
        );
    }
}