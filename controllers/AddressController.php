<?php

include_once ROOT.'/models/Address.php';

class AddressController {

    public function actionGet() {
        $parentName = $_POST['parentName'];
        $type = $_POST['type'];

        if($type === 'city') {
            $regId = Address::getRegId($parentName);
            echo json_encode(Address::getCityList($regId));
        } else {
            $grandparentName = $_POST['grandparentName'];
            $regId = Address::getRegId($grandparentName);
            echo json_encode(Address::getVillageList($regId, $parentName));
        }
        return true;
    }

}