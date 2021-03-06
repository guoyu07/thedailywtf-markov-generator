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

<p>Source code is on <a href="https://github.com/machado2/thedailywtf-markov-generator">github</a></p>

<form action="generate.php" method="get">
<div class="form-horizontal">
    <div class="form-group">
        <label for="board" class="control-label col-xs-2">Board</label>
        <div class="col-xs-10">
            <input type="text" id="board" name="board" maxlength="3" value="b" required pattern="[a-z]{1,3}"/>
        </div>
    </div>
    <div class="form-group">
        <label for="order" class="control-label col-xs-2">Order</label>
        <div class="col-xs-10">
            <input type="number" id="order" name="order" value="4" min="1" max="99" autofocus />
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button id="btnbuscar" class="btn btn-default">generate</button>
        </div>
    </div>
</div>
</form>

</div>

</html>
