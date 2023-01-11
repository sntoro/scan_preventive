<?php

class Scan_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_data_user_by_npk($npk) {
        $sql = $this->db->query("SELECT * FROM TM_USER 
                        WHERE CHR_NPK = '$npk'");

        return $sql;
    }

    //===== Common Function for All Type of Preventive
    public function get_data_part_mte($qr_no, $type) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE 
                        WHERE CHR_PART_CODE = '$qr_no' AND CHR_TYPE = '$type' AND INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_data_part_mte_by_id($id_part) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE 
                        WHERE INT_ID = '$id_part'");

        return $sql;
    }

    public function get_data_part_mte_by_id_repair($id_repair) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE WHERE INT_ID IN (SELECT INT_ID_PART FROM MTE.TT_REPAIR_PREVENTIVE WHERE INT_ID = '$id_repair')");

        return $sql;
    }

    public function get_data_part_mte_by_id_prev($id_prev) {
        $sql = $this->db->query("SELECT TOP 1 * FROM TM_PARTS_MTE A
                        LEFT JOIN TT_PREVENTIVE B ON A.CHR_PART_CODE = B.CHR_PART_CODE
                        WHERE B.INT_ID = '$id_prev'");

        return $sql;
    }

    //===== Only for Preventive Electrode
    public function get_data_part($qr_no) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE 
                        WHERE CHR_PART_CODE = '$qr_no' AND INT_FLAG_DELETE = '0'");

        return $sql;
    }

    //===== Common Function for All Type of Preventive
    public function get_data_new_part($qr_no, $part_no) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE 
                        LEFT JOIN TM_PARTS_MTE_DETAIL ON TM_PARTS_MTE.CHR_PART_CODE = TM_PARTS_MTE_DETAIL.CHR_PART_CODE
                        WHERE TM_PARTS_MTE.CHR_PART_CODE = '$qr_no' AND TM_PARTS_MTE.INT_FLAG_DELETE = '0' AND TM_PARTS_MTE_DETAIL.CHR_PART_NO = '$part_no' AND TM_PARTS_MTE_DETAIL.INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function save_prev($data) {
        $this->db->insert('TT_PREVENTIVE', $data);
    }

    public function save_change_model($data) {
        $this->db->insert('MTE.TT_CHANGE_MODEL', $data);
    }

    public function save_prev_detail($data) {
        $this->db->insert('MTE.TT_PREVENTIVE_DETAIL', $data);
    }

    public function save_repair($data) {
        $this->db->insert('MTE.TT_REPAIR_PREVENTIVE', $data);
    }

    public function update_part($data, $qr_no) {
        $this->db->where('CHR_PART_CODE', $qr_no);
        $this->db->update('TM_PARTS_MTE', $data);
    }

    public function update_repair_by_id($data, $id_repair) {
        $this->db->where('INT_ID', $id_repair);
        $this->db->update('MTE.TT_REPAIR_PREVENTIVE', $data);
    }

    public function update_start_repair($data, $qr_no) {
        $this->db->where('CHR_PART_CODE', $qr_no);
        $this->db->where('INT_FLG_REPAIR', '0');
        $this->db->update('MTE.TT_REPAIR_PREVENTIVE', $data);
    }

    public function update_finish_repair($data, $qr_no) {
        $this->db->where('CHR_PART_CODE', $qr_no);
        $this->db->where('INT_FLG_REPAIR', '1');
        $this->db->update('MTE.TT_REPAIR_PREVENTIVE', $data);
    }

    public function update_repair_by_id_part($data, $id_part) {
        $this->db->where('INT_ID_PART', $id_part);
        $this->db->update('MTE.TT_REPAIR_PREVENTIVE', $data);
    }

    public function update_finish_prev_by_id($data, $id_prev) {
        $this->db->where('INT_ID', $id_prev);
        $this->db->update('MTE.TT_PREVENTIVE_DETAIL', $data);
    }

    public function get_data_part_repair() {
        $sql = $this->db->query("SELECT A.CHR_PART_CODE, A.INT_FLG_REPAIR, B.CHR_PART_NAME, B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_REPAIR_DATE, A.CHR_START_REPAIR_TIME, A.CHR_FINISH_REPAIR_DATE, A.CHR_FINISH_REPAIR_TIME, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME 
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE B.INT_FLAG_DELETE = '0' AND A.INT_FLG_REPAIR <> '2'
                                ORDER BY A.CHR_CREATED_DATE, A.CHR_CREATED_TIME");

        return $sql;
    }

    public function get_data_part_repair_by_qr($qr_no) {
        $sql = $this->db->query("SELECT A.INT_ID, A.CHR_PART_CODE, A.INT_FLG_REPAIR, B.CHR_PART_NAME, B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_REPAIR_DATE, A.CHR_START_REPAIR_TIME, A.CHR_FINISH_REPAIR_DATE, A.CHR_FINISH_REPAIR_TIME, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME 
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.CHR_PART_CODE = '$qr_no' AND B.INT_FLAG_DELETE = '0' AND A.INT_FLG_REPAIR <> '2'");

        return $sql;
    }

    public function get_data_part_repair_first($line) {
        $sql = $this->db->query("SELECT TOP 1 A.INT_ID, A.CHR_PART_CODE, A.INT_FLG_REPAIR, B.CHR_PART_NAME, B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_REPAIR_DATE, A.CHR_START_REPAIR_TIME, A.CHR_FINISH_REPAIR_DATE, A.CHR_FINISH_REPAIR_TIME, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME 
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.CHR_PART_CODE LIKE '$line%' AND B.INT_FLAG_DELETE = '0' AND A.INT_FLG_REPAIR <> '2'
                                ORDER BY CHR_CREATED_DATE, CHR_CREATED_TIME ASC");

        return $sql;
    }

    public function get_data_part_no($id_part) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE_DETAIL 
                        WHERE INT_ID_PART = '$id_part'");

        return $sql;
    }

    public function get_drawing_type($id_part, $id_type) {
        $sql = $this->db->query("SELECT DISTINCT CHR_DRAWING_TYPE FROM MTE.TM_DRAWING WHERE INT_ID_PART = '$id_part' AND CHR_TYPE = '$id_type'");

        return $sql;
    }

    public function get_drawing_list($id_part, $drw_type) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_DRAWING WHERE INT_ID_PART = '$id_part' AND CHR_DRAWING_TYPE = '$drw_type'");

        return $sql;
    }

    public function get_drawing_by_id($id_drw) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_DRAWING WHERE INT_ID = '$id_drw'");

        return $sql;
    }

    public function get_historical_preventive($part_code) {
        $sql = $this->db->query("SELECT A.INT_ID, A.CHR_TYPE, A.CHR_PART_CODE, A.INT_COUNT, A.INT_PLAN_COUNT, A.CHR_TYPE_PREV, A.CHR_CREATED_BY,
                                    A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, B.INT_ID_PART, A.CHR_REMARKS, B.INT_FLG_PREV, B.CHR_START_PREV_BY, 
                                    B.CHR_START_PREV_DATE, B.CHR_START_PREV_TIME, B.CHR_FINISH_PREV_BY, B.CHR_FINISH_PREV_DATE, B.CHR_FINISH_PREV_TIME,
                                    B.INT_FLG_CONFIRM, B.CHR_CONFIRM_BY, B.CHR_CONFIRM_DATE, B.CHR_CONFIRM_TIME
                                FROM TT_PREVENTIVE A 
                                LEFT JOIN MTE.TT_PREVENTIVE_DETAIL B ON A.INT_ID = B.INT_ID_PREV
                                WHERE A.CHR_PART_CODE = '$part_code'
                                ORDER BY A.CHR_CREATED_DATE DESC, A.CHR_CREATED_TIME DESC");

        return $sql;
    }

    public function get_data_last_prev_by_part($part_code) {
        $sql = $this->db->query("SELECT TOP 1 * FROM TT_PREVENTIVE WHERE CHR_PART_CODE = '$part_code' ORDER BY INT_ID DESC");

        return $sql;
    }

    public function get_historical_repair($part_code) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_REPAIR_PREVENTIVE WHERE CHR_PART_CODE = '$part_code' ORDER BY INT_ID DESC");

        return $sql;
    }

    public function get_historical_change($part_code) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_CHANGE_MODEL WHERE CHR_PART_CODE = '$part_code' ORDER BY INT_ID DESC");

        return $sql;
    }

    public function get_historical_repair_by_key($part_code, $key) {
        $sql = $this->db->query("SELECT A.INT_ID, INT_ID_PART, A.CHR_PART_CODE, B.CHR_TYPE, CHR_PROBLEM, CHR_ROOT_CAUSE, CHR_ACTION, A.INT_STROKE, INT_FLG_REPAIR, CHR_START_REPAIR_BY, 
                                CHR_START_REPAIR_DATE, CHR_START_REPAIR_TIME, CHR_FINISH_REPAIR_BY, CHR_FINISH_REPAIR_DATE, CHR_FINISH_REPAIR_TIME, 
                                A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_REMARKS, A.CHR_PART_NO_SPARE_PART,
                                A.CHR_SPARE_PART_NAME, A.INT_QTY_SPARE_PART, A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.CHR_PART_CODE = '$part_code' AND (CHR_PROBLEM LIKE '%$key%' OR CHR_ROOT_CAUSE LIKE '%$key%' OR CHR_ACTION LIKE '%$key%' OR CHR_REMARKS LIKE '%$key%' OR CHR_SPARE_PART_NAME LIKE '%$key%' OR A.CHR_CREATED_BY LIKE '%$key%' OR A.CHR_CREATED_DATE LIKE '%$key%')");

        return $sql;
    }

    public function get_manual_type($group, $id_part, $id_type) {
        $sql = $this->db->query("SELECT DISTINCT CHR_WI_TYPE FROM MTE.TM_WI WHERE CHR_WI_GROUP = '$group' AND INT_ID_PART = '$id_part' AND CHR_TYPE = '$id_type' AND INT_FLG_DEL <> '1'
                                UNION
                                SELECT DISTINCT CHR_WI_TYPE FROM MTE.TM_WI WHERE CHR_WI_GROUP = '$group' AND INT_ID_PART IS NULL AND CHR_TYPE = '$id_type' AND INT_FLG_DEL <> '1'");

        return $sql;
    }

    public function get_manual_list($group, $id_part, $wi_type) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_WI WHERE CHR_WI_GROUP = '$group' AND INT_ID_PART = '$id_part' AND CHR_WI_TYPE = '$wi_type' AND INT_FLG_DEL <> '1'
                                UNION
                                SELECT * FROM MTE.TM_WI WHERE CHR_WI_GROUP = '$group' AND INT_ID_PART IS NULL AND CHR_WI_TYPE = '$wi_type' AND INT_FLG_DEL <> '1'");

        return $sql;
    }

    public function get_manual_by_id($id_wi) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_WI WHERE INT_ID = '$id_wi'");

        return $sql;
    }

    public function get_data_prev_by_id_part($id_part) {
        $sql = $this->db->query("SELECT A.INT_ID, A.CHR_PART_CODE, A.INT_STROKE, A.CHR_REMARKS, A.INT_FLG_PREV, B.CHR_PART_NAME, B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.INT_FLG_SPARE_PART,
                                    A.CHR_START_PREV_BY, A.CHR_START_PREV_DATE, A.CHR_START_PREV_TIME, A.CHR_FINISH_PREV_BY, A.CHR_FINISH_PREV_DATE, A.CHR_FINISH_PREV_TIME, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME  
                                FROM MTE.TT_PREVENTIVE_DETAIL A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.INT_ID_PART = '$id_part' AND B.INT_FLAG_DELETE = '0' AND A.INT_FLG_PREV <> '2'");

        return $sql;
    }

    public function get_data_prev_by_id_prev_detail($id_prev_detail) {
        $sql = $this->db->query("SELECT A.INT_ID, A.INT_ID_PART, B.CHR_TYPE, A.CHR_PART_CODE, A.INT_STROKE, A.CHR_REMARKS, A.INT_FLG_PREV, B.CHR_PART_NAME, B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.INT_FLG_SPARE_PART,
                                    A.CHR_START_PREV_BY, A.CHR_START_PREV_DATE, A.CHR_START_PREV_TIME, A.CHR_FINISH_PREV_BY, A.CHR_FINISH_PREV_DATE, A.CHR_FINISH_PREV_TIME, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME  
                                FROM MTE.TT_PREVENTIVE_DETAIL A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.INT_ID = '$id_prev_detail' AND B.INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_data_prev_by_id_prev($id_prev) {
        $sql = $this->db->query("SELECT A.INT_ID, A.INT_ID_PART, A.CHR_PART_CODE, A.INT_STROKE, A.CHR_REMARKS, A.INT_FLG_PREV, B.CHR_PART_NAME, B.CHR_MODEL, A.INT_FLG_SPARE_PART, 
                                    B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_PREV_BY, A.CHR_START_PREV_DATE, A.CHR_START_PREV_TIME, A.CHR_FINISH_PREV_BY, 
                                    A.CHR_FINISH_PREV_DATE, A.CHR_FINISH_PREV_TIME, A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME,
                                    A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME  
                                FROM MTE.TT_PREVENTIVE_DETAIL A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                LEFT JOIN TT_PREVENTIVE C ON A.INT_ID_PREV = C.INT_ID
                                WHERE C.INT_ID = '$id_prev' AND B.INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_data_prev_by_id_prev_old($id_prev) {
        $sql = $this->db->query("SELECT A.INT_ID, A.CHR_TYPE, A.INT_ID_PART, A.CHR_PART_CODE, A.INT_COUNT AS INT_STROKE, '-' AS CHR_REMARKS, '2' AS INT_FLG_PREV, B.CHR_PART_NAME, B.CHR_MODEL, 
                                    B.INT_STROKE_BIG_PREVENTIVE, A.CHR_CREATED_BY AS CHR_START_PREV_BY, A.CHR_CREATED_DATE AS CHR_START_PREV_DATE, A.CHR_CREATED_TIME AS CHR_START_PREV_TIME, A.CHR_CREATED_BY AS CHR_FINISH_PREV_BY, 
                                    A.CHR_CREATED_DATE AS CHR_FINISH_PREV_DATE, A.CHR_CREATED_TIME AS CHR_FINISH_PREV_TIME, A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME,
                                    '1' AS INT_FLG_CONFIRM, NULL AS CHR_CONFIRM_BY, NULL AS CHR_CONFIRM_DATE, NULL AS CHR_CONFIRM_TIME  
                                FROM TT_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.INT_ID = '$id_prev' AND B.INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_data_repair_by_id_part($id_part) {
        $sql = $this->db->query("SELECT A.INT_ID, A.INT_ID_PART, A.CHR_PART_CODE, A.INT_STROKE, A.CHR_PROBLEM, A.CHR_ROOT_CAUSE, A.CHR_ACTION, A.CHR_REMARKS, A.INT_FLG_REPAIR, B.CHR_PART_NAME, 
                                    B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_REPAIR_BY, A.CHR_START_REPAIR_DATE, A.CHR_START_REPAIR_TIME, A.CHR_FINISH_REPAIR_BY, 
                                    A.CHR_FINISH_REPAIR_DATE, A.CHR_FINISH_REPAIR_TIME, A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME,
                                    A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME, A.INT_FLG_SPARE_PART, A.CHR_PART_NO_SPARE_PART, A.CHR_SPARE_PART_NAME, A.INT_QTY_SPARE_PART  
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.INT_ID_PART = '$id_part' AND B.INT_FLAG_DELETE = '0' AND A.INT_FLG_REPAIR <> '2'");

        return $sql;
    }

    public function get_data_repair_by_id_repair($id_repair) {
        $sql = $this->db->query("SELECT A.INT_ID, A.INT_ID_PART, A.CHR_PART_CODE, A.INT_FLG_SPARE_PART, A.CHR_PART_NO_SPARE_PART, A.CHR_SPARE_PART_NAME, 
                                    A.INT_QTY_SPARE_PART, A.INT_STROKE, A.CHR_PROBLEM, A.CHR_ROOT_CAUSE, A.CHR_ACTION, A.CHR_REMARKS, A.INT_FLG_REPAIR, 
                                    B.CHR_PART_NAME, B.CHR_MODEL, B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_REPAIR_BY, A.CHR_START_REPAIR_DATE, 
                                    A.CHR_START_REPAIR_TIME, A.CHR_FINISH_REPAIR_BY, A.CHR_FINISH_REPAIR_DATE, A.CHR_FINISH_REPAIR_TIME, 
                                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME 
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.INT_ID = '$id_repair' AND B.INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_data_repair_by_id($id_repair) {
        $sql = $this->db->query("SELECT A.INT_ID, A.INT_ID_PART, A.CHR_PART_CODE, A.INT_STROKE, A.CHR_PROBLEM, A.CHR_ROOT_CAUSE, A.CHR_ACTION, A.CHR_REMARKS, A.INT_FLG_REPAIR, B.CHR_PART_NAME, B.CHR_MODEL, 
                                    B.CHR_TYPE, B.INT_STROKE_BIG_PREVENTIVE, A.CHR_START_REPAIR_BY, A.CHR_START_REPAIR_DATE, A.CHR_START_REPAIR_TIME, A.CHR_FINISH_REPAIR_BY, 
                                    A.CHR_FINISH_REPAIR_DATE, A.CHR_FINISH_REPAIR_TIME, A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME,
                                    A.INT_FLG_CONFIRM, A.CHR_CONFIRM_BY, A.CHR_CONFIRM_DATE, A.CHR_CONFIRM_TIME, A.INT_FLG_SPARE_PART, A.CHR_PART_NO_SPARE_PART, A.CHR_SPARE_PART_NAME, A.INT_QTY_SPARE_PART   
                                FROM MTE.TT_REPAIR_PREVENTIVE A
                                LEFT JOIN TM_PARTS_MTE B ON A.INT_ID_PART = B.INT_ID
                                WHERE A.INT_ID = '$id_repair' AND B.INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_actual_stroke($id_part, $date) {
        $sql = $this->db->query("SELECT SUM(INT_TOTAL_QTY + INT_TOTAL_NG) AS TOTAL FROM TT_PRODUCTION_RESULT 
                                WHERE CHR_PART_NO IN (SELECT CHR_PART_NO FROM TM_PARTS_MTE_DETAIL WHERE INT_ID_PART = '$id_part')
                                    AND CHR_DATE >= '$date'");

        return $sql;
    }

    public function get_checksheet($id_type, $id_part) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                                WHERE CHR_TYPE = '$id_type' AND INT_FLG_DEL = '0' AND INT_ID_PART IS NULL
                                UNION
                                SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE
                                WHERE CHR_TYPE = '$id_type' AND INT_FLG_DEL = '0' AND INT_ID_PART = '$id_part'");

        return $sql;
    }

    // public function get_activity_by_type($id_type) {
    //     $sql = $this->db->query("SELECT A.INT_ID, A.CHR_TYPE, A.INT_ID_PART, A.CHR_ACTIVITY_CODE, A.CHR_ACTIVITY_NAME, 
    //                                 B.INT_LEVEL, B.INT_SEQUENCE, B.CHR_ACTIVITY, B.CHR_ITEM_CHECK, B.CHR_TOOL, B.CHR_STD_CHECK
    //                             FROM MTE.TM_ACTIVITY_PREVENTIVE A
    //                             LEFT JOIN MTE.TM_ACTIVITY_PREVENTIVE_DETAIL B ON A.INT_ID = B.INT_ID_ACTIVITY
    //                             WHERE A.CHR_TYPE = '$id_type' AND A.INT_FLG_DEL = '0' AND B.INT_LEVEL = '0'");

    //     return $sql;
    // }

    public function get_checksheet_by_id($id_check) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_CHECKSHEET_PREVENTIVE WHERE INT_ID = '$id_check'");

        return $sql;
    }

    public function get_preventive_by_id($id_prev) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_PREVENTIVE_DETAIL WHERE INT_ID = '$id_prev'");

        return $sql;
    }

    public function get_activity_by_id_checksheet($id_check) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE WHERE INT_ID_CHECKSHEET = '$id_check'");

        return $sql;
    }

    public function get_activity_detail_by_id_activity($id_act) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL WHERE INT_ID_ACTIVITY = '$id_act'");

        return $sql;
    }

    public function save_checksheet($data) {
        $this->db->insert('MTE.TT_CHECKSHEET_PREVENTIVE', $data);
    }

    public function update_checksheet($data, $id_act, $id_prev) {
        $this->db->where('INT_ID_PREV_DETAIL', $id_prev);
        $this->db->where('INT_ID_ACTIVITY_DETAIL', $id_act);
        $this->db->update('MTE.TT_CHECKSHEET_PREVENTIVE', $data);
    }

    public function get_trans_checksheet($id_act, $id_prev) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_CHECKSHEET_PREVENTIVE WHERE INT_ID_PREV_DETAIL = '$id_prev' AND INT_ID_ACTIVITY_DETAIL = '$id_act'");

        return $sql;
    }

    function get_stroke_now_mold($part_code) {
        $stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_mold ?";
        $param = array(
            'code' => $part_code);
        $query = $this->db->query($stored_procedure, $param);
        return $query->result();
    }

    function get_stroke_now_dies_stp($part_code) {
        $stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_dies ?";
        $param = array(
            'code' => $part_code);
        $query = $this->db->query($stored_procedure, $param);
        return $query;
    }

    function get_stroke_now_dies_df($part_code) {
        $stored_procedure = "EXEC MTE.zsp_get_data_preventive_mte_df ?";
        $param = array(
            'code' => $part_code);
        $query = $this->db->query($stored_procedure, $param);
        return $query;
    }

    function update_big_preventive($part_code, $small_prev_next, $big_prev_next, $datenow, $next_stroke_preventive) {
        $this->db->query("UPDATE TM_PARTS_MTE SET 
                                INT_SMALL_PREVENTIVE = '$small_prev_next', 
                                CHR_DATE_SMALL_PREVENTIVE = '$datenow',
                                INT_BIG_PREVENTIVE = '$big_prev_next',
                                INT_STROKE_BIG_PREVENTIVE = '$next_stroke_preventive',
                                INT_FLAG_STAT = '1'
                                WHERE CHR_PART_CODE = '$part_code'");
    }

    function update_small_preventive($part_code, $small_prev_next, $datenow, $next_stroke_preventive) {
        $this->db->query("UPDATE TM_PARTS_MTE SET 
                                INT_SMALL_PREVENTIVE = '$small_prev_next', 
                                CHR_DATE_SMALL_PREVENTIVE = '$datenow',
                                INT_STROKE_BIG_PREVENTIVE = '$next_stroke_preventive',
                                INT_FLAG_STAT = '1'
                                WHERE CHR_PART_CODE = '$part_code'");
    }

    function insert_transaction_preventive($type, $part_code, $count, $stroke_big_preventive, $type_prev, $npk, $datenow, $timenow, $id) {
        $this->db->query("INSERT INTO TT_PREVENTIVE (CHR_TYPE, CHR_PART_CODE, INT_COUNT, INT_PLAN_COUNT, CHR_TYPE_PREV, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME, INT_ID_PART) 
                            VALUES ('$type', '$part_code', '$count', '$stroke_big_preventive','$type_prev', '$npk', '$datenow', '$timenow', '$id')");
    }

    public function get_data_sparepart_by_area($sp_area) {
        $samanta = $this->load->database("db_samanta", TRUE);
        $sql = $samanta->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
                    A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, A.CHR_PART_TYPE, C.INT_QTY AS INT_QTY_ACT, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
                    FROM TM_SPARE_PARTS A
                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                    WHERE A.CHR_FLAG_DELETE = 'F' AND C.CHR_SLOC = '$sp_area' --AND C.INT_QTY > 0
                    ORDER BY CHR_PRICE DESC");
        return $sql;
    }

    public function get_data_sparepart_usage_by_id($type_trans, $id_trans, $id_sp) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_SPARE_PARTS_USAGE
                    WHERE CHR_ACTIVITY_TYPE = '$type_trans' AND INT_ID_ACTIVITY = '$id_trans' AND INT_ID_SPARE_PART = '$id_sp' AND INT_FLG_DELETE = '0'");
        return $sql;
    }

    public function get_data_sparepart_usage_by_id_trans($type_trans, $id_trans) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_SPARE_PARTS_USAGE
                    WHERE CHR_ACTIVITY_TYPE = '$type_trans' AND INT_ID_ACTIVITY = '$id_trans' AND INT_FLG_DELETE = '0'");
        return $sql;
    }

    public function save_spare_part($data) {
        $this->db->insert('MTE.TT_SPARE_PARTS_USAGE', $data);
    }

    public function update_spare_part($id, $data) {
        $this->db->where('INT_ID', $id);
        $this->db->update('MTE.TT_SPARE_PARTS_USAGE', $data);
    }

    public function update_spare_part_by_id_trans($id_trans, $trans_type, $data) {
        $this->db->where('INT_ID_ACTIVITY', $id_trans);
        $this->db->where('CHR_ACTIVITY_TYPE', $trans_type);
        $this->db->where('INT_FLG_ORDER', 0);
        $this->db->where('INT_FLG_DELETE', 0);
        $this->db->update('MTE.TT_SPARE_PARTS_USAGE', $data);
    }

    public function get_data_sparepart_by_area_and_keyword($sp_area, $keyword) {
        $samanta = $this->load->database("db_samanta", TRUE);
        $sql = $samanta->query("SELECT DISTINCT A.INT_ID, A.CHR_PART_NO, A.CHR_BACK_NO, A.CHR_SPARE_PART_NAME, A.CHR_COMPONENT, A.CHR_MODEL, A.CHR_TYPE, A.CHR_SPECIFICATION, 
                    A.INT_QTY_USE, A.INT_QTY_MIN, A.INT_QTY_MAX, (CONVERT(FLOAT,A.CHR_PRICE)) AS CHR_PRICE, A.CHR_PART_TYPE, C.INT_QTY AS INT_QTY_ACT, A.CHR_FILENAME, A.CHR_FLAG_DELETE, 
                    A.CHR_CREATED_BY, A.CHR_CREATED_DATE, A.CHR_CREATED_TIME, A.CHR_MODIFIED_BY, A.CHR_MODIFIED_DATE, A.CHR_MODIFIED_TIME
                    FROM TM_SPARE_PARTS A
                    INNER JOIN TT_SPARE_PARTS_SLOC C ON C.CHR_PART_NO = A.CHR_PART_NO
                    WHERE A.CHR_FLAG_DELETE = 'F' AND C.CHR_SLOC = '$sp_area' AND (A.CHR_PART_NO LIKE '%$keyword%' OR A.CHR_SPARE_PART_NAME LIKE '%$keyword%' OR A.CHR_COMPONENT LIKE '%$keyword%' OR A.CHR_MODEL LIKE '%$keyword%' OR A.CHR_SPECIFICATION LIKE '%$keyword%') --AND C.INT_QTY > 0
                    ORDER BY CHR_PRICE DESC");
        return $sql;
    }

    public function get_list_part_by_type($type) {
        $sql = $this->db->query("SELECT * FROM TM_PARTS_MTE 
                        WHERE CHR_TYPE = '$type' AND INT_FLAG_DELETE = '0'");

        return $sql;
    }

    public function get_detail_checksheet_chart($id_check) {
        $sql = $this->db->query("SELECT * FROM MTE.TT_CHECKSHEET_PREVENTIVE WHERE INT_ID_ACTIVITY_DETAIL = '$id_check'");

        return $sql;
    }

    public function get_std_chart($id_check) {
        $sql = $this->db->query("SELECT * FROM MTE.TM_ACTIVITY_PREVENTIVE_DETAIL WHERE INT_ID = '$id_check'");

        return $sql;
    }

}

?>