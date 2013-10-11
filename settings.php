<?php
/**
 * @file
 * Prompt user to set access credentials.
 */

// Not required by Alfred but allows for running scripts from the CLI for
// testing.
require_once './workflows.php';

$worker = new Workflows();

$query = explode(' ', $query);

switch ($query[0]) {
  case 'id':
    // Save the ID.
    if (!empty($query[1])) {
      $worker->result('hp-client-id-setting', 'id-----' . $query[1], 'Set Client ID', 'Hit Enter to save your Client ID', 'icon.png', 'yes');
    }
    else {
      $worker->result('hp-client-id-setting', NULL, 'Set Client ID', 'Set your client ID by adding a space followed by your Client ID. e.g.) "id CLIENTID"', 'icon.png', 'no');
    }
    break;

  case 'key':
    // Save the Key.
    if (!empty($query[1])) {
      $worker->result('hp-client-secret-setting', 'key-----' . $query[1], 'Set Secret Key', 'Hit Enter to save your API Key', 'icon.png', 'yes');
    }
    else {
      $worker->result('hp-client-secret-setting', NULL . $query[1], 'Set Secret Key', 'Set your API ID by adding a space followed by your API ID. e.g.) "key APIKEY"', 'icon.png', 'no');
    }
    break;

  case 'url':
    // Save the Base URL.
    if (!empty($query[1])) {
      $worker->result('hp-client-url-setting', 'url-----' . $query[1], 'Set Base URL (Default https://hackpad.com)', 'Hit Enter to save your Base URL', 'icon.png', 'yes');
    }
    else {
      $worker->result('hp-client-url-setting', NULL . $query[1], 'Set Base URL (Default https://hackpad.com)' , 'Change base url. e.g.) "url https://example.hackpad.com"', 'icon.png', 'no');
    }
    break;

  default:
    $worker->result('hp-settings', '', 'Configure HackPad Workflow', 'Type one of "id", "key", or "url" to configure this workflow.', 'icon.png', 'no');
    break;
}

print $worker->toxml();
