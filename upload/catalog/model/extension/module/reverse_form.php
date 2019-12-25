<?php
class ModelExtensionModuleReverseForm extends Model {
    public function addRequest($data) {
        $this->db->query("INSERT INTO ".DB_PREFIX."reverse_form SET name = '".$this->db->escape($data['name'])."', phone = '".$this->db->escape($data['tel'])."',email = '".$this->db->escape($data['email'])."',description = '".$this->db->escape($data['description'])."', date_added = NOW()");
    }
}