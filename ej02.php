<!--
Crea un php con un array inicial con 3 valores numéricos. (2 puntos)
    a) Crea un formulario que permita modificar el valor en una posición en concreto.
    b) Consigue que se mantenga las modificaciones en el array.
    c) Añade un botón para calcular el valor medio. 
-->

<?php
    session_start();

    # creat eand initialize the array with 3 positions wherw there are 3 different numbers.
    if (!isset($_SESSION['numbers'])) {
        $_SESSION['numbers']=[10,20,30];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modify'])) {
        $position = (int)$_POST['position'];
        $value = (int)$_POST['value'];
        #
        if ($position >= 0 && $position < count($_SESSION['numbers'])) {
            $_SESSION['numbers'][$position] = $value;
        }
    }

    // calculate average
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['average'])) {
        $average = array_sum($_SESSION['numbers']) / count($_SESSION['numbers']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modify array saved in session</title>
    </head>

    <body>
        <h1>Modify array saved in session</h1>
            <form method="POST" action="ej02.php">
            <!--position to modify-->
            <h2>Position to modify</h2>
            <select name="position">
                <?php foreach ($_SESSION['numbers'] as $index => $num): ?>
                    <option value="<?php echo $index; ?>"><?php echo $index; ?></option>
                <?php endforeach; ?>
            </select>
            <!--new number-->
            <h2>New value</h2>
            <input type="number" name="value" required>
            <button type="submit" name="modify">Modify</button>
        </form>
        <h3>Current Array</h3>
        <p><?php echo implode(', ', $_SESSION['numbers']); ?></p>
        
        <form method="post">
            <button type="submit" name="average">calculate average</button>
        </form>
        
        <?php if (isset($average)): ?>
            <h3>Average: <?php echo number_format($average, 2); ?></h3>
        <?php endif; ?>
    </body>