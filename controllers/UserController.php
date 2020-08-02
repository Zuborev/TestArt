<?php

include_once ROOT . '/models/User.php';
include_once ROOT . '/models/Address.php';


class UserController
{
    public function actionIndex()
    {
        $usersList = [];
        $usersList = User::getUsersList();
        require_once(ROOT . '/views/user/index.php');
        return true;
    }

    public function actionRegister()
    {
        $regionList = [];
        $regionList = Address::getRegionList();
        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    public function actionView($id)
    {
        $userData = [];
        $userData = User::getUserData($id);
        require_once(ROOT . '/views/user/view.php');
        return true;
    }

    public function actionAdd()
    {
        $requestArray = [$_POST['login'], $_POST['email'], $_POST['region'], $_POST['city']];

        if ($this->checkAjaxRequest($requestArray)) {
            $login = $_POST['login'];
            $email = $_POST['email'];
            $region = $_POST['region'];
            $city = $_POST['city'];
            $village = (isset($_POST['village'])) ? $_POST['village'] : '';
        }

        $id = User::checkEmail($email);

        if (!empty($id)) {
            $data = ['status' => 'found', 'id' => $id];
            echo json_encode($data);
            die();
        } else {
            $territoryId = Address::getTerritoryId($region, $city, $village);
            $info = User::userSave($login, $email, $territoryId);

            $success = "Все прошло успешно";
            $error = "Что-то пошло не так";

            $message = ($info) ? $success : $error;
            $class = ($message === $success) ? "alert-success" : "alert-danger";
            $data = ['status'=> 'success', 'message' => $message, 'class' => $class];
            echo json_encode($data);
        }
        return true;
    }

    private function checkAjaxRequest($array)
    {
        foreach ($array as $item) {
            if (empty($item)) {
                return false;
            }
        }
        return true;
    }
}