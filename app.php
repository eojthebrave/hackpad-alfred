<?php
/**
 * @file
 * Search hackpad.com api for specific pad(s).
 */

// Not required by Alfred but allows for running scripts from the CLI for
// testing.
require_once './hackpad.php';
require_once './workflows.php';

$worker = new Workflows();

// Get Settings.
$client_id = $worker->get('client_id', 'settings.plist');
$client_key = $worker->get('client_key', 'settings.plist');
$url = $worker->get('url', 'settings.plist');

// Set a default URL.
$url = !$url ? 'https://hackpad.com' : $url;

// If we don't have a client id and key we can't do much else.
if (!isset($client_id) || !isset($client_key)) {
  $worker->result('hp-error', '', 'Missing configuration', 'Please set your API ID and Key, use command "hpsettings" to continue.', 'no');
  print $worker->toxml();
  exit;
}

$pad = new HackPadAPI($client_id, $client_key, $url);

$res = $worker->request($pad->searchURI($query));

$output = array();
foreach (json_decode($res) as $r) {
  $item = array(
    'uid' => 'suggest ' . $query,
    'arg' => $pad->base_url . '/' . $r->id,
    'title' => $r->title,
    'subtitle' => $r->snippet,
    'icon' => 'icon.png',
  );
  array_push($output, $item);
}

if (count($output)) {
  print $worker->toxml($output);
  exit;
}
else {
  $worker->result('404', '404', 'No Results Found', '', 'icon.png', 'no');
  print $worker->toxml();
  exit;
}
