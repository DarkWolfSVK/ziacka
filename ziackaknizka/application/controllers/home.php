<?php 
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {
 
  function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    if($this->session->userdata('logged_in'))
    {
      $session_data = $this->session->userdata('logged_in');
      $data['data'] = $this->session->userdata('result');
      
      if($this->session->userdata('result')->rola == "1")
      {
        $this->load->view('ucitel_view', $data);
      }
      else
      {
        $this->load->view('ziak_view', $data);
      }
     
    }
    else
    {   
      redirect('login', 'refresh');
    }
  }


  function logout()
  {
    $this->session->unset_userdata('logged_in');
    $this->session->unset_userdata('result');
    session_destroy();
    redirect('login');
  }
 
}
 
?>