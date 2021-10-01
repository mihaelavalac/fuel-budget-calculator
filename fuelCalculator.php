<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fuel Budget Calculator</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <?php
  //PHP Code goes bellow.
  $averageMilesDriven = "";
  $averageMilesDrivenErr = "";

  $milesPerGallon = "";
  $milesPerGallonErr = "";

  $gasPrice = "";

  $groceryExpenses = "";
  $groceryExpensesErr = "";
  $cost = "";


  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Average Miles Driven Input Validation
    if (is_numeric($_POST["averageMilesDriven"])) {
      $averageMilesDriven = (float)clear_input($_POST["averageMilesDriven"]);
    } else if (empty($_POST["averageMilesDriven"])) {
      $averageMilesDrivenErr = "Average miles driven is required.";
    } else {
      $averageMilesDrivenErr = "Average miles driven must be a number.";
      $averageMilesDriven = '';
    }

    //Miles Per Gallon Input Validation
    if (is_numeric($_POST["milesPerGallon"])) {
      $milesPerGallon = (float)clear_input($_POST["milesPerGallon"]);
    } else if (empty($_POST["milesPerGallon"])) {
      $milesPerGallonErr = "Miles per gallon driven is required.";
    } else {
      $milesPerGallonErr = "Miles per gallon driven must be a number.";
      $milesPerGallon = '';
    }

    //Getting the value associated with the Fuel Type and Price ratio button selected.
    if (isset($_POST["gas-price"])) {
      $gasPrice = (float)$_POST["gas-price"];
    }

    //Fuel Perks for Groceries Input Validation
    if (is_numeric($_POST["groceryExpenses"])) {
      $groceryExpenses = (float)clear_input($_POST["groceryExpenses"]);
      $discountPerGallon = floor(($groceryExpenses / 100)) * 0.1;
      $gasPrice = $gasPrice - $discountPerGallon;
    } else if (empty($_POST["groceryExpenses"])) {
      $groceryExpensesErr = "";
    } else {
      $groceryExpensesErr = "Weekly expenses on grocery must be a number.";
      $groceryExpenses = '';
    }

    //Calculate the average weekly expenses on gas without discount.


    if (!is_numeric($averageMilesDriven) || !is_numeric($milesPerGallon)) {
      $cost = '';
    } else {
      $cost = sprintf('%.2f', (($averageMilesDriven / $milesPerGallon) * $gasPrice));
    }
  }

  function clear_input($data)
  {
    $data = trim($data); // removes whitespace
    $data = stripslashes($data); // strips slashes
    $data = htmlspecialchars($data); // replaces html chars
    return $data;
  }


  ?>

  <style>
    .error {
      color: #7A0004;
      font-weight: bold;
      font-size: 18px !important;
    }

    .container {
      padding: 10px;
      margin: 40px auto auto;
      background-color: #CCEFFF;
    }

    .form {
      max-width: 80%;
      margin: 0 auto;
    }

    .total-budget {
      font-size: 1.75rem;
      font-weight: bold;
    }
  </style>

  <div class="container">
    <h1 class="text-center" style="font-size:2rem; font-weight:bold;"> Fuel Calculator </h1>
    <p class="text-center error"> Complete all inputs fields with * to calculate how much you should budget for your fuel per week!</p>
    <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

      <legend for="averageMilesDriven">Average Miles Driven <span class="error">*</span></legend>
      <span class="error"><?php echo $averageMilesDrivenErr; ?></span>
      <input class="form-control" type="text" name="averageMilesDriven" id="averageMilesDriven" required><br>

        <legend for="milesPerGallon">Your car's Miles Per Gallon <span class="error">*</span></legend>
        <span class="error"> <?php echo $milesPerGallonErr; ?></span>
        <input class="form-control" type="text" name="milesPerGallon" id="milesPerGallon" required>
      <fieldset class="form-check">
        <legend>Type and cost of gas:<span class="error">*</span></legend>

        <input class="form-check-input" id="87" type="radio" name="gas-price" value=1.89 required>
        <label for='87'>87 octane - 1.89 $/gal</label><br>

        <input class="form-check-input" id='89' type="radio" name="gas-price" value=1.99 required>
        <label for='89'>89 octane - 1.99 $/gal</label><br>

        <input class="form-check-input" id='92' type="radio" name="gas-price" value=2.09 required>
        <label for='92'>92 octane - 2.09 $/gal</label>
      </fieldset>

      <legend for="groceryExpenses">Weekly Expenses on Groceries<br><span class="error"> <?php echo $groceryExpensesErr; ?></span> </legend>

      <input class="form-control" type="text" name="groceryExpenses" id="groceryExpenses"><br>

      <input class="btn btn-secondary" type="submit" name="calculate" value="Calculate">
    </form>
    <br>
    <h2 class="text-center total-budget"><b>Your weekly fuel budget: $<?php echo $cost;  ?></b></h2>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>