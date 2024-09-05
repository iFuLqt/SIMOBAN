<?php 
function is_logged_in(){
    $ci = get_instance();
    if(!$ci->session->userdata('email_user')){
        redirect('auth');
    } else {
        $id_role = $ci->session->userdata('id_role');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_acces_menu', [
            'id_role' => $id_role, 
            'menu_id' => $menu_id]);

        if($userAccess->num_rows() < 1){
            redirect('auth/blocked');
        }
    }
}

function check_access($id_role, $menu_id){
    $ci = get_instance();

    $ci->db->where('id_role', $id_role);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_acces_menu');

    if($result->num_rows() > 0) {
        return "checked='checked'";
    }

}





?>