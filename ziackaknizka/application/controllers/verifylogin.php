<?php
 
class VerifyLogin extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('usermodel','',TRUE);
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('prihlasovacie_meno', 'prihlasovacie_meno', 'trim|required|xss_clean');
   $this->form_validation->set_rules('heslo', 'heslo', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run())
   {
     //Field validation failed.  User redirected to login page

   $meno = ($_POST['prihlasovacie_meno']);
   $pass = sha1($_POST['heslo']);
   $this->check_database($pass);
   if ($this->session->userdata['logged_in'] == true)
     {
     var_dump($this->session->userdata);
      // $this->session->set_userdata($data);
       redirect('home');
     }
     else
     {
      echo "chyba";
     }
   }
   else
   {
     //Go to private area

     $this->load->view('login_view');
   }
 
 }
 
 function check_database($heslo)
 {
   //Field validation succeeded.  Validate against database
   $prihlasovacie_meno = $this->input->post('prihlasovacie_meno');
 
   //query the database
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