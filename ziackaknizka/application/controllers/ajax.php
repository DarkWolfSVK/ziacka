<?php 
session_start(); //we need to call PHP's session object to access it through CI
class ajax extends CI_Controller {
 
    function __construct()
    {
     parent::__construct();
    $this->load->model('usermodel','',TRUE);
    }

    function ziak()
    {
      header('Content-type: application/json');
      if ($this->session->userdata['logged_in'] == false)
      {
        return false;
      }
      $result = $this->usermodel->get_ziak_znamky($this->session->userdata('result')->id);
      $znamky = [];
      foreach($result as $row) {
          if(!isset($znamky[$row->nazov])) $znamky[$row->nazov]= [];
          $znamky[$row->nazov][] = $row->znamka;
      }
      echo json_encode($znamky);
    }

    function ucitel()
    {
      header('Content-type: application/json');
      if ($this->session->userdata['logged_in'] == false || $this->session->userdata('result')->rola != "1")
      {
        return false;
      }
      $vsetko = [];
      $vsetko['triedy'] = $this->usermodel->get_triedy();
      $vsetko['ziaci'] = $this->usermodel->get_ziaci();
      $vsetko['predmety'] = $this->usermodel->get_predmety();
      $vsetko['znamky'] = $this->usermodel->get_znamky();
      $znamky = [];
      foreach ($vsetko['znamky'] as $row) {
          if(empty($znamky[$row->ziak])) $znamky[$row->ziak] = [];
          if(empty($znamky[$row->ziak][$row->predmet])) $znamky[$row->ziak][$row->predmet] = [];
          $znamky[$row->ziak][$row->predmet][$row->id] = $row->znamka;
      }
      $vsetko['znamky'] = $znamky;

      echo json_encode($vsetko);
       
    }

    function deleteznamka($id)
    {
      header('Content-type: application/json');
      if ($this->session->userdata['logged_in'] == false || $this->session->userdata('result')->rola != "1")
      {
        return false;
      }
      echo json_encode(['result' => (bool)$this->usermodel->delete_znamka($id)]);
    }

    function addznamka($ziak, $predmet, $znamka)
    {
      if ($this->session->userdata['logged_in'] == false || $this->session->userdata('result')->rola != "1")
      {
        return false;
      }

      $result = $this->usermodel->add_znamku(['ziak' => $ziak, 'predmet' => $predmet, 'znamka' => $znamka]);
      echo json_encode(['result' => $result]);


    }
   
}
 
?>