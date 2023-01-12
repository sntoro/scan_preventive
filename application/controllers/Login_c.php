<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_c extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->layout = 'template/layout';
    }

    public function index()
    {
        $data['error'] = NULL;
        $data['content'] = 'login_v';
        $this->load->view('/template/layout', $data);
    }

    public function try_login($npk)
    {
        $data['CHR_NPK'] = $npk;
        if (strlen($npk) < 4) {
            $npk = sprintf("%04d", $npk);
        } else if (strlen($npk) == 6 && substr($npk, 0, 2) == "00") {
            $npk = substr($npk, 2, 4);
        } else if (strlen($npk) == 6 && substr($npk, 0, 1) == "0" && substr($npk, 1, 1) <> "0") {
            $npk = substr($npk, 1, 5);
        }

        $sql = $this->db->query("SELECT * FROM TM_USER WHERE ltrim(rtrim(CHR_NPK))='$npk'"); 

        if ($sql->num_rows() > 0) {

            $user_session = array(
                'ip' => $_SERVER['REMOTE_ADDR'],
                'npk' => $npk,
                'username' => $sql->row()->CHR_USERNAME,   
                'flag' => true
            );
            $this->session->set_userdata($user_session);

            redirect('Scan_c');
        } else {

            $data['error'] = "ERR";
            $data['content'] = 'login_v';
            $this->load->view('/template/layout', $data);
        }
    }
}
