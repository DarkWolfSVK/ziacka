<?php 
class userController extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('userModel');

		$this->load->helper('form');
		
	}

	function index()
	{
		$this->load->view('login_view');
	}


}	