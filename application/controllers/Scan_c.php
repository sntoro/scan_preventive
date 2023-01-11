<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scan_c extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['npk'])) {
            redirect('Login_c');
        }

        $this->load->model('Scan_m');
    }

    public function index()
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $pic = $_SESSION['npk'];
        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $data['content'] = '/main_menu_v';
        $this->load->view('/template/layout', $data);
    }

    public function scan_qr_part($id_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $data['id_type'] = $id_type;
        $data['content'] = '/scan_qr_part_v';
        $this->load->view('/template/layout', $data);
    }

    public function detail_menu($qrcode, $id_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $pic = $_SESSION['npk'];
        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $data['qrcode'] = $qrcode;
        $data['id_type'] = $id_type;
        $get_data = $this->Scan_m->get_data_part_mte(str_replace("--", "/", $qrcode), $id_type);
        // $get_drw_type = $this->Scan_m->get_drawing_type($id_type);

        if ($get_data->num_rows() > 0) {
            $result = $get_data->row();
            $data['data'] = $result;
            if ($result->INT_FLAG_STAT == 1) { //===== Stat : On Preventive
                $get_progress = $this->Scan_m->get_data_prev_by_id_part($result->INT_ID);
                $data['progress'] = $get_progress->row();
            } else if ($result->INT_FLAG_STAT == 2) { //===== Stat : On Repair
                $get_progress = $this->Scan_m->get_data_repair_by_id_part($result->INT_ID);
                $data['progress'] = $get_progress->row();
            }

            $data['content'] = '/detail_menu_v';
        } else {
            $data['error'] = 'QR CODE TIDAK TERDAFTAR';
            $data['content'] = '/scan_qr_part_v';
        }

        $this->load->view('/template/layout', $data);
    }

    public function scan_electrode()
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $data['content'] = '/menu_electrode_v';
        $this->load->view('/template/layout', $data);
    }

    public function augmented()
    {
        // $this->load->view('/menu_augmented_v');
        $this->load->view('/menu_augmented_v3_v');
    }

    public function scan_qr()
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $data['content'] = '/scan_v';
        $this->load->view('/template/layout', $data);
    }

    public function scan_repair()
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $query = $this->Scan_m->get_data_part_repair();
        $result = $query->result();
        $data['result'] = $result;

        $data['content'] = '/scan_repair_v';
        $this->load->view('/template/layout', $data);
    }

    public function process_repair($qr_no = NULL)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $status = '-';
        if ($qr_no == NULL || $qr_no == '') {
            $qr_no = '';
        } else {
            $query = $this->Scan_m->get_data_part_repair_by_qr($qr_no);
            if ($query->num_rows() == 0) {
                $data['error'] = 'QR TRAY TIDAK DI LIST REPAIR';
                $query = $this->Scan_m->get_data_part_repair();
                $result = $query->result();
                $data['result'] = $result;

                $data['status'] = $status;
                $data['qr_no'] = $qr_no;

                $data['content'] = '/scan_repair_v';
                $this->load->view('/template/layout', $data);
            } else {
                $line = substr($qr_no, 0, 6);
                $check = $this->Scan_m->get_data_part_repair_first($line);
                if ($check->num_rows() > 0) {
                    $qr_repair_first = $check->row()->CHR_PART_CODE;
                    if ($qr_no == $qr_repair_first) {
                        $data['success'] = 'SUCCESS SCAN QR TRAY';
                        $result = $query->row();
                        $status = $result->INT_FLG_REPAIR;

                        $data['result'] = $result;
                        $data['status'] = $status;
                        $data['qr_no'] = $qr_no;

                        $data['content'] = '/process_repair_v';
                        $this->load->view('/template/layout', $data);
                    } else {
                        $data['error'] = 'PRIORITAS REPAIR TRAY SALAH';
                        $query = $this->Scan_m->get_data_part_repair();
                        $result = $query->result();
                        $data['result'] = $result;

                        $data['status'] = $status;
                        $data['qr_no'] = $qr_no;

                        $data['content'] = '/scan_repair_v';
                        $this->load->view('/template/layout', $data);
                    }
                } else {
                    $data['success'] = 'SUCCESS SCAN QR TRAY';
                    $result = $query->row();
                    $status = $result->INT_FLG_REPAIR;

                    $data['result'] = $result;
                    $data['status'] = $status;
                    $data['qr_no'] = $qr_no;

                    $data['content'] = '/process_repair_v';
                    $this->load->view('/template/layout', $data);
                }
            }
        }
    }

    public function scan_prev($qr_old)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $data['qr_no'] = $qr_old;
        $data['qr_new'] = '';

        if (is_null($qr_old) || $qr_old == '') {
            redirect('Scan_c');
        }

        $query = $this->Scan_m->get_data_part($qr_old);

        if ($query->num_rows() <= 0) {
            $data['error'] = 'QR TRAY TIDAK TERDAFTAR';
            $data['content'] = '/scan_v';
            $this->load->view('/template/layout', $data);
        } else {
            $result = $query->result();
            if ($result[0]->INT_FLAG_USED == 0 || $result[0]->INT_FLAG_USED == NULL) {
                $data['error'] = 'QR TRAY SEDANG TIDAK DIPAKAI';
                $data['content'] = '/scan_v';
                $this->load->view('/template/layout', $data);
            } else {
                $data['part_code_new'] = '-';
                $data['part_name_new'] = '-';
                $data['model_new'] = '-';
                $data['match'] = '-';

                $data['success'] = 'QR TRAY LAMA BERHASIL DISCAN';
                $data['result'] = $result;
                $data['content'] = '/scan_qrcode_v';
                $this->load->view('/template/layout', $data);
            }
        }
    }

    public function scan_new_qr($qr_old, $qr_new)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $data['qr_no'] = $qr_old;
        $data['qr_new'] = $qr_new;

        $npk = $_SESSION['npk'];

        if (is_null($qr_new) || $qr_new == '') {
            redirect('Scan_c/scan_new_qr/' . $qr_old . '/err');
        } else if ($qr_new == $qr_old) {
            redirect('Scan_c/scan_new_qr/' . $qr_old . '/err');
        }

        $query = $this->Scan_m->get_data_part($qr_old);
        $result = $query->result();
        $data['result'] = $result;

        $part_code_new = '-';
        $part_name_new = '-';
        $model_new = '-';
        $match = '-';

        //===== Common function for all type of preventive -- Match by dies name + part no
        // foreach($result as $row){
        //     $part_no = $row->CHR_PART_NO;
        //     $query = $this->Scan_m->get_data_new_part($qr_new, $part_no);
        //     if($query->num_rows() > 0){
        //         $part_code_new = $query->row()->CHR_PART_CODE;
        //         $part_name_new = $query->row()->CHR_PART_NAME;
        //         $model_new = $query->row()->CHR_MODEL;
        //         $match = 'OK';
        //     }
        // }

        //===== Only for Electrode -- Match by dies name + day name
        // $day = date('l'); //===== Get today's name
        // $last_id = '';
        // if($day == 'Monday'){
        //     $last_id = '00A';
        // } elseif($day == 'Tuesday'){
        //     $last_id = '00B';
        // } elseif($day == 'Wednesday'){
        //     $last_id = '00C';
        // } elseif($day == 'Thursday'){
        //     $last_id = '00D';
        // } elseif($day == 'Friday'){
        //     $last_id = '00E';
        // }

        //===== Only for Electrode -- Match by dies name sequence
        $last_id = '';
        if (substr($qr_old, 6, 3) == '00A') {
            $last_id = '00B';
        } elseif (substr($qr_old, 6, 3) == '00B') {
            $last_id = '00C';
        } elseif (substr($qr_old, 6, 3) == '00C') {
            $last_id = '00D';
        } elseif (substr($qr_old, 6, 3) == '00D') {
            $last_id = '00A';
        }

        if (substr($qr_new, 0, 6) == substr($qr_old, 0, 6) && substr($qr_new, 6, 3) == $last_id) {
            $check_repair = $this->Scan_m->get_data_part_repair_by_qr($qr_new);
            if ($check_repair->num_rows() > 0) {
                $part_code_new = '-';
                $part_name_new = '-';
                $model_new = '-';
                $match = 'ER';
            } else {
                $query_new = $this->Scan_m->get_data_part($qr_new);
                $result_new = $query_new->result();
                $part_code_new = $result_new[0]->CHR_PART_CODE;
                $part_name_new = $result_new[0]->CHR_PART_NAME;
                $model_new = $result_new[0]->CHR_MODEL;
                $match = 'OK';
            }
        }

        // print_r($day);
        // exit();

        $data['part_code_new'] = $part_code_new;
        $data['part_name_new'] = $part_name_new;
        $data['model_new'] = $model_new;
        $data['match'] = $match;

        if ($match == 'OK') {
            $data['success'] = 'QR TRAY BARU COCOK';
            $data['content'] = '/scan_qrcode_v';
            $this->load->view('/template/layout', $data);
        } else if ($match == 'ER') {
            $data['error'] = 'QR TRAY BARU DIREPAIR';
            $data['content'] = '/scan_qrcode_v';
            $this->load->view('/template/layout', $data);
        } else {
            $data['error'] = 'QR TRAY BARU TIDAK COCOK';
            $data['content'] = '/scan_qrcode_v';
            $this->load->view('/template/layout', $data);
        }
    }

    public function save_preventive($qr_old, $qr_new)
    {
        $query = $query = $this->Scan_m->get_data_part($qr_old);
        $result = $query->result();

        $pic = $_SESSION['npk'];
        $datenow = date('Ymd');
        $timenow = date('His');

        $notes = $this->input->post("notes");

        //===== Insert into TT_PREVENTIVE
        $data = array(
            'CHR_TYPE' => $result[0]->CHR_TYPE,
            'CHR_PART_CODE' => $qr_old,
            'INT_COUNT' => $result[0]->INT_STROKE_BIG_PREVENTIVE,
            'INT_PLAN_COUNT' => $result[0]->INT_STROKE_BIG_PREVENTIVE,
            'CHR_TYPE_PREV' => 'S',
            'CHR_CREATED_BY' => $pic,
            'CHR_CREATED_DATE' => $datenow,
            'CHR_CREATED_TIME' => $timenow,
            'INT_ID_PART' => $result[0]->INT_ID,
            'CHR_REMARKS' => $qr_new . ';' . $notes

        );
        $this->Scan_m->save_prev($data);

        //===== Insert into TT_REPAIR_PREVENTIVE
        $data = array(
            'INT_ID_PART' => $result[0]->INT_ID,
            'CHR_PART_CODE' => $qr_old,
            'INT_FLG_REPAIR' => '0',
            'CHR_CREATED_BY' => $pic,
            'CHR_CREATED_DATE' => $datenow,
            'CHR_CREATED_TIME' => $timenow

        );
        $this->Scan_m->save_repair($data);

        //===== Update TM_PARTS_MTE for New Tray
        $data = array(
            'INT_STROKE_BIG_PREVENTIVE' => $result[0]->INT_STROKE_BIG_PREVENTIVE,
            'INT_FLAG_USED' => '1',
            'CHR_MODIFIED_BY' => $pic,
            'CHR_MODIFIED_DATE' => $datenow,
            'CHR_MODIFIED_TIME' => $timenow
        );
        $this->Scan_m->update_part($data, $qr_new);

        //===== Update TM_PARTS_MTE for Old Tray
        $data = array(
            'INT_FLAG_USED' => '0',
            'CHR_MODIFIED_BY' => $pic,
            'CHR_MODIFIED_DATE' => $datenow,
            'CHR_MODIFIED_TIME' => $timenow
        );
        $this->Scan_m->update_part($data, $qr_old);

        $data['success'] = "QR TRAY BERHASIL DI PROCESS";
        $data['content'] = '/scan_v';
        $this->load->view('/template/layout', $data);
        $this->output->_display();
        exit();
    }

    public function start_repair($qr_no)
    {

        $pic = $_SESSION['npk'];
        $datenow = date('Ymd');
        $timenow = date('His');

        //===== Update TT_REPAIR_PREVENTIVE for Old Tray
        $data = array(
            'INT_FLG_REPAIR' => '1',
            'CHR_START_REPAIR_BY' => $pic,
            'CHR_START_REPAIR_DATE' => $datenow,
            'CHR_START_REPAIR_TIME' => $timenow
        );
        $this->Scan_m->update_start_repair($data, $qr_no);

        $query = $this->Scan_m->get_data_part_repair();
        $result = $query->result();
        $data['result'] = $result;

        $data['success'] = "TRAY BISA MULAI DIREPAIR";
        $data['content'] = '/scan_repair_v';
        $this->load->view('/template/layout', $data);
        $this->output->_display();
        exit();
    }

    public function finish_repair($qr_no)
    {

        $pic = $_SESSION['npk'];
        $datenow = date('Ymd');
        $timenow = date('His');

        $notes = $this->input->post("notes");

        //===== Update TT_REPAIR_PREVENTIVE for Old Tray
        $data = array(
            'INT_FLG_REPAIR' => '2',
            'CHR_FINISH_REPAIR_BY' => $pic,
            'CHR_FINISH_REPAIR_DATE' => $datenow,
            'CHR_FINISH_REPAIR_TIME' => $timenow,
            'CHR_REMARKS' => $notes
        );
        $this->Scan_m->update_finish_repair($data, $qr_no);

        $query = $this->Scan_m->get_data_part_repair();
        $result = $query->result();
        $data['result'] = $result;

        $data['success'] = "TRAY SELESAI DIREPAIR";
        $data['content'] = '/scan_repair_v';
        $this->load->view('/template/layout', $data);
        $this->output->_display();
        exit();
    }

    public function closed()
    {
        session_destroy();
        redirect("Login_c");
    }

    public function get_detail_part_no()
    {

        $id_part = $this->input->post("id");

        $query = $this->Scan_m->get_data_part_no($id_part);
        $result = $query->result();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_detail_part_no()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>List Part Number</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        $data .= '             <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '               <thead>';
        $data .= '                 <tr>';
        $data .= '                   <th>No</th>';
        $data .= '                   <th>Work Center</th>';
        $data .= '                   <th>Part No</th>';
        $data .= '                   <th>Back No</th>';
        $data .= '                   <th>Part Name</th>';
        $data .= '                 </tr>';
        $data .= '               </thead>';
        $data .= '               <tbody>';

        $no = 1;
        foreach ($result as $row) {
            $data .= '<tr>';
            $data .= '<td>' . $no . '</td>';
            $data .= '<td>' . trim($row->CHR_WORK_CENTER) . '</td>';
            $data .= '<td>' . trim($row->CHR_PART_NO) . '</td>';
            $data .= '<td>' . trim($row->CHR_BACK_NO) . '</td>';
            $data .= '<td>' . trim($row->CHR_PART_NAME) . '</td>';
            $data .= '</tr>';
            $no++;
        }

        $data .= '               </tbody>';
        $data .= '             </table>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function get_drawing_type()
    {

        $id_part = $this->input->post("part");
        $id_type = $this->input->post("type");

        $get_drw_type = $this->Scan_m->get_drawing_type($id_part, $id_type);
        $result = $get_drw_type->result();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_drawing_type()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Drawing Type</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $no = 1;
        foreach ($result as $row) {
            $data .= '<div>';
            $data .= '<a class="btn btn-default" href="' . base_url("index.php/Scan_c/show_list_drawing/" . $id_part . "/" . $id_type . "/" . trim($row->CHR_DRAWING_TYPE)) . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">' . strtoupper(trim($row->CHR_DRAWING_TYPE)) . '</a>';
            $data .= '</div>';
            $data .= '</br>';
            $no++;
        }

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function show_list_drawing($id_part, $id_type, $drw_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_drw_list = $this->Scan_m->get_drawing_list($id_part, $drw_type);
        $result = $get_drw_list->result();

        $get_part = $this->Scan_m->get_data_part_mte_by_id($id_part);
        $part = $get_part->row();

        $data['data'] = $result;
        $data['qrcode'] = trim($part->CHR_PART_CODE);
        $data['id_type'] = $id_type;
        $data['drw_type'] = $drw_type;
        $data['content'] = '/show_list_drawing_v';
        $this->load->view('/template/layout', $data);
    }

    public function view_drawing()
    {

        $id_drw = $this->input->post("id");

        $get_drw = $this->Scan_m->get_drawing_by_id($id_drw);
        $result = $get_drw->row();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog" style="width:1200px;">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_drawing()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Drawing - ' . strtoupper(trim($result->CHR_DRAWING_NAME)) . '</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $data .= '          <div>';

        $file_wi = explode(".", $result->CHR_FILE_DRAWING);
        $ext = end($file_wi);
        $ext = strtolower($ext);
        if ($ext == 'jpg' || $ext == 'jpeg') {
            // $data .= '              <img src="' . base_url("assets/images/drw/" . $result->CHR_FILE_DRAWING) . '" height="430px" width="500px" border="0">';
            $data .= '              <img src="' . base_url("assets/images/drw/" . $result->CHR_FILE_DRAWING) . '" border="0">';
        } else if ($ext == 'pdf') {
            $data .= '              <embed type="application/pdf" src="http://192.168.0.231/scan_preventive_v3/assets/images/drw/' . $result->CHR_FILE_DRAWING . '" width="800" height="900"></embed>';
        }

        $data .= '          </div>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function historical_preventive($part_code, $id_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_his_preventive = $this->Scan_m->get_historical_preventive(str_replace("--", "/", $part_code));
        $result = $get_his_preventive->result();

        $data['data'] = $result;
        $data['qrcode'] = trim($part_code);
        $data['id_type'] = $id_type;
        $data['content'] = '/historical_preventive_v';
        $this->load->view('/template/layout', $data);
    }

    public function historical_repair($part_code, $id_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_his_repair = $this->Scan_m->get_historical_repair(str_replace("--", "/", $part_code));
        $result = $get_his_repair->result();

        $data['data'] = $result;
        $data['qrcode'] = trim($part_code);
        $data['id_type'] = $id_type;
        $data['content'] = '/historical_repair_v';
        $this->load->view('/template/layout', $data);
    }

    public function historical_change($part_code, $id_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_his_change = $this->Scan_m->get_historical_change(str_replace("--", "/", $part_code));
        $result = $get_his_change->result();

        $data['data'] = $result;
        $data['qrcode'] = trim($part_code);
        $data['id_type'] = $id_type;
        $data['content'] = '/historical_change_v';
        $this->load->view('/template/layout', $data);
    }

    public function search_list_repair($part_code, $id_type, $key)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_his_repair = $this->Scan_m->get_historical_repair_by_key($part_code, $key);
        if ($get_his_repair->num_rows() > 0) {
            $result = $get_his_repair->result();
        } else {
            $get_his_repair = $this->Scan_m->get_historical_repair($part_code);
            $result = $get_his_repair->result();
        }

        $data['data'] = $result;
        $data['qrcode'] = trim($part_code);
        $data['id_type'] = trim($id_type);
        $data['content'] = '/historical_repair_v';
        $this->load->view('/template/layout', $data);
    }

    public function get_historical_type()
    {
        $part_code = $this->input->post("part");
        $id_type = $this->input->post("type");

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_historical_type()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Historical Type</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $data .= '<div>';
        $data .= '<a class="btn btn-default" href="' . base_url("index.php/Scan_c/historical_preventive/" . $part_code . "/" . $id_type) . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">PREVENTIVE</a>';
        $data .= '</div>';
        $data .= '</br>';
        $data .= '<div>';
        $data .= '<a class="btn btn-default" href="' . base_url("index.php/Scan_c/historical_repair/" . $part_code . "/" . $id_type) . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">REPAIR</a>';
        $data .= '</div>';
        $data .= '</br>';

        if ($id_type == 'B' || $id_type == 'C') {
            $data .= '<div>';
            $data .= '<a class="btn btn-default" href="' . base_url("index.php/Scan_c/historical_change/" . $part_code . "/" . $id_type) . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">CHANGE MODEL</a>';
            $data .= '</div>';
            $data .= '</br>';
        }

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function get_manual_type()
    {

        $id_part = $this->input->post("part");
        $id_type = $this->input->post("type");

        $group = 'WIS';
        $get_manual_type = $this->Scan_m->get_manual_type($group, $id_part, $id_type);
        $result = $get_manual_type->result();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_manual_type()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Manual Book Type</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $no = 1;
        foreach ($result as $row) {
            $data .= '<div>';
            $data .= '<a class="btn btn-default" href="' . base_url("index.php/Scan_c/show_list_manual/" . $id_part . "/" . $id_type . "/" . trim($row->CHR_WI_TYPE)) . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">' . strtoupper(trim($row->CHR_WI_TYPE)) . '</a>';
            $data .= '</div>';
            $data .= '</br>';
            $no++;
        }

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function show_list_manual($id_part, $id_type, $wi_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $group = 'WIS';
        $get_wi_list = $this->Scan_m->get_manual_list($group, $id_part, $wi_type);
        $result = $get_wi_list->result();

        $get_part = $this->Scan_m->get_data_part_mte_by_id($id_part);
        $part = $get_part->row();

        $data['data'] = $result;
        $data['qrcode'] = trim($part->CHR_PART_CODE);
        $data['id_type'] = $id_type;
        $data['wi_type'] = $wi_type;
        $data['content'] = '/show_list_manual_v';
        $this->load->view('/template/layout', $data);
    }

    public function view_manual()
    {

        $id_wi = $this->input->post("id");

        $get_wi = $this->Scan_m->get_manual_by_id($id_wi);
        $result = $get_wi->row();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog" style="width:1200px;">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_manual()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Manual Book - ' . strtoupper(trim($result->CHR_WI_NAME)) . '</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $data .= '          <div>';

        $file_wi = explode(".", $result->CHR_FILE_WI);
        $ext = end($file_wi);
        $ext = strtolower($ext);
        if ($ext == 'jpg' || $ext == 'jpeg') {
            // $data .= '              <img src="' . base_url("assets/images/wi/" . $result->CHR_FILE_WI) . '" height="430px" width="500px" border="0">';
            $data .= '              <img src="' . base_url("assets/images/wi/" . $result->CHR_FILE_WI) . '" border="0">';
        } else if ($ext == 'pdf') {
            $data .= '              <embed type="application/pdf" src="http://192.168.0.231/scan_preventive_v3/assets/images/wi/' . $result->CHR_FILE_WI . '" width="800" height="900"></embed>';
        }

        $data .= '          </div>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function process_preventive($id_part, $id_type, $stat)
    {

        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $datenow = date('Ymd');
        $timenow = date('His');

        if ($stat == '0') { //===== Start Preventive
            $get_data = $this->Scan_m->get_data_part_mte_by_id($id_part);
            $result = $get_data->row();

            //===== Data Prev
            $part_code = $result->CHR_PART_CODE;
            $flag_small_prev = $result->INT_SMALL_PREVENTIVE;
            $flag_big_prev = $result->INT_BIG_PREVENTIVE;
            $stroke_small_preventive =  $result->INT_STROKE_SMALL_PREVENTIVE;
            $stroke_big_preventive =  $result->INT_STROKE_BIG_PREVENTIVE;

            $get_prev = $this->Scan_m->get_data_prev_by_id_part($id_part);
            if ($get_prev->num_rows() > 0) {
                $data['npk'] = $pic;
                $data['username'] = $user;

                $data['qrcode'] = str_replace("/", "--", $result->CHR_PART_CODE);
                $data['id_type'] = $id_type;

                $data['error'] = 'ADA PROSES PREVENTIVE MASIH BERJALAN';

                if ($result->INT_FLAG_STAT == 1) { //===== Stat : On Preventive
                    $data['progress'] = $get_prev->row();
                } else if ($result->INT_FLAG_STAT == 2) { //===== Stat : On Repair
                    $get_progress = $this->Scan_m->get_data_repair_by_id_part($id_part);
                    $data['progress'] = $get_progress->row();
                }

                $data['content'] = '/detail_menu_v';
            } else {
                if ($id_type == 'A') { //===== MOLD
                    if ($flag_small_prev == 3) {
                        //===== Big Preventive
                        $get_stroke_now = $this->Scan_m->get_stroke_now_mold($part_code);
                        $stroke_now = $get_stroke_now[0]->STROKE;
                        $next_stroke_preventive = $stroke_now + $stroke_small_preventive;
                        $small_prev_next = 0;
                        $big_prev_next = $flag_big_prev + 1;
                        $type_prev = 'B';

                        $this->Scan_m->update_big_preventive($part_code, $small_prev_next, $big_prev_next, $datenow, $next_stroke_preventive);
                        $this->Scan_m->insert_transaction_preventive($id_type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id_part);
                    } else {
                        //===== Small Preventive
                        $remain_stroke_small_preventive =  $result->INT_REMAIN_SMALL;
                        $get_stroke_now = $this->Scan_m->get_stroke_now_mold($part_code);
                        $stroke_now = $get_stroke_now[0]->STROKE;
                        $next_stroke_preventive = $stroke_now + $stroke_small_preventive;
                        $small_prev_next = $flag_small_prev + 1;
                        $type_prev = 'S';
                        $this->Scan_m->update_small_preventive($part_code, $small_prev_next, $datenow, $next_stroke_preventive);
                        $this->Scan_m->insert_transaction_preventive($id_type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id_part);
                    }

                    $get_last_prev = $this->Scan_m->get_data_last_prev_by_part($part_code);
                    $last_prev = $get_last_prev->row();

                    $last_id_prev = $last_prev->INT_ID;
                    //===== Insert into MTE.TT_PREVENTIVE_DETAIL
                    $data = array(
                        'INT_ID_PREV' => $last_id_prev,
                        'INT_ID_PART' => $id_part,
                        'CHR_PART_CODE' => $part_code,
                        'INT_STROKE' => $stroke_now,
                        'INT_FLG_PREV' => '1',
                        'CHR_START_PREV_BY' => $pic,
                        'CHR_START_PREV_DATE' => $datenow,
                        'CHR_START_PREV_TIME' => $timenow,
                        'CHR_CREATED_BY' => $pic,
                        'CHR_CREATED_DATE' => $datenow,
                        'CHR_CREATED_TIME' => $timenow
                    );
                    $this->Scan_m->save_prev_detail($data);
                } else if ($id_type == 'B' || $id_type == 'C') { //===== DIES STP & DIES DF                    
                    if ($flag_small_prev == 3) {
                        //===== Big Preventive
                        if ($id_type == 'B' || $id_type == 'C') {
                            $get_stroke_now = $this->Scan_m->get_stroke_now_dies_stp($part_code);
                        } else {
                            $get_stroke_now = $this->Scan_m->get_stroke_now_dies_df($part_code);
                        }

                        if ($get_stroke_now->num_rows() > 0) {
                            $data_stroke = $get_stroke_now->result();
                            $stroke_now = $data_stroke[0]->STROKE;
                        } else {
                            $stroke_now = 0;
                        }

                        $next_stroke_preventive = $stroke_now + $stroke_small_preventive;
                        $small_prev_next = 0;
                        $big_prev_next = $flag_big_prev + 1;
                        $type_prev = 'B';

                        $this->Scan_m->update_big_preventive($part_code, $small_prev_next, $big_prev_next, $datenow, $next_stroke_preventive);
                        $this->Scan_m->insert_transaction_preventive($id_type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id_part);
                    } else {

                        //===== Small Preventive
                        $remain_stroke_small_preventive =  $result->INT_REMAIN_SMALL;
                        if ($id_type == 'B' || $id_type == 'C') {
                            $get_stroke_now = $this->Scan_m->get_stroke_now_dies_stp($part_code);
                        } else {
                            $get_stroke_now = $this->Scan_m->get_stroke_now_dies_df($part_code);
                        }

                        if ($get_stroke_now->num_rows() > 0) {
                            $data_stroke = $get_stroke_now->result();
                            $stroke_now = $data_stroke[0]->STROKE;
                        } else {
                            $stroke_now = 0;
                        }

                        $next_stroke_preventive = $stroke_now + $stroke_small_preventive;
                        $small_prev_next = $flag_small_prev + 1;
                        $type_prev = 'S';
                        $this->Scan_m->update_small_preventive($part_code, $small_prev_next, $datenow, $next_stroke_preventive);
                        $this->Scan_m->insert_transaction_preventive($id_type, $part_code, $stroke_now, $stroke_big_preventive, $type_prev, $pic, $datenow, $timenow, $id_part);
                    }

                    $get_last_prev = $this->Scan_m->get_data_last_prev_by_part($part_code);
                    $last_prev = $get_last_prev->row();

                    $last_id_prev = $last_prev->INT_ID;
                    //===== Insert into MTE.TT_PREVENTIVE_DETAIL
                    $data = array(
                        'INT_ID_PREV' => $last_id_prev,
                        'INT_ID_PART' => $id_part,
                        'CHR_PART_CODE' => $part_code,
                        'INT_STROKE' => $stroke_now,
                        'INT_FLG_PREV' => '1',
                        'CHR_START_PREV_BY' => $pic,
                        'CHR_START_PREV_DATE' => $datenow,
                        'CHR_START_PREV_TIME' => $timenow,
                        'CHR_CREATED_BY' => $pic,
                        'CHR_CREATED_DATE' => $datenow,
                        'CHR_CREATED_TIME' => $timenow
                    );
                    $this->Scan_m->save_prev_detail($data);
                }

                $get_last_prev = $this->Scan_m->get_data_prev_by_id_part($id_part);
                $status = '0';
                if ($get_last_prev->num_rows() > 0) {
                    $status = '1';
                    $data['progress'] = $get_last_prev->row();
                }

                $get_checksheet = $this->Scan_m->get_checksheet($id_type, $id_part);
                $checksheet = $get_checksheet->result();

                $data['npk'] = $pic;
                $data['username'] = $user;

                $data['qrcode'] = str_replace("/", "--", $result->CHR_PART_CODE);
                $data['id_part'] = $id_part;
                $data['id_type'] = $id_type;

                $data['checksheet'] = $checksheet;
                $data['status'] = $status;
                $data['content'] = '/process_preventive_v';
            }
        } else if ($stat == '1') { //===== Process to Finish Preventive
            $get_data = $this->Scan_m->get_data_part_mte_by_id($id_part);
            $result = $get_data->row();

            $get_last_prev = $this->Scan_m->get_data_prev_by_id_part($id_part);
            $status = '0';
            if ($get_last_prev->num_rows() > 0) {
                $status = '1';
                $data['progress'] = $get_last_prev->row();
            }

            $get_checksheet = $this->Scan_m->get_checksheet($id_type, $id_part);
            $checksheet = $get_checksheet->result();

            $data['npk'] = $pic;
            $data['username'] = $user;

            $data['qrcode'] = str_replace("/", "--", $result->CHR_PART_CODE);
            $data['id_part'] = $id_part;
            $data['id_type'] = $id_type;

            $data['checksheet'] = $checksheet;
            $data['status'] = $status;
            $data['content'] = '/process_preventive_v';
        } else { //===== Process to View Preventive

            $id_prev = $id_part; //===== Variable $id_part digunakan untuk $id_prev
            $get_data = $this->Scan_m->get_data_part_mte_by_id_prev($id_prev);
            $result = $get_data->row();

            $get_prev_data = $this->Scan_m->get_data_prev_by_id_prev($id_prev);
            if ($get_prev_data->num_rows() > 0) {
                $data['progress'] = $get_prev_data->row();
                $id_part = $get_prev_data->row()->INT_ID_PART;
            } else {
                $get_prev_old = $this->Scan_m->get_data_prev_by_id_prev_old($id_prev);
                $data['progress'] = $get_prev_old->row();
                $id_part = $get_prev_old->row()->INT_ID_PART;
            }

            $status = '2';

            $get_checksheet = $this->Scan_m->get_checksheet($id_type, $id_part);
            $checksheet = $get_checksheet->result();

            $data['npk'] = $pic;
            $data['username'] = $user;

            $data['qrcode'] = str_replace("/", "--", $result->CHR_PART_CODE);
            // $data['id_part'] = $result->INT_ID;
            $data['id_part'] = $id_part;
            $data['id_type'] = $id_type;

            $data['checksheet'] = $checksheet;
            $data['status'] = $status;
            $data['content'] = '/process_preventive_v';
        }

        $this->load->view('/template/layout', $data);
    }

    public function process_confirm_preventive($id_prev_detail, $id_type)
    {

        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $datenow = date('Ymd');
        $timenow = date('His');

        //===== Update into TT_PREVENTIVE_DETAIL
        $row = array(
            'INT_FLG_CONFIRM' => 1, //===== Update flag CONFIRM
            'CHR_CONFIRM_BY' => $pic,
            'CHR_CONFIRM_DATE' => date('Ymd'),
            'CHR_CONFIRM_TIME' => date('His')
        );
        $this->Scan_m->update_finish_prev_by_id($row, $id_prev_detail);

        $get_prev_data = $this->Scan_m->get_data_prev_by_id_prev_detail($id_prev_detail);
        $data['progress'] = $get_prev_data->row();
        $status = '2';

        $id_part = $get_prev_data->row()->INT_ID_PART;
        $get_checksheet = $this->Scan_m->get_checksheet($id_type, $id_part);
        $checksheet = $get_checksheet->result();

        $data['npk'] = $pic;
        $data['username'] = $user;

        $data['qrcode'] = $get_prev_data->row()->CHR_PART_CODE;
        $data['id_part'] = $id_part;
        $data['id_type'] = $id_type;

        $data['checksheet'] = $checksheet;
        $data['status'] = $status;
        $data['content'] = '/process_preventive_v';

        $this->load->view('/template/layout', $data);
    }

    public function finish_preventive($id_prev_detail)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $pic = $_SESSION['npk'];
        $datenow = date('Ymd');
        $timenow = date('His');

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $id_part = $this->input->post("id_part");
        $id_type = $this->input->post("id_type");
        $radio = $this->input->post("opt_radio");
        $trans_type = 'P';

        $get_data = $this->Scan_m->get_data_part_mte_by_id($id_part);
        $result = $get_data->row();
        $qr_no = trim($result->CHR_PART_CODE);

        $flag_sp = 0;
        if ($radio == 0) {
            $check_sp = $this->Scan_m->get_data_sparepart_usage_by_id_trans($trans_type, $id_prev_detail);
            if ($check_sp->num_rows() > 0) {
                $data_save = array(
                    'INT_FLG_DELETE' => 1,
                    'CHR_MODIFIED_BY' =>  $pic,
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
                );
                $this->Scan_m->update_spare_part_by_id_trans($id_prev_detail, $trans_type, $data_save);
            }
        } else {
            $flag_sp = 1;
        }

        $notes = $this->input->post("notes");

        if (isset($_POST['finish'])) {
            //===== Finish TT_PREVENTIVE_DETAIL
            $row = array(
                'INT_FLG_SPARE_PART' => $flag_sp,
                'INT_FLG_PREV' => '2',
                'CHR_FINISH_PREV_BY' => $pic,
                'CHR_FINISH_PREV_DATE' => $datenow,
                'CHR_FINISH_PREV_TIME' => $timenow,
                'CHR_REMARKS' => $notes
            );
            $this->Scan_m->update_finish_prev_by_id($row, $id_prev_detail);

            //===== Update into TM_PARTS_MTE
            $row = array(
                'INT_FLAG_STAT' => 0 //===== Update flag TM_PARTS_MTE
            );
            $this->Scan_m->update_part($row, $qr_no);
        } else if (isset($_POST['update'])) {
            //===== Update MTE.TT_PREVENTIVE_DETAIL
            $row = array(
                'INT_FLG_SPARE_PART' => $flag_sp,
                'CHR_MODIFIED_BY' => $pic,
                'CHR_MODIFIED_DATE' => $datenow,
                'CHR_MODIFIED_TIME' => $timenow,
                'CHR_REMARKS' => $notes
            );
            $this->Scan_m->update_finish_prev_by_id($row, $id_prev_detail);
        }

        $data['qrcode'] = $qr_no;
        $data['id_part'] = $id_part;
        $data['id_type'] = $id_type;

        $get_prev = $this->Scan_m->get_data_prev_by_id_prev_detail($id_prev_detail);
        $data['progress'] = $get_prev->row();

        $get_checksheet = $this->Scan_m->get_checksheet($id_type, $id_part);
        $checksheet = $get_checksheet->result();
        $data['checksheet'] = $checksheet;

        $data['status'] = $get_prev->row()->INT_FLG_PREV;
        $data['data'] = $result;
        $data['content'] = '/process_preventive_v';

        $this->load->view('/template/layout', $data);
    }

    public function get_failure_type()
    {

        $id_part = $this->input->post("part");
        $id_type = $this->input->post("type");

        $group = 'FTA';
        $get_manual_type = $this->Scan_m->get_manual_type($group, $id_part, $id_type);
        $result = $get_manual_type->result();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_failure_type()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Failure Tree Type</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $no = 1;
        foreach ($result as $row) {
            $data .= '<div>';
            $data .= '<a class="btn btn-default" href="' . base_url("index.php/Scan_c/show_list_failure/" . $id_part . "/" . $id_type . "/" . trim($row->CHR_WI_TYPE)) . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">' . strtoupper(trim($row->CHR_WI_TYPE)) . '</a>';
            $data .= '</div>';
            $data .= '</br>';
            $no++;
        }

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function show_list_failure($id_part, $id_type, $wi_type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $group = 'FTA';
        $get_wi_list = $this->Scan_m->get_manual_list($group, $id_part, $wi_type);
        $result = $get_wi_list->result();

        $get_part = $this->Scan_m->get_data_part_mte_by_id($id_part);
        $part = $get_part->row();

        $data['data'] = $result;
        $data['qrcode'] = trim($part->CHR_PART_CODE);
        $data['id_type'] = $id_type;
        $data['wi_type'] = $wi_type;
        $data['content'] = '/show_list_failure_tree_v';
        $this->load->view('/template/layout', $data);
    }

    public function view_failure()
    {

        $id_wi = $this->input->post("id");

        $get_wi = $this->Scan_m->get_manual_by_id($id_wi);
        $result = $get_wi->row();

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog" style="width:1200px;">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_failure()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Failure Tree - ' . strtoupper(trim($result->CHR_WI_NAME)) . '</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $data .= '          <div>';
        // $data .= '              <img src="' . base_url("assets/images/wi/" . $result->CHR_FILE_WI) . '" height="430px" width="500px" border="0">';
        $data .= '              <img src="' . base_url("assets/images/wi/" . $result->CHR_FILE_WI) . '" border="0">';
        $data .= '          </div>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function process_repair_v2($id_part, $id_type, $stat)
    {

        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        if ($stat == '2') {
            $get_data = $this->Scan_m->get_data_part_mte_by_id_repair($id_part);
            $result = $get_data->row();
            $data['id_part'] = $result->INT_ID;
        } else {
            $get_data = $this->Scan_m->get_data_part_mte_by_id($id_part);
            $result = $get_data->row();
            $data['id_part'] = $id_part;
        }

        $date_prev = $result->CHR_DATE_BIG_PREVENTIVE;
        $get_stroke = $this->Scan_m->get_actual_stroke($id_part, $date_prev);
        $act_stroke = $get_stroke->row()->TOTAL;

        if ($stat == '0') { //===== Start Repair
            $get_repair = $this->Scan_m->get_data_repair_by_id_part($id_part);
            if ($get_repair->num_rows() > 0) {
                $data['npk'] = $pic;
                $data['username'] = $user;

                $qrcode = $result->CHR_PART_CODE;
                $data['qrcode'] = str_replace("/", "--", $qrcode);
                $data['id_type'] = $result->CHR_TYPE;

                $data['error'] = 'ADA PROSES REPAIR MASIH BERJALAN';
                $data['data'] = $result;

                if ($result->INT_FLAG_STAT == 1) { //===== Stat : On Preventive
                    $get_progress = $this->Scan_m->get_data_prev_by_id_part($id_part);
                    $data['progress'] = $get_progress->row();
                } else if ($result->INT_FLAG_STAT == 2) { //===== Stat : On Repair
                    $data['progress'] = $get_repair->row();
                }

                $data['content'] = '/detail_menu_v';
            } else {
                //===== Insert into TT_REPAIR_PREVENTIVE
                $row = array(
                    'INT_ID_PART' => $id_part,
                    'CHR_PART_CODE' => $result->CHR_PART_CODE,
                    'INT_STROKE' => $act_stroke,
                    'INT_FLG_REPAIR' => '1',
                    'CHR_START_REPAIR_BY' =>  $_SESSION['npk'],
                    'CHR_START_REPAIR_DATE' => date('Ymd'),
                    'CHR_START_REPAIR_TIME' => date('His'),
                    'CHR_CREATED_BY' =>  $_SESSION['npk'],
                    'CHR_CREATED_DATE' => date('Ymd'),
                    'CHR_CREATED_TIME' => date('His')
                );
                $this->Scan_m->save_repair($row);

                //===== Update into TM_PARTS_MTE
                $row = array(
                    'INT_FLAG_STAT' => 2 //===== Update flag stat to REPAIR
                );
                $this->Scan_m->update_part($row, $result->CHR_PART_CODE);

                $data['npk'] = $pic;
                $data['username'] = $user;

                $qrcode = $result->CHR_PART_CODE;
                $data['qrcode'] = str_replace("/", "--", $qrcode);
                $data['id_type'] = $result->CHR_TYPE;

                $get_repair = $this->Scan_m->get_data_repair_by_id_part($id_part);
                $status = '0';
                if ($get_repair->num_rows() > 0) {
                    $status = '1';
                    $data['progress'] = $get_repair->row();
                }

                $data['status'] = $status;
                $data['content'] = '/process_repair_v2_v';
            }
        } else if ($stat == '1') { //===== Process to Finish Repair
            $data['npk'] = $pic;
            $data['username'] = $user;

            $qrcode = $result->CHR_PART_CODE;
            $data['qrcode'] = str_replace("/", "--", $qrcode);
            $data['id_type'] = $result->CHR_TYPE;

            $get_repair = $this->Scan_m->get_data_repair_by_id_part($id_part);
            $status = '0';
            if ($get_repair->num_rows() > 0) {
                $status = '1';
                $data['progress'] = $get_repair->row();
            }

            $data['status'] = $status;
            $data['content'] = '/process_repair_v2_v';
        } else { //===== Process to View Repair
            $id_repair = $id_part; //===== Variable $id_part digunakan untuk $id_repair

            $data['npk'] = $pic;
            $data['username'] = $user;

            $get_repair = $this->Scan_m->get_data_repair_by_id_repair($id_repair);
            $data['progress'] = $get_repair->row();
            $status = '2';

            $qrcode = $get_repair->row()->CHR_PART_CODE;
            $data['qrcode'] = str_replace("/", "--", $qrcode);
            $data['id_part'] = $get_repair->row()->INT_ID_PART;
            $data['id_type'] = $id_type;

            $data['status'] = $status;
            $data['content'] = '/process_repair_v2_v';
        }

        $this->load->view('/template/layout', $data);
    }

    public function process_confirm_repair($id_repair, $id_type)
    {

        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $data['npk'] = $pic;
        $data['username'] = $user;

        //===== Update into TT_REPAIR_PREVENTIVE
        $row = array(
            'INT_FLG_CONFIRM' => 1, //===== Update flag CONFIRM
            'CHR_CONFIRM_BY' => $pic,
            'CHR_CONFIRM_DATE' => date('Ymd'),
            'CHR_CONFIRM_TIME' => date('His')
        );
        $this->Scan_m->update_repair_by_id($row, $id_repair);

        $get_repair = $this->Scan_m->get_data_repair_by_id_repair($id_repair);
        $data['progress'] = $get_repair->row();
        $status = '2';

        $data['qrcode'] = $get_repair->row()->CHR_PART_CODE;
        $data['id_part'] = $get_repair->row()->INT_ID_PART;
        $data['id_type'] = $id_type;

        $data['status'] = $status;
        $data['content'] = '/process_repair_v2_v';

        $this->load->view('/template/layout', $data);
    }

    public function view_repair()
    {

        $id_part = $this->input->post("id");
        $id_type = $this->input->post("type");

        $get_repair = $this->Scan_m->get_data_repair_by_id_part($id_part);

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_repair()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Process Repair</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $data .= '          <div>';
        if ($get_repair->num_rows() > 0) {
            $data .= '             <a class="btn btn-default" href="' . base_url("index.php/Scan_c/process_repair_v2/" . $id_part . "/" . $id_type . "/1") . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">F I N I S H &nbsp; R E P A I R</a>';
        } else {
            $data .= '             <a class="btn btn-default" href="' . base_url("index.php/Scan_c/process_repair_v2/" . $id_part . "/" . $id_type . "/0") . '" style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">S T A R T &nbsp; R E P A I R</a>';
        }

        $data .= '          </div>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function finish_repair_v2($qr_no)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $pic = $_SESSION['npk'];
        $datenow = date('Ymd');
        $timenow = date('His');
        $id_repair = $this->input->post("id_repair");
        $id_part = $this->input->post("id_part");
        $id_type = $this->input->post("id_type");
        $trans_type = 'R';

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $get_data = $this->Scan_m->get_data_part_mte_by_id($id_part);
        $result = $get_data->row();

        $problem = $this->input->post("problem");
        $cause = $this->input->post("cause");
        $action = $this->input->post("action");

        $sparepart_name = NULL;
        $qty = 0;
        $radio = $this->input->post("opt_radio");

        //===== Old logic for spare parts data
        // if($radio == 1){
        //     $sparepart_name = $this->input->post("sparepart_name");
        //     $qty = $this->input->post("qty");
        // }      
        //===== End

        $flag_sp = 0;
        if ($radio == 0) {
            $check_sp = $this->Scan_m->get_data_sparepart_usage_by_id_trans($trans_type, $id_repair);
            if ($check_sp->num_rows() > 0) {
                $data_save = array(
                    'INT_FLG_DELETE' => 1,
                    'CHR_MODIFIED_BY' =>  $pic,
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
                );
                $this->Scan_m->update_spare_part_by_id_trans($id_repair, $trans_type, $data_save);
            }
        } else {
            $flag_sp = 1;
        }

        $notes = $this->input->post("notes");

        if (isset($_POST['finish'])) {
            //===== Finish TT_REPAIR_PREVENTIVE
            $row = array(
                'CHR_PROBLEM' => $problem,
                'CHR_ROOT_CAUSE' => $cause,
                'CHR_ACTION' => $action,
                'INT_FLG_REPAIR' => '2',
                'CHR_FINISH_REPAIR_BY' => $pic,
                'CHR_FINISH_REPAIR_DATE' => $datenow,
                'CHR_FINISH_REPAIR_TIME' => $timenow,
                'INT_FLG_SPARE_PART' => $flag_sp,
                // 'CHR_SPARE_PART_NAME' => $sparepart_name,
                // 'INT_QTY_SPARE_PART' => $qty,
                'CHR_REMARKS' => $notes
            );

            $this->Scan_m->update_finish_repair($row, str_replace("--", "/", $qr_no));

            //===== Update into TM_PARTS_MTE
            $row = array(
                'INT_FLAG_STAT' => 0 //===== Update flag stat to FINISH REPAIR
            );
            $this->Scan_m->update_part($row, str_replace("--", "/", $qr_no));
        } else if (isset($_POST['update'])) {
            //===== Update TT_REPAIR_PREVENTIVE
            $row = array(
                'CHR_PROBLEM' => $problem,
                'CHR_ROOT_CAUSE' => $cause,
                'CHR_ACTION' => $action,
                'INT_FLG_SPARE_PART' => $flag_sp,
                // 'INT_QTY_SPARE_PART' => $qty,
                'CHR_MODIFIED_BY' => $pic,
                'CHR_MODIFIED_DATE' => $datenow,
                'CHR_MODIFIED_TIME' => $timenow,
                'CHR_REMARKS' => $notes
            );

            $this->Scan_m->update_finish_repair($row, str_replace("--", "/", $qr_no));
        }

        $data['qrcode'] = $qr_no;
        $data['id_part'] = $id_part;
        $data['id_type'] = $id_type;

        $get_repair = $this->Scan_m->get_data_repair_by_id($id_repair);
        $status = '0';
        if ($get_repair->num_rows() > 0) {
            if ($get_repair->row()->INT_FLG_REPAIR == 2) {
                $status = '2';
            } else {
                $status = '1';
            }
            $data['progress'] = $get_repair->row();
        }

        $data['status'] = $status;
        $data['data_part'] = $result;
        $data['content'] = '/process_repair_v2_v';

        $this->load->view('/template/layout', $data);
    }

    public function view_preventive()
    {

        $id_part = $this->input->post("id");
        $id_type = $this->input->post("type");

        $get_prev = $this->Scan_m->get_data_prev_by_id_part($id_part);

        $data = '';
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_preventive()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Process Preventive</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';

        $data .= '          <div>';
        if ($get_prev->num_rows() > 0) {
            $data .= '             <a class="btn btn-default" href="' . base_url("index.php/Scan_c/process_preventive/" . $id_part . "/" . $id_type . "/1") . '" style="width: 45%; height: 40px; font-size: 15px; font-weight: bold;">F I N I S H &nbsp; P R E V E N T I V E</a>';
        } else {
            $data .= '             <a class="btn btn-default" href="' . base_url("index.php/Scan_c/process_preventive/" . $id_part . "/" . $id_type . "/0") . '" style="width: 45%; height: 40px; font-size: 15px; font-weight: bold;">S T A R T &nbsp; P R E V E N T I V E</a>';
        }

        $data .= '          </div>';

        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        echo $data;
    }

    public function test_chart()
    {
        $data['content'] = '/test_chart_v';
        $this->load->view('/template/layout_blank', $data);
    }

    public function get_chart($id_det_check)
    {
        $get_std_chart = $this->Scan_m->get_std_chart($id_det_check)->row();
        $get_chart = $this->Scan_m->get_detail_checksheet_chart($id_det_check);

        $data['std_chart'] = $get_std_chart;
        $data['data_chart'] = $get_chart;
        $data['content'] = '/history_chart_v';
        $this->load->view('/template/layout_blank', $data);
    }

    public function show_history_chart()
    {

        $id_det_check = $this->input->post("id_check");

        $data = '';

        $data .= '<iframe src="' . site_url('Scan_c/get_chart/' . $id_det_check) . '" height="450px" width="100%" scrolling="no" frameborder="0" allowtransparency="true"></iframe>';

        echo $data;
    }

    public function edit_checksheet()
    {

        $id_check = $this->input->post("id");
        $id_prev_detail = $this->input->post("id_prev");

        $get_prev = $this->Scan_m->get_data_prev_by_id_prev_detail($id_prev_detail);

        $disabled = '';
        if ($get_prev->num_rows() > 0) {
            $data_prev = $get_prev->row();
            if ($data_prev->INT_FLG_PREV == '2') {
                $disabled = 'disabled';
            }
        } else {
            $disabled = 'disabled';
        }

        $get_check = $this->Scan_m->get_checksheet_by_id($id_check);
        $data_check = $get_check->row();

        $get_act = $this->Scan_m->get_activity_by_id_checksheet($id_check);
        $data_act = $get_act->result();

        $data = '';
        $data .= form_open('Scan_c/save_checksheet/' . $id_check . '/' . $id_prev_detail);
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog" style="width:80%;">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_edit()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Checksheet - ' . strtoupper(trim($data_check->CHR_CHECKSHEET_NAME)) . '</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        $data .= '             <table id="example" style="font-size:11px;" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '               <thead>';
        $data .= '                 <tr align="center">';
        $data .= '                   <th>No</th>';
        $data .= '                   <th>Activity</th>';
        $data .= '                   <th>Item Check</th>';
        $data .= '                   <th>Tool</th>';
        $data .= '                   <th>Standard</th>';
        $data .= '                   <th>Check</th>';
        // $data .= '                   <th>Before</th>';
        // $data .= '                   <th>After</th>';
        $data .= '                   <th>Status</th>';
        $data .= '                   <th>Notes</th>';
        $data .= '                 </tr>';
        $data .= '               </thead>';
        $data .= '               <tbody>';

        $no = 'A';
        foreach ($data_act as $row) {
            $data .= '<tr>';
            $data .= '<td style="font-weight:bold; font-">' . $no . '</td>';
            $data .= '<td colspan="8" align="left" style="font-weight:bold;">' . trim($row->CHR_ACTIVITY) . '</td>';
            $data .= '</tr>';

            $get_sub_act = $this->Scan_m->get_activity_detail_by_id_activity($row->INT_ID);
            $data_sub_act = $get_sub_act->result();
            $x = 1;
            foreach ($data_sub_act as $row_2) {
                $check_sub_act = $this->Scan_m->get_trans_checksheet($row_2->INT_ID, $id_prev_detail);
                $stat_before_ng = '';
                $stat_before_ok = '';
                $stat_before_na = '';
                $stat_after_ng = '';
                $stat_after_ok = '';
                $stat_after_na = '';
                $style_before = 'display:none;background-color:green;color:white;';
                $style_after = 'display:none;background-color:green;color:white;';
                $style_notes = 'display:none;';
                $checked = '';
                $notes_val = '';
                if ($check_sub_act->num_rows() > 0) {
                    if ($check_sub_act->row()->INT_FLG_CHECK == '1') {
                        $checked = 'checked';
                        $notes_val = $check_sub_act->row()->CHR_REMARKS;
                        $style_notes = 'display:block;';

                        if ($check_sub_act->row()->CHR_STATUS_BEFORE == 'NG') {
                            $stat_before_ng = 'selected';
                            $style_before = 'display:none; background-color:red; color:white;';
                        } else if ($check_sub_act->row()->CHR_STATUS_BEFORE == 'OK') {
                            $stat_before_ok = 'selected';
                            $style_before = 'display:none; background-color:green; color:white;';
                        } else {
                            $stat_before_na = 'selected';
                            $style_before = 'display:none; background-color:grey; color:white;';
                        }

                        if ($check_sub_act->row()->CHR_STATUS_AFTER == 'NG') {
                            $stat_after_ng = 'selected';
                            $style_after = 'display:block; background-color:red; color:white;';
                        } else if ($check_sub_act->row()->CHR_STATUS_AFTER == 'OK') {
                            $stat_after_ok = 'selected';
                            $style_after = 'display:block; background-color:green; color:white;';
                        } else {
                            $stat_after_na = 'selected';
                            $style_after = 'display:block; background-color:grey; color:white;';
                        }
                    } else {
                        $style_before = 'display:none;';
                        $style_after = 'display:none;';
                        $style_notes = 'display:none;';
                    }
                }

                $data .= '<td>' . $x . '</td>';
                $data .= '<td>' . trim($row_2->CHR_ACTIVITY_DETAIL) . '</td>';
                $data .= '<td>' . trim($row_2->CHR_ITEM_CHECK) . '</td>';
                $data .= '<td>' . trim($row_2->CHR_TOOL) . '</td>';
                if ($row_2->CHR_TYPE == 'QNT') {
                    $data .= '<td><a data-placement="right" data-toggle="modal" title="View Chart" onclick="show_his_chart(\'' . trim($row_2->INT_ID) . '\');">' . trim($row_2->CHR_STD_CHECK) . '</a></td>';
                } else {
                    $data .= '<td>' . trim($row_2->CHR_STD_CHECK) . '</td>';
                }

                $data .= '<td><input ' . $disabled . ' type="checkbox" onclick="show_select(' . $row_2->INT_ID . ')" name="check_' . $row_2->INT_ID . '" id="check_' . $row_2->INT_ID . '" value="1" ' . $checked . '></td>';
                // $data .= '<td style="display:none;"><select onchange="change_color(' . $row_2->INT_ID . ')" style="' . $style_before . '" name="before_' . $row_2->INT_ID .'" id="before_' . $row_2->INT_ID .'"><option value="OK" ' . $stat_before_ok . '>OK</option><option value="NG" ' . $stat_before_ng . '>NG</option></option><option selected value="NA" ' . $stat_before_na . '>N/A</option></select></td>';
                $data .= '<td><select onchange="change_color(' . $row_2->INT_ID . ')" style="' . $style_after . '" name="after_' . $row_2->INT_ID . '" id="after_' . $row_2->INT_ID . '"><option value="OK" ' . $stat_after_ok . '>OK</option><option value="NG" ' . $stat_after_ng . '>NG</option><option value="NA" ' . $stat_after_na . '>N/A</option></select></td>';
                $data .= '<td><input ' . $disabled . ' type="text" style="' . $style_notes . ' width:120px;color:black;" name="notes_' . $row_2->INT_ID . '" id="notes_' . $row_2->INT_ID . '" value="' . $notes_val . '"></td>';
                // $data .= '<td align="center"><a onclick="add_notes(' . $row_2->INT_ID .')" style="color: #00ffff; text-decoration-line: underline;">Add</a></td>';
                $data .= '</tr>';

                $x++;
            }

            $no++;
        }

        $data .= '               </tbody>';
        $data .= '             </table>';
        $data .= '<br>';
        $data .= '<div>';
        $data .= '<input class="btn btn-warning" ' . $disabled . ' type="submit" value="S A V E"  style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">';
        $data .= '</div>';
        $data .= '        </div>';

        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';
        $data .= '<script type="text/javascript">';
        $data .= '  function show_select(id_row) {';
        $data .= '    var checkBox = document.getElementById("check_" + id_row);';
        $data .= '    if(checkBox.checked == true){';
        // $data .= '      document.getElementById("before_" + id_row).style.display = "block";';      
        $data .= '      document.getElementById("after_" + id_row).style.display = "block";';
        $data .= '      document.getElementById("notes_" + id_row).style.display = "block";';
        $data .= '    } else {';
        // $data .= '      document.getElementById("before_" + id_row).style.display = "none";'; 
        $data .= '      document.getElementById("after_" + id_row).style.display = "none";';
        $data .= '      document.getElementById("notes_" + id_row).style.display = "none";';
        $data .= '    }';
        $data .= '  }';

        $data .= '  function change_color(id_row) {';
        // $data .= '    var opt_before = document.getElementById("before_" + id_row).value;';
        $data .= '    var opt_after = document.getElementById("after_" + id_row).value;';
        // $data .= '    if(opt_before == "NG"){'; 
        // $data .= '      document.getElementById("before_" + id_row).style.backgroundColor = "red";';
        // $data .= '      document.getElementById("before_" + id_row).style.color = "white";'; 
        // $data .= '    } else if(opt_before == "OK") {';
        // $data .= '      document.getElementById("before_" + id_row).style.backgroundColor = "green";';
        // $data .= '      document.getElementById("before_" + id_row).style.color = "white";'; 
        // $data .= '    } else {';
        // $data .= '      document.getElementById("before_" + id_row).style.backgroundColor = "grey";';
        // $data .= '      document.getElementById("before_" + id_row).style.color = "white";'; 
        // $data .= '    }';
        $data .= '    if(opt_after == "NG"){';
        $data .= '      document.getElementById("after_" + id_row).style.backgroundColor = "red";';
        $data .= '      document.getElementById("after_" + id_row).style.color = "white";';
        $data .= '    } else if(opt_after == "OK") {';
        $data .= '      document.getElementById("after_" + id_row).style.backgroundColor = "green";';
        $data .= '      document.getElementById("after_" + id_row).style.color = "white";';
        $data .= '    } else {';
        $data .= '      document.getElementById("after_" + id_row).style.backgroundColor = "grey";';
        $data .= '      document.getElementById("after_" + id_row).style.color = "white";';
        $data .= '    }';
        $data .= '  }';
        $data .= '</script>';

        $data .= form_close();

        echo $data;
    }

    // public function add_note() {

    //     $id = $this->input->post("id");

    //     $get_act = $this->Scan_m->get_activity_detail_by_id($id);
    //     $data_act = $get_act->row();

    //     $data = '';
    //     $data .= '<div class="modal-wrapper">';
    //     $data .= '  <div class="modal-dialog">';                                    
    //     $data .= '    <div class="modal-content">';
    //     $data .= '       <div class="modal-header">';
    //     $data .= '            <button type="button" onclick="hide_note()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    //     $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Notes</strong></h4>';
    //     $data .= '       </div>';

    //     $data .= '       <div class="modal-body">';
    //     $data .= '          <div>';
    //     $data .= '              <input type="text" class="text" name="note_' . $data_act->INT_ID . '" id="note_' . $data_act->INT_ID . '" placeholder="NOTES" value="">';
    //     $data .= '          </div>';
    //     $data .= '        </div>'; 

    //     $data .= '    </div>';
    //     $data .= '  </div>';
    //     $data .= '</div>';

    //     echo $data;

    // }

    public function save_checksheet($id_check, $id_prev)
    {

        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_check = $this->Scan_m->get_checksheet_by_id($id_check);
        $data_check = $get_check->row();

        $get_prev = $this->Scan_m->get_preventive_by_id($id_prev);
        $data_prev = $get_prev->row();
        $id_part = $data_prev->INT_ID_PART;
        $status = '1'; //===== On Progress Preventive
        $data['progress'] = $data_prev;

        $get_act = $this->Scan_m->get_activity_by_id_checksheet($id_check);
        $data_act = $get_act->result();

        foreach ($data_act as $row) {
            $get_sub_act = $this->Scan_m->get_activity_detail_by_id_activity($row->INT_ID);
            $data_sub_act = $get_sub_act->result();

            foreach ($data_sub_act as $row_2) {
                $check_sub_act = $this->Scan_m->get_trans_checksheet($row_2->INT_ID, $id_prev);
                $check_stat = 0;
                $stat_before = NULL;
                $stat_after = NULL;
                $notes = NULL;

                if (isset($_POST['check_' . $row_2->INT_ID])) {
                    $check_stat = 1;
                    $stat_before = $this->input->post('before_' . $row_2->INT_ID);
                    $stat_after = $this->input->post('after_' . $row_2->INT_ID);
                    $notes = $this->input->post('notes_' . $row_2->INT_ID);
                }

                if ($check_sub_act->num_rows() <= 0) {
                    $data_save = array(
                        'INT_ID_PREV_DETAIL' => $id_prev,
                        'INT_ID_CHECKSHEET' => $id_check,
                        'INT_ID_PART' => $id_part,
                        'INT_ID_ACTIVITY' => $row->INT_ID,
                        'INT_ID_ACTIVITY_DETAIL' => $row_2->INT_ID,
                        'INT_FLG_CHECK' => $check_stat,
                        'CHR_STATUS_BEFORE' =>  $stat_before,
                        'CHR_STATUS_AFTER' => $stat_after,
                        'CHR_REMARKS' => $notes
                    );
                    $this->Scan_m->save_checksheet($data_save);
                } else {
                    $data_update = array(
                        'INT_FLG_CHECK' => $check_stat,
                        'CHR_STATUS_BEFORE' =>  $stat_before,
                        'CHR_STATUS_AFTER' => $stat_after,
                        'CHR_REMARKS' => $notes
                    );
                    $this->Scan_m->update_checksheet($data_update, $row_2->INT_ID, $id_prev);
                }
            }
        }

        $get_data = $this->Scan_m->get_data_part_mte_by_id($id_part);
        $result = $get_data->row();
        $data['qrcode'] = $result->CHR_PART_CODE;
        $data['id_part'] = $id_part;
        $data['id_type'] = $result->CHR_TYPE;

        $get_checksheet = $this->Scan_m->get_checksheet($result->CHR_TYPE, $id_part);
        $checksheet = $get_checksheet->result();

        $data['checksheet'] = $checksheet;
        $data['status'] = $status;
        $data['data_part'] = $result;
        $data['content'] = '/process_preventive_v';

        $this->load->view('/template/layout', $data);
    }

    public function add_spareparts()
    {
        $trans_type = $this->input->post("trans_type");
        $id_trans = $this->input->post("trans_id");
        $id_type = $this->input->post("type");
        $keyword = $this->input->post("key");

        $sp_area = '';
        if ($id_type == 'A' || $id_type == 'B') { //===== MOLD / DIES STP
            $sp_area = 'MT01';
        } else if ($id_type == 'C') { //====== DIES DF
            $sp_area = 'MT02';
        } else if ($id_type == 'D') { //====== MACHINE
            $sp_area = 'MT03';
        } else if ($id_type == 'E') { //====== JIG
            $sp_area = 'EN01';
        }

        $get_sparepart = $this->Scan_m->get_data_sparepart_by_area_and_keyword($sp_area, $keyword);
        $data_sparepart = $get_sparepart->result();
        $data['data_sparepart'] = $data_sparepart;
        $data['sp_area'] = $sp_area;

        $data = '';
        $data .= form_open('Scan_c/save_spareparts/' . $trans_type . '/' . $id_trans . '/' . $sp_area);
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog" style="width:90%;">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_add_sparepart()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>List Spare Parts</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        $data .= '             <table id="dataTables1" style="font-size:11px;" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">';
        $data .= '               <thead>';
        $data .= '                 <tr align="center">';
        $data .= '                   <th>No</th>';
        $data .= '                   <th>Part No</th>';
        $data .= '                   <th>Part Name</th>';
        $data .= '                   <th>Model</th>';
        $data .= '                   <th>Back No</th>';
        $data .= '                   <th>Comp</th>';
        $data .= '                   <th>Specification</th>';
        $data .= '                   <th>Stock</th>';
        $data .= '                   <th>Qty</th>';
        $data .= '                 </tr>';
        $data .= '               </thead>';
        $data .= '               <tbody>';

        $no = '1';
        foreach ($data_sparepart as $row) {
            $data .= '<tr>';
            $data .= '<td style="font-weight:bold; font-">' . $no . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . trim($row->CHR_PART_NO) . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . trim($row->CHR_SPARE_PART_NAME) . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . trim($row->CHR_MODEL) . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . trim($row->CHR_BACK_NO) . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . trim($row->CHR_COMPONENT) . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . trim($row->CHR_SPECIFICATION) . '</td>';
            $data .= '<td align="left" style="font-weight:bold;">' . $row->INT_QTY_ACT . '</td>';
            $stat = '';

            $qty_usage = '';
            $cek_sp_usage = $this->Scan_m->get_data_sparepart_usage_by_id($trans_type, $id_trans, $row->INT_ID);
            if ($cek_sp_usage->num_rows() > 0) {
                $qty_usage = $cek_sp_usage->row()->INT_QTY;
            }

            if ($row->INT_QTY_ACT <= 0) {
                $stat = 'disabled';
            }
            $data .= '<td><input type="number" ' . $stat . ' style="width:50px;color:black;" name="qty_order_' . $row->INT_ID . '" id="qty_order_' . $row->INT_ID . '" value="' . $qty_usage . '" max="' . $row->INT_QTY_ACT . '" min="0"></td>';
            $data .= '</tr>';
            $no++;
        }

        $data .= '               </tbody>';
        $data .= '             </table>';
        $data .= '<br>';
        $data .= '<div>';
        $data .= '<input class="btn btn-warning" type="submit" value="A D D &nbsp; S P A R E P A R T S"  style="width: 40%; height: 40px; font-size: 15px; font-weight: bold;">';
        $data .= '</div>';
        $data .= '        </div>';

        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';
        $data .= '<script src="' . base_url('assets/plugins/jquery-datatables/js/jquery.dataTables.min.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/plugins/jquery-datatables/js/dataTables.bootstrap.js') . '"></script>';

        $data .= '<script src="' . base_url('assets/js/datatables.js') . '"></script>';
        $data .= '<script src="' . base_url('assets/js/dataTables.tableTools.js') . '"></script>';

        $data .= form_close();

        echo $data;
    }

    public function save_spareparts($type_trans, $id_trans, $sp_area)
    {
        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        $data['npk'] = $pic;
        $data['username'] = $user;

        $get_user = $this->Scan_m->get_data_user_by_npk($pic);
        $data_user = $get_user->row();
        $data['role'] = $data_user->INT_ID_ROLE;

        $get_sparepart = $this->Scan_m->get_data_sparepart_by_area($sp_area);
        $data_sparepart = $get_sparepart->result();

        foreach ($data_sparepart as $row) {
            $order =  $this->input->post("qty_order_" . $row->INT_ID);
            if ($order != "") {
                $cek_data_sp = $this->Scan_m->get_data_sparepart_usage_by_id($type_trans, $id_trans, $row->INT_ID);
                if ($cek_data_sp->num_rows() > 0) {
                    $data_sp = $cek_data_sp->row();
                    if ($data_sp->INT_QTY != $order) {
                        if ($order == 0) {
                            //===== Update 
                            $data_save = array(
                                'CHR_MODIFIED_BY' =>  $user,
                                'CHR_MODIFIED_DATE' => date('Ymd'),
                                'CHR_MODIFIED_TIME' => date('His'),
                                'INT_FLG_DELETE' => 1
                            );
                        } else {
                            //===== Update 
                            $data_save = array(
                                'INT_QTY' => $order,
                                'CHR_MODIFIED_BY' =>  $user,
                                'CHR_MODIFIED_DATE' => date('Ymd'),
                                'CHR_MODIFIED_TIME' => date('His')
                            );
                        }
                        $this->Scan_m->update_spare_part($data_sp->INT_ID, $data_save);
                    }
                } else {
                    if ($order != 0) {
                        //===== Insert
                        $data_save = array(
                            'INT_ID_ACTIVITY' => $id_trans,
                            'CHR_ACTIVITY_TYPE' => $type_trans,
                            'INT_ID_SPARE_PART' => $row->INT_ID,
                            'CHR_PART_NO' => $row->CHR_PART_NO,
                            'INT_QTY' => $order,
                            'INT_FLG_ORDER' => 0,
                            'CHR_CREATED_BY' =>  $user,
                            'CHR_CREATED_DATE' => date('Ymd'),
                            'CHR_CREATED_TIME' => date('His'),
                            'INT_FLG_DELETE' => 0
                        );
                        $this->Scan_m->save_spare_part($data_save);

                        $row = array(
                            'INT_FLG_SPARE_PART' => 1,
                            'CHR_MODIFIED_BY' => $pic,
                            'CHR_MODIFIED_DATE' => date('Ymd'),
                            'CHR_MODIFIED_TIME' => date('His')
                        );

                        if ($type_trans == 'R') {
                            $get_data_repair = $this->Scan_m->get_data_repair_by_id($id_trans);
                            $val_repair = $get_data_repair->row();
                            $part_code = $val_repair->CHR_PART_CODE;

                            $this->Scan_m->update_finish_repair($row, $part_code);
                        } else if ($type_trans == 'P') {
                            $this->Scan_m->update_finish_prev_by_id($row, $id_trans);
                        }
                    }
                }
            }
        }

        if ($type_trans == 'R') { //===== Repair
            $get_trans_data = $this->Scan_m->get_data_repair_by_id($id_trans);
            $trans_data = $get_trans_data->row();
            $data['content'] = '/process_repair_v2_v';
        } else if ($type_trans == 'P') { //===== Preventive
            $get_trans_data = $this->Scan_m->get_data_prev_by_id_prev_detail($id_trans);
            $trans_data = $get_trans_data->row();
            $data['content'] = '/process_preventive_v';

            $get_checksheet = $this->Scan_m->get_checksheet($trans_data->CHR_TYPE, $trans_data->INT_ID_PART);
            $checksheet = $get_checksheet->result();
            $data['checksheet'] = $checksheet;
        }

        $data['qrcode'] = $trans_data->CHR_PART_CODE;
        $data['id_part'] = $trans_data->INT_ID_PART;
        $data['id_type'] = $trans_data->CHR_TYPE;
        $data['progress'] = $trans_data;
        $data['status'] = 1;

        $this->load->view('/template/layout', $data);
    }

    public function order_spareparts($id_sp, $id_trans, $id_part, $id_type, $trans_type)
    {
        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        //===== Update 
        $data_save = array(
            'INT_FLG_ORDER' => 1,
            'CHR_MODIFIED_BY' =>  $user,
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );
        $this->Scan_m->update_spare_part($id_sp, $data_save);

        if ($trans_type == 'R') {
            redirect('Scan_c/process_repair_v2/' . $id_part . '/' . $id_type . '/1');
        } else if ($trans_type == 'P') {
            redirect('Scan_c/process_preventive/' . $id_part . '/' . $id_type . '/1');
        }
    }

    public function cancel_spareparts($id_sp, $id_trans, $id_part, $id_type, $trans_type)
    {
        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        //===== Update 
        $data_save = array(
            'INT_FLG_DELETE' => 1,
            'CHR_MODIFIED_BY' =>  $user,
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );
        $this->Scan_m->update_spare_part($id_sp, $data_save);

        $get_data_sp = $this->Scan_m->get_data_sparepart_usage_by_id_trans($trans_type, $id_trans);
        if ($get_data_sp->num_rows() <= 0) {
            $row = array(
                'INT_FLG_SPARE_PART' => 0,
                'CHR_MODIFIED_BY' => $pic,
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );

            if ($trans_type == 'R') {
                $this->Scan_m->update_repair_by_id($row, $id_trans);
            } else if ($trans_type == 'P') {
                $this->Scan_m->update_finish_prev_by_id($row, $id_trans);
            }
        }

        if ($trans_type == 'R') {
            redirect('Scan_c/process_repair_v2/' . $id_part . '/' . $id_type . '/1');
        } else if ($trans_type == 'P') {
            redirect('Scan_c/process_preventive/' . $id_part . '/' . $id_type . '/1');
        }
    }

    public function update_spareparts($id_sp, $id_trans, $id_part, $id_type, $qty, $trans_type)
    {
        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        if ($qty == 0) {
            //===== Delete
            $data_save = array(
                'INT_QTY' => $qty,
                'INT_FLG_DELETE' => 1,
                'CHR_MODIFIED_BY' =>  $user,
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );

            $this->Scan_m->update_spare_part($id_sp, $data_save);

            $get_data_sp = $this->Scan_m->get_data_sparepart_usage_by_id_trans($trans_type, $id_trans);
            if ($get_data_sp->num_rows() <= 0) {
                $row = array(
                    'INT_FLG_SPARE_PART' => 0,
                    'CHR_MODIFIED_BY' => $pic,
                    'CHR_MODIFIED_DATE' => date('Ymd'),
                    'CHR_MODIFIED_TIME' => date('His')
                );

                if ($trans_type == 'R') {
                    $this->Scan_m->update_repair_by_id($row, $id_trans);
                } else if ($trans_type == 'P') {
                    $this->Scan_m->update_finish_prev_by_id($row, $id_trans);
                }
            }
        } else {
            //===== Update 
            $data_save = array(
                'INT_QTY' => $qty,
                'CHR_MODIFIED_BY' =>  $user,
                'CHR_MODIFIED_DATE' => date('Ymd'),
                'CHR_MODIFIED_TIME' => date('His')
            );

            $this->Scan_m->update_spare_part($id_sp, $data_save);
        }

        if ($trans_type == 'R') {
            redirect('Scan_c/process_repair_v2/' . $id_part . '/' . $id_type . '/1');
        } else if ($trans_type == 'P') {
            redirect('Scan_c/process_preventive/' . $id_part . '/' . $id_type . '/1');
        }
    }

    public function order_all_spareparts($id_trans, $trans_type, $id_part, $id_type)
    {
        $pic = $_SESSION['npk'];
        $user = $_SESSION['username'];

        $data_save = array(
            'INT_FLG_ORDER' => 1,
            'CHR_MODIFIED_BY' =>  $user,
            'CHR_MODIFIED_DATE' => date('Ymd'),
            'CHR_MODIFIED_TIME' => date('His')
        );
        $this->Scan_m->update_spare_part_by_id_trans($id_trans, $trans_type, $data_save);

        if ($trans_type == 'R') {
            redirect('Scan_c/process_repair_v2/' . $id_part . '/' . $id_type . '/1');
        } else if ($trans_type == 'P') {
            redirect('Scan_c/process_preventive/' . $id_part . '/' . $id_type . '/1');
        }
    }

    public function download_drawing($id_drw, $type)
    {
        $data['npk'] = $_SESSION['npk'];
        $data['username'] = $_SESSION['username'];

        $get_drw = $this->Scan_m->get_drawing_by_id($id_drw);
        $result = $get_drw->row();

        $this->load->helper('download');

        ob_clean();
        if ($type == '2D') {
            $name = $result->CHR_FILE_DRAWING;
        } else if ($type == '3D') {
            $name = $result->CHR_FILE_DRAWING_3D;
        }
        $data = file_get_contents("assets/images/drw/$name"); // filenya

        force_download($name, $data);
    }

    public function view_change()
    {

        $id_part = $this->input->post("id");
        $id_type = $this->input->post("type");
        $stroke = $this->input->post("strok");

        $get_change = $this->Scan_m->get_list_part_by_type($id_type);

        $data = '';
        $data .= form_open('Scan_c/save_change_model/' . $id_type . '/' . $id_part);
        $data .= '<div class="modal-wrapper">';
        $data .= '  <div class="modal-dialog">';
        $data .= '    <div class="modal-content">';
        $data .= '       <div class="modal-header">';
        $data .= '            <button type="button" onclick="hide_change()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $data .= '            <h4 class="modal-title" id="modalprogress"><strong>Process Change</strong></h4>';
        $data .= '       </div>';

        $data .= '       <div class="modal-body">';
        $data .= '          <input type="hidden" name="stroke" class="form-control" value="' . $stroke . '">';

        if ($get_change->num_rows() > 0) {
            $data .= '<div class="form-group">';
            $data .= '   <label class="col-sm-3 control-label"><strong>Problem</strong></label>';
            $data .= '   <div class="col-sm-5">';
            $data .= '       <input type="text" required name="problem" class="form-control" style="width:350px;" value="">';
            $data .= '   </div>';
            $data .= '</div>';
            $data .= '</br>';
            $data .= '<div class="form-group">';
            $data .= '   <label class="col-sm-3 control-label">Remark</label>';
            $data .= '   <div class="col-sm-5">';
            $data .= '       <input type="text" name="remark" class="form-control" style="width:350px;" value="">';
            $data .= '   </div>';
            $data .= '</div>';
            $data .= '</br>';
            $data .= '<div class="form-group">';
            $data .= '   <label class="col-sm-3 control-label">Change to Model</label>';
            $data .= '   <div class="col-sm-5">';
            $data .= '       <select class="form-control" required name="next_model" style="width:350px;" id="next_model">';

            foreach ($get_change->result() as $val) {
                $data .= '          <option value="' . $val->CHR_PART_CODE . '">' . $val->CHR_PART_CODE . ' - ' . $val->CHR_PART_NAME . '</option>';
            }

            $data .= '        </select>';
            $data .= '    </div>';
            $data .= '</div>';
        }

        $data .= '        </div>';
        $data .= '        <div class="modal-footer">';
        $data .= '          <div class="btn-group">';
        $data .= '              <button type="submit" class="btn btn-info">Save</button>';
        $data .= '          </div>';
        $data .= '        </div>';
        $data .= '    </div>';
        $data .= '  </div>';
        $data .= '</div>';

        $data .= form_close();

        echo $data;
    }

    public function save_change_model($id_type, $id_part)
    {
        $stroke = $this->input->post("stroke");
        $problem = $this->input->post("problem");
        $remark = $this->input->post("remark");
        $part_after = $this->input->post("next_model");

        $part_code = $this->Scan_m->get_data_part_mte_by_id($id_part)->row();

        $data_save = array(
            'INT_ID_PART' => $id_part,
            'CHR_PART_CODE' => trim($part_code->CHR_PART_CODE),
            'INT_STROKE' => $stroke,
            'CHR_PROBLEM' => $problem,
            'CHR_REMARKS' => $remark,
            'CHR_PART_CODE_AFTER' => $part_after,
            'CHR_CREATED_BY' =>  $_SESSION['npk'],
            'CHR_CREATED_DATE' => date('Ymd'),
            'CHR_CREATED_TIME' => date('His')
        );
        $this->Scan_m->save_change_model($data_save);

        redirect('Scan_c/detail_menu/' . trim($part_code->CHR_PART_CODE) . '/' . $id_type);
    }
}
