<?php
/**
 * @file
 * Save access credentials to settings.plist file.
 */

// Not required by Alfred but allows for running scripts from the CLI for
// testing.
require_once './workflows.php';

$worker = new Workflows();
$plist_file = 'settings.plist';

$query = explode('-----', $query);

switch($query[0]) {
  case 'id':
    $worker->set('client_id', $query[1], $plist_file);
    print 'Client ID Saved';
    break;
  case 'key':
    $worker->set('client_key', $query[1], $plist_file);
    print 'API Key Saved';
    break;
  case 'url':
    $worker->set('url', $query[1], $plist_file);
    print 'Base URL Saved';
    break;
}
