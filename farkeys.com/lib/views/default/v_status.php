<?php
echo <<<HH
<?xml version="1.0" encoding="utf-8"?>
<root>
<errors>{$data::$errors}</errors>
<data>
<user>{$data::$user}</user>
<status>{$data::$status}</status>
<aux>{$data::$aux}</aux>
<date>{$data::$date}</date>
</data>
</root>
HH;
?>