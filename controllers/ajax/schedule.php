<?php
require_once('libs/Model.php');
/** @var Schedule $model */
$model = Model::getModel('schedule');


$dateSchedule = strtotime($_GET["schedule"]);
$scheduleDatas = $model->getCurrentSchedule($dateSchedule);

$html = "";
foreach ($scheduleDatas as $scheduleData) {

    $classType = $scheduleData['entry_type'];
    $html .= "<div class=\"schedule-class $classType\">";
    $timeSchedFrom = date('h:i A', date_create($scheduleData['entry_class_from'])->getTimestamp());
    $timeSchedTo = date('h:i A', date_create($scheduleData['entry_class_to'])->getTimestamp());
    $timeSchedule = $timeSchedFrom . ' - ' . $timeSchedTo;
    $entryTitle = $scheduleData['entry_title'];
    $entryTitle = $scheduleData['entry_title'];
    $html .= "<span>$timeSchedule</span>";
    $html .= "<span>$entryTitle</span>";
    $html .= "<span>##/TW</span>";
}
 $html .= "</div>";
//$frameworks = array("CodeIgniter","Zend Framework","Cake PHP","Kohana") ;
//
//$name = ;
//
//if (strlen($name) > 0) {
//
//    $match = "";
//
//    for ($i = 0; $i < count($frameworks); $i++) {
//
//        if (strtolower($name) == strtolower(substr($frameworks[$i], 0, strlen($name)))) {
//
//            if ($match == "") {
//
//                $match = $frameworks[$i];
//
//            } else {
//
//                $match = $match . " , " . $frameworks[$i];
//
//            }
//
//        }
//
//    }
//
//}
//
//echo ($match == "") ? 'no match found' : $match;
echo $html;
die();
?>