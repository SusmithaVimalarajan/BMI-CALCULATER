
<?php
include "cal.php";

// Module 1: Convert height from cm to meters
function convertHeight($height) {
    return $height / 100;
}

// Module 3: Check BMI category
function checkBMICategory($bmi) {

    if ($bmi < 18.5) {
        return "Underweight";
    } elseif ($bmi < 25) {
        return "Normal Weight";
    } elseif ($bmi < 30) {
        return "Overweight";
    } else {
        return "Obese";
    }
}

$bmi = "";
$category = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $weight = $_POST["weight"];
    $height = $_POST["height"];

    // Validate input
    if (
        $weight === "" ||
        $height === "" ||
        !is_numeric($weight) ||
        !is_numeric($height) ||
        $weight <= 0 ||
        $height <= 0
    ) {
        $error = "Please enter valid weight and height.";
    } else {

        // Calling Module 1
        $heightInMeters = convertHeight($height);

        // Calling Module 2
        $bmi = calculateBMI($weight, $heightInMeters);

        // Calling Module 3
        $category = checkBMICategory($bmi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>BMI Calculator</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">

    <h2>BMI Calculator</h2>

    <p class="subtitle">
        Enter your weight and height
    </p>

    <form method="POST" action="">

        <label>Weight (kg)</label>

        <input
            type="number"
            name="weight"
            step="any"
            min="0.1"
            placeholder="Enter your weight"
            value="<?php echo htmlspecialchars($_POST['weight'] ?? ''); ?>"
            required
        >

        <label>Height (cm)</label>

        <input
            type="number"
            name="height"
            step="any"
            min="0.1"
            placeholder="Enter your height"
            value="<?php echo htmlspecialchars($_POST['height'] ?? ''); ?>"
            required
        >

        <button type="submit">Calculate BMI</button>

    </form>

    <?php if ($error != "") { ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php } ?>

    <?php if ($category !== "") { ?>

        <div class="result">

            <h3>BMI Result</h3>

            <p>
                Weight:
                <strong><?php echo $weight; ?> kg</strong>
            </p>

            <p>
                Height:
                <strong><?php echo $height; ?> cm</strong>
            </p>

            <p>
                BMI Value:
                <strong><?php echo number_format($bmi, 2); ?></strong>
            </p>

            <p>
                BMI Category:
                <strong class="<?php echo strtolower(str_replace(' ', '-', $category)); ?>">
                    <?php echo $category; ?>
                </strong>
            </p>

        </div>

    <?php } ?>

</div>

</body>
</html>
