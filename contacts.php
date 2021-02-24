<?php

require_once __DIR__ . '/vendor/autoload.php';

use SevenShores\Hubspot\Factory;

/**function formatPhoneNumber($input) {
	return "+1" . preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1$2$3', $input);
}**/

$apiKey = "YOUR_API_KEY_HERE";
$hubspot = Factory::create($apiKey);

/**
 * CONTACTS
 */
echo "Getting all contacts...\n";
$response = $hubspot->contacts()->all([
    'count'     => 100,
	//'vidOffset' => '',
    'property'  => ['firstname', 'lastname', 'email', 'phone'],
]);
foreach ($response->contacts as $contact) {
	// RUN THE UPDATE
	$vid = $contact->vid;
	if (isset($contact->properties->phone)) {
		$value = $contact->properties->phone->value;
		if ($value === '' || $value === null) continue;
		if ($value === '+') {
			$hubspot->contacts()->update($vid, [
				['name' => 'phone', 'value' => '']
			]);
			continue;
		}
		
		$phoneNumber = preg_replace("/[^0-9]/", "", $value);
		echo "[{$vid}] CURRENT: {$phoneNumber}\n";
		
		if (strlen($phoneNumber) === 10) {
			$phoneNumber = "+1".$phoneNumber;
		} else if (strlen($phoneNumber) === 11 && strpos($phoneNumber, "1") === 0) {
			$phoneNumber = "+".$phoneNumber;
		}
		
		if (strlen($phoneNumber) === 12) {
			$hubspot->contacts()->update($vid, [
				['property' => 'phone', 'value' => $phoneNumber]
			]);
			echo "[{$vid}] DONE: Old: {$value} -> New: {$phoneNumber}\n";
		}
	}
}