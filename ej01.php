<!--
Ejercicio01.php - Crea un formulario que permita gestionar la cantidad de refresco o leche que hay en un supermercado. (2 puntos) 
    a) Se debe mantener el nombre del trabajador que está uƟlizando la aplicación. 
    b) Se debe poder añadir y quitar leche o refresco seleccionando de una lista
    c) Se debe controlar que no se pueden quitar mas unidades de las que haya, en ese caso mostrar error.
-->

<?php //para procesar la inc¡formacion (CONTROLADOR)
//when user click on a button (if from POST has been submitted)
    session_start();
// initialze form
    if (isset($_SESSION['inventory'])) {
        $_SESSION['inventory'] = [
            'milk' => 50,
            'soft drink' => 50,
        ]; 
    }
//    1. get data from form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $worker = $_POST['worker'] ?? null;
        $product = $_POST['product'] ?? null;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['Quantity'] : 0;
        $action = $_POST['action'] ?? null;
    }
//    2. save worker data 
    if ($worker) {
        $_SESSION['worker'] = $worker;
    }
//    3. detect button
//        3.1. to add products
//            3.1.1. evaluate product
//            3.1.2. add quantity to corresponding product

//        3.2. to remove products
//            3.2.1. evaluate product
//            3.2.2. check i fquantity is not greater than current one
//            3.2.3. substract from quantity to corresponding product
    if ($action === 'add' && $quantity > 0) {
        $_SESSION['inventory'][$product] += $quantity; // here add the quantity of the product selected.
        echo "<p style='color:green;'>Added $quantity units of $product by {$_SESSION['worker']}.</p>";
    }elseif ($action === 'remove' & $quantity > 0) {
        if ($_SESSION['inventory'][$product] >= $quantity) {
            $_SESSION['inventory'][$product] -= $quantity;
            echo "<p style='color:green;'>Removed $quantity units of $product by {$_SESSION['worker']}.</p>";
        }else {
            echo "<p style='color:red;'>Error: Not enough $product to remove $quantity units.</p>";
        }
    }elseif ($action === 'reset') {
        session_destroy();
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
?>

<!-- para interactuar con el usuario (VIEW)-->
<!DOCTYPE html>
<html>
    <head>
        <title>Supermarket management</title>
    </head>
    <body>
        <h1>Supermarket management</h1>
        <form method="POST" action="">
            <!-- WORKER -->
            <label for="worker">Worker name:</label>
            <input type="text" id="worker" name="worker" required><br>

            <!-- PRODUCT -->
            <label for="product">Product: </label>
            <select id="product" name="Product">
                <option value="milk">Milk</option>
                <option value="soft drink">Soft drink</option>
            </select><br>

            <!-- QUANTITY -->
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="Quantity" required><br>

            <!-- BUTTONS -->
            <button type="submit" name="action" value="add">Add</button>
            <button type="submit" name="action" value="remove">Remove</button>
        </form>
<!--tiene que tener 3 bortones -->

    </body>
</html>