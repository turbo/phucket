<?php

function phucket($iSecDelay) {
  $sIPHash    = md5($_SERVER[REMOTE_ADDR]);
  $bReqAllow  = -1;
  $sContent   = "";

  if (!($nFileHandle = fopen("bucket.cache", "c+"))) return -1;

  flock($nFileHandle, LOCK_EX);

  while ($sCurLine = fgets($nFileHandle, 4096)) {
    if ( (time() - strtok($sCurLine, '|')) <= $iSecDelay ) {
      $sContent .= $sCurLine.PHP_EOL;
      continue;
    }

    if (strpos($sCurLine, $sIPHash) !== false) {
      $sContent .= time()."|".$sIPHash.PHP_EOL;
      $bReqAllow = 1;
    }
  }

  ftruncate($nFileHandle, 0);
  rewind($nFileHandle);
  fwrite($nFileHandle, $sContent);
  flock($nFileHandle, LOCK_UN);
  fclose($nFileHandle);

  return $bReqAllow;
}
