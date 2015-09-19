<?php 

namespace App\Controllers;

use App\System\Controller;

class GalleryController extends Controller
{

	public function index()
	{
		return $this->view('pages/gallery');
	}

	public function cars()
	{
		return $this->view('pages/gallery-cars');
	}

	public function showCar($id)
	{
		echo $id;
	}
}