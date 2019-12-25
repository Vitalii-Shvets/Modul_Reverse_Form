<?php
class ModelCatalogReverseForm extends Model {
    public function getCallArray() {
        $sql = "SELECT * FROM `".DB_PREFIX."reverse_form` GROUP BY id";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getCall($id) {
        $query = $this->db->query("SELECT DISTINCT * FROM `".DB_PREFIX."reverse_form` WHERE id = '".(int)$id."'");
        return $query->row;
    }

    public function deleteCall($id) {
        $this->db->query("DELETE FROM `".DB_PREFIX."reverse_form` WHERE id = '".(int)$id."'");
    }

    public function makeDB() {
        $sql  = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."reverse_form` ( ";
        $sql .= "`id` INT NOT NULL AUTO_INCREMENT, ";
        $sql .= "`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, ";
        $sql .= "`phone` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, ";
        $sql .= "`email` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, ";
        $sql .= "`description` TEXT NULL DEFAULT NULL, ";
        $sql .= "`date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)";
        $sql .= ") ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;";
        $this->db->query($sql);
    }

    public function deleteDB() {
        $this->db->query("DROP TABLE IF EXISTS `".DB_PREFIX."reverse_form`;");
    }
}
