# HubSpot Phone Numbers Reformatter

**This tool is intended for HubSpot CRM customers only. It will not work with other CRMs.**

## Background
This was created in under an hour in order to quicky reformat phone numbers in our CRM since our PBX integration needed a common format to find the contacts/companies. In our case, this format was E164.

This script can help many to ease the task of correcting bad employee behavior. Teaching your employees to use a common format is much, MUCH simpler.

## Requirements
- PHP 7.4+
- PHP Composer (https://getcomposer.org)

## Installation
- Clone the repository
- Run `composer install`
- Change your API Key in the files
- Execute it.

## Limitations
- It only does the first 100 contacts & companies it can find from the API.
	- No precise order here, but I believe it is "Last Activity Date", "Creation Date" or just alphabetical by name.
	- The `vidOffset` is used to search the next batch, but it isn't used for now.
- It only does the "Phone" field, not the "Mobile" field nor "Fax" field.
- It doesn't support international numbers correctly, E164 NANP only.

## Usage
To run it, simply execute, via command line:

```
$ php contacts.php
```

OR

```
$ php companies.php
```

## Contribute
Feel free to fork or contribute via pull requests!

Happy HubSpotting!

## Ideas
- Use [HubSpot/hubspot-php](https://www.github.com/HubSpot/hubspot-php) instead of the deprecated `ryanwinchester/hubspot-php`
- Update to support ALL contacts and companies, not just the first 100.
- Update to support ALL phone fields instead of just one.
- Update to support international numbers (or just skip them.)
