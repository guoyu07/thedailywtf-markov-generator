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

require '../markov.php';

$board = urlencode( $_GET["board"]);
if (!eregi("^[a-z]{1,3}$",$board))
{
    die('invalid board');
}

$input = '';
for ($page = 1; $page <= 10; $page++) {
    $url = "http://a.4cdn.org/" . $board . "/" . $page . ".json";
    $threads = json_decode(file_get_contents($url))->threads;
    foreach ($threads as $thread) {
        foreach ($thread->{'posts'} as $post) {
            if (isset($post->com)) {
                $input = $input . "\n\n" . html_entity_decode($post->com, ENT_QUOTES, 'UTF-8');
            }
        }
    }
}
$input = str_replace("</p>", "\n", $input);
$input = str_replace("<p>", "\n", $input);
$input = strip_tags($input);
$input = preg_replace("/>>[0-9]*/", "", $input);
$input = preg_replace("/@[a-z0-9A-Z_]* said:/i", "", $input);
$input = preg_replace("/@[a-z0-9A-Z_]*/i", "", $input);
$input = preg_replace("/^\n/", "", $input);

$order = (int) $_GET["order"];
if ($order < 1 || $order > 99)
    $order = 4;

$markov_table = generate_markov_table($input, $order);
$markov = generate_markov_text(2500, $markov_table, $order);
$markov = htmlspecialchars($markov);
$markov = '<p>' . str_replace("\n\n", '</p><p>', $markov) . '</p>';

echo $markov;

