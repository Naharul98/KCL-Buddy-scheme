<?php

namespace App\Http\Controllers\Home_Area;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Home Page Controller
|--------------------------------------------------------------------------
|
| This controller is responsible for handling views in the HomePage of the
| website
*/

class InformationController extends Controller
{
    /**
     * returns view for the 'learn more' page of the website
     *
     * @return view
     */
    public function learnMore()
    {
    	return view('home_area.learnMore');
    }
}
