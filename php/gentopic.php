<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<html>

<noscript>This page works without javascript, but that's not intentional</noscript>

<div class="container">

<?php

require 'markov.php';

$topicid = (int) $_GET["topic"];
if ($topicid < 1 || $topicid > 1000000)
    die('invalid topic number');

$url = "https://what.thedailywtf.com/t/" . $topicid . ".json?include_raw=1";
$posts = json_decode(file_get_contents($url))->post_stream->posts;
$input = '';
foreach ($posts as $post) {
    if (isset($post->raw)) {
        $input = $input . "\n\n" . html_entity_decode($post->raw, ENT_QUOTES, 'UTF-8');
    }
}
$input = str_replace("</p>", "\n", $input);
$input = str_replace("<p>", "\n", $input);
$input = preg_replace('/\[quote[^\]]*\]/i', ' ', $input);
$input = preg_replace('/\[\/quote[^\]]*\]/i', ' ', $input);
$input = strip_tags($input);
$input = preg_replace("/@[a-z0-9A-Z_]* said:/i", "", $input);
$input = preg_replace("/@[a-z0-9A-Z_]*/i", "", $input);
$input = preg_replace("/^\n/", "", $input);

$order = (int) $_GET["order"];
if ($order < 1 || $order > 99)
    $order = 4;

$markov_table = generate_markov_table($input, $order);
$markov = generate_markov_text(2500, $markov_table, $order);
#if (get_magic_quotes_gpc()) $markov = stripslashes($markov);
#echo '<pre>' . $markov . '</pre>';
$markov = htmlspecialchars($markov);
$markov = '<p>' . str_replace("\n\n", '</p><p>', $markov) . '</p>';

echo $markov;

