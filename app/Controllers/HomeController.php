<?php 

namespace App\Controllers;

use App\System\Controller;
use App\Models\User;

class HomeController extends Controller
{

	public function index()
	{	
		return $this->view('pages/home');
	}

	public function contact()
	{
		return $this->view('pages/contact');
	}
}