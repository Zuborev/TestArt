<?php
class Address
{
    public static function getRegionList() {
        $db = Db::getConnection();
        $result = $db->query('SELECT ter_name FROM t_koatuu_tree WHERE ter_level = 1 ORDER BY ter_id')
                    ->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    public static function getCityList($id) {
        $db = Db::getConnection();
        $result = $db->prepare('SELECT ter_name 
                                          FROM t_koatuu_tree 
                                          WHERE reg_id = ?
                                          AND ((ter_type_id = 1 AND ter_level = 3) OR ter_level = 2) 
                                          ORDER BY ter_type_id, ter_name');
        $result->execute([$id]);
        $list = $result->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }

    public static function getVillageList($id, $name) {
        $db = Db::getConnection();
        $parentName = "%$name%";
        $result = $db->prepare('SELECT ter_name 
                                          FROM t_koatuu_tree 
                                          WHERE reg_id = ? AND ter_address LIKE ?
                                          AND (ter_type_id > 1 AND ter_level > 2) 
                                          ORDER BY ter_type_id, ter_name');
        $result->execute([$id, $parentName]);
        $list = $result->fetchAll(PDO::FETCH_ASSOC);
        return $list;
    }

    public static function getRegId($regionName) {
        $db = Db::getConnection();
        $result = $db->prepare('SELECT reg_id FROM t_koatuu_tree WHERE ter_name = ?');
        $result->execute([$regionName]);
        $id = $result->fetchColumn();
        return $id;
    }

    public static function getTerritoryId($region, $city, $village) {
        $db = Db::getConnection();
        $fullName = "%$village%$city%$region%";
        $result = $db->prepare('SELECT ter_id FROM t_koatuu_tree WHERE ter_address LIKE ?');
        $result->execute([$fullName]);
        $id = $result->fetchColumn();
        return $id;
    }
}

