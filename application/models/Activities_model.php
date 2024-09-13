<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activities_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_daily_activities_by_user_id($user_id) {
        $this->db->select('user.name_user, daily_activities.*');
        $this->db->from('daily_activities');
        $this->db->join('user', 'user.id_user = daily_activities.user_id');
        $this->db->where('daily_activities.user_id', $user_id);
        $this->db->order_by('daily_activities.date_job', 'DESC');
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan hasil sebagai array
    }


}