<?php
 
class VerifyLogin extends CI_Controller {
 
  function __construct()
  {
    parent::__construct();
    $this->load->model('usermodel','',TRUE);
  }

  function index()
  {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('prihlasovacie_meno', 'prihlasovacie_meno', 'trim|required|xss_clean');
    $this->form_validation->set_rules('heslo', 'heslo', 'trim|required|xss_clean|callback_check_database');

    if($this->form_validation->run())
    {

    if ($this->session->userdata['logged_in'] == true)
      {
        redirect('home');
      }
      else
      {
        $this->load->view('login_view');
      }
    }
    else
    {
      $this->load->view('login_view');
    }

  }

  function check_database($heslo)
  {
    $prihlasovacie_meno = $this->input->post('prihlasovacie_meno');

    $result = $this->usermodel->login($prihlasovacie_meno, $heslo);
    $result = $result['0'];
    
    if($result)
    {
      $data['result'] = $result;
      $data['logged_in'] = true;
      $this->session->set_userdata($data);
      return TRUE;
    }
    else
    {
      $this->form_validation->set_message('check_database', 'Invalid username or password');
      return false;
    }
  }
}
?>