<?php
/**
 * Created by PhpStorm.
 * User: Byron
 * Date: 2018/11/25
 * Time: 0:18
 */

$cx = new Api();
switch ($_GET['action']) {
    case 'getQuestion':
        {
            return json_encode($cx->questionPicker());
        }
    default:
        {
            return json_encode(array('status' => 404));
        }
}
