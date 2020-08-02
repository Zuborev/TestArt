<?php

class User
{
    public static function getUsersList()
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT name, email, ter_address 
                                        FROM users 
                                        JOIN t_koatuu_tree ON users.territory = t_koatuu_tree.ter_id
                                        ORDER BY name ASC ')
            ->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function checkEmail($email)
    {
        $db = Db::getConnection();
        $result = $db->prepare('SELECT id FROM users WHERE email = ?');
        $result->execute([$email]);
        $id = $result->fetchColumn();
        return $id;
    }

    public static function userSave($name, $email, $addressId)
    {
        $db = Db::getConnection();
        $result = $db->prepare("INSERT INTO users( name, email, territory) VALUES (?, ?, ?)");
        $tmp = $result->execute(array($name, $email, $addressId));
        return $tmp;
    }

    public static function getUserData($id)
    {
        $db = Db::getConnection();
        $result = $db->prepare('SELECT name, email, ter_address 
                                        FROM users 
                                        JOIN t_koatuu_tree ON users.territory = t_koatuu_tree.ter_id WHERE id = ?');
        $result->execute([$id]);
        $userData = $result->fetch(PDO::FETCH_ASSOC);
        return $userData;
    }
}