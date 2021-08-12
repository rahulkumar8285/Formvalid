<?php 
class UserModel extends CI_Model {

    public function AddData($data,$tabel){
        $this->db->insert($tabel, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    public function ShowData($tabelname,$order,$filed){
        $this->db->order_by($filed,$order);
       return $this->db->get($tabelname);        
   }

    

}