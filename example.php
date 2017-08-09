<?php
   require_once('vendor/autoload.php');

   $execution = new \Eustatos\gitlab\webhook\Event(
       $_REQUEST['command'],
       'b2b pushed'
   );
   $execution->logResult('gitlab-webhook.log');
