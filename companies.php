<?php

require_once __DIR__ . '/vendor/autoload.php';

use SevenShores\Hubspot\Factory;

$apiKey = "YOUR_API_KEY_HERE";
$hubspot = Factory::create($apiKey);

/**
 * COMPANIES
 */
echo "Getting all companies...\n";
$response = $hubspot->companies()->all([
    'limit'     => 100,
	//'vidOffset' => '',
    'properties'  => ['name', 'website', 'phone'],
]);
foreach ($response->companies as $company) {
	$vid = $company->companyId;
	if (isset($company->properties->phone)) {
		$value = $company->properties->phone->value;
		if ($value === '' || $value === null) continue;
		if ($value === '+') {
			$hubspot->companies()->update($vid, [
				['name' => 'phone', 'value' => '']
			]);
			continue;
		}
		
		$phoneNumber = preg_replace("/[^0-9]/", "", $value);
		echo "[{$vid}] CURRENT: {$value} ({$phoneNumber})\n";
		
		if (strlen($phoneNumber) === 10) {
			$phoneNumber = "+1".$phoneNumber;
		} else if (strlen($phoneNumber) === 11 && strpos($phoneNumber, "1") === 0) {
			$phoneNumber = "+".$phoneNumber;
		}
		
		if (strlen($phoneNumber) === 12) {
			$hubspot->companies()->update($vid, [
				['name' => 'phone', 'value' => $phoneNumber]
			]);
			echo "[{$vid}] DONE: Old: {$value} -> New: {$phoneNumber}\n";
		}
	}
}