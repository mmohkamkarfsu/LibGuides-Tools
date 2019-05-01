<?php
$libguides_base = "https://lgapi-us.libapps.com/1.1/guides?site_id=~ENTERSITEIDHERE~&key=~ENTERSITEKEYHERE~&expand=owner";
$response_search = file_get_contents($libguides_base) or die("Could not retrieve LibGuides information.");
$json_responses_decoded = json_decode($response_search);

$count = count($json_responses_decoded);

$owner = [];
$type_label = [];
$status_label = [];


function percent($x,$count){
	$percent = ($x/$count)*100;
	$percent = round($percent,2);
	return " --- (" . strval($percent) . "% of total guides)\n";
}

for ($i = 0; $i < $count; $i++){
//Creates full name from first_name and last_name values
	$owner_first = $json_responses_decoded[$i]->owner->first_name;
	$owner_last = $json_responses_decoded[$i]->owner->last_name;
	$owner_individual = $owner_first . " " . $owner_last;
	array_push($owner, $owner_individual);
    $type_label_individual = $json_responses_decoded[$i]->type_label;
    array_push($type_label, $type_label_individual);
	$status_label_individual = $json_responses_decoded[$i]->status_label;
	array_push($status_label, $status_label_individual);
}


$owner_count = array_count_values($owner);
arsort($owner_count);
echo "\n" . "~~Guide Owners~~" . "\n\n";
foreach ($owner_count as $owner=>$owner_guide_count){
	echo "$owner owns $owner_guide_count guides" . percent($owner_guide_count,$count);
}

$type_count = array_count_values($type_label);
arsort($type_count);
echo "\n" . "~~Guide Types~~" . "\n\n";
foreach ($type_count as $type=>$type_guide_count){
	echo "There are $type_guide_count $type"."s" . percent($type_guide_count,$count);
}

$status_count = array_count_values($status_label);
arsort($status_count);
echo "\n" . "~~Guide Statuses~~" . "\n\n";
foreach ($status_count as $status=>$status_guide_count){
	echo "There are $status_guide_count $status guides" . percent($status_guide_count,$count);
}


?>