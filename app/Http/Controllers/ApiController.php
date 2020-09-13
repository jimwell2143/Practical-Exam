<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Traits\ThrottlesLogins;

class ApiController extends Controller
{
    use ApiResponse, ThrottlesLogins;
}
