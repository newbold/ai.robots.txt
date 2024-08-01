<?php

// This script processes updates to the https://github.com/ai-robots-txt/ai.robots.txt repository.

$robots = json_decode(file_get_contents('robots.json'), 1);

$robots_txt = null;

foreach($robots as $robot => $details) {
  
  $robots_txt .= 'User-agent: '.$robot."\n";
  
}

$robots_txt .= 'Disallow: /';

unlink('robots.txt');

file_put_contents('robots.txt', $robots_txt);

//file_put_contents('robots2.txt', $robots_txt);



/*
// ensure compatibility with files containing unicode characters
shell_exec('git config core.quotepath off');

// Check for the reset trigger
$diff = shell_exec('git diff --name-only HEAD^..HEAD');
if($diff == '') {
  echo '*** No changes detected. Are you running the latest version of the action? See https://github.com/neatnik/weblog.lol for details.';
}
else {
  $diff = explode("\n", $diff);
  echo "\n*** Checking for reset request...";
  foreach($diff as $file) {
    
    if(strtolower($file) == 'configuration/reset' || strtolower($file) == 'weblog/configuration/reset') {
      echo "\n*** Reset request found. Resetting...";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.omg.lol/address/'.$argv[1].'/weblog/reset');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
      curl_setopt($ch, CURLOPT_POSTFIELDS, null);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
      curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $argv[2]);
      $response = curl_exec($ch);
      curl_close($ch);
      
      $diff = shell_exec('git ls-files');
      $diff = explode("\n", $diff);
      
      echo "\n*** Rebuilding with these entries:\n";
      print_r($diff);
      $reset = true;
      goto reset;
    }
  }
}

// Now process all of the other changed content
$diff = shell_exec('git diff --name-only HEAD^..HEAD');
if($diff == '') {
  echo "\n*** No changes detected. Are you running the latest version of the action? See https://github.com/neatnik/weblog.lol for details.";
}
else {
  $diff = explode("\n", $diff);
  
  echo "\n*** These items have changed with this push:\n";
  print_r($diff);
  
  reset:
  
  foreach($diff as $file) {
    
    if($file == '') {
      continue;
    }
    
    // remove quotes from filename
    if(substr($file, 0, 1) == '"') $file = substr($file, 1);
    if(substr($file, -1) == '"') $file = substr($file, 0, -1);
    
    if(strtolower(substr($file, 0, 7)) !== 'weblog/' && strtolower(substr($file, 0, 14)) !== 'configuration/') {
      echo "\n*** Skipping file: $file";
      continue;
    }
    
    echo "\n*** Examining file: $file...";
    
    if(strtolower($file) == 'configuration/configuration.txt' || strtolower($file) == 'weblog/configuration/configuration.txt') {
      $configuration_update = $file;
    }
    if(strtolower($file) == 'configuration/template.html' || strtolower($file) == 'weblog/configuration/template.html') {
      echo "\n*** Updating template...";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.omg.lol/address/'.$argv[1].'/weblog/template');
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file));
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
      curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $argv[2]);
      $response = curl_exec($ch);
      curl_close($ch);
    }
    
    if(substr(strtolower($file), -3) !== '.md' && substr(strtolower($file), -9) !== '.markdown') {
      echo "\n*** File doesn’t end in .md or .markdown; skipping.";
      continue;
    }
    
    $filename = $file;
    $filename = str_replace('/', '_', $filename);
    $filename = substr($filename, 7); // removes 'weblog_'
    $filename = substr($filename, 0, -3);
    
    if(file_exists($file)) {
      echo "\n*** Updating file: $file...";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.omg.lol/address/'.$argv[1].'/weblog/entry/'.urlencode($filename));
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file));
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
      curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $argv[2]);
      $response = curl_exec($ch);
      curl_close($ch);
    }
    else {
      echo "\n*** Deleting file: $file...";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://api.omg.lol/address/'.$argv[1].'/weblog/delete/'.$filename);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
      curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $argv[2]);
      $response = curl_exec($ch);
      curl_close($ch);
    }
  }
  // save the configuration for last, since it will trigger a rebuild
  if(isset($configuration_update)) {
    echo "\n*** Updating configuration...";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.omg.lol/address/'.$argv[1].'/weblog/configuration');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($configuration_update));
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
    curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $argv[2]);
    $response = curl_exec($ch);
    curl_close($ch);
  }
}

echo "\n*** Entry processing complete. Have a nice day.";
*/