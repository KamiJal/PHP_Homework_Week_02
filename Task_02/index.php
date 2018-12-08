<?php
require_once 'functions.php';

const FILENAME = 'countries.txt';

$response = null;
if (isset($_POST['country'])) {
    $response = saveCountryToFile(FILENAME, $_POST['country']);
}
$countries = readCountriesFromFile(FILENAME);
?>

<h1>Please type in country name!</h1>
<h4 style="color: <?= $response['status'] === 'success' ? 'green' : 'red' ?>"><?= $response['message'] ?></h4>
<form method="post" autocomplete="off">
    <input type="text" name="country" placeholder="country name">
    <input type="submit" value="Submit">
</form>

<?php if (isset($countries)) : ?>

    <select>
        <?php foreach ($countries as $country) : ?>
            <option><?= $country ?></option>
        <?php endforeach ?>
    </select>

<?php endif ?>
