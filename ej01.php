<!--
Ejercicio01.php - Crea un formulario que permita gestionar la cantidad de refresco o leche que hay en un supermercado. (2 puntos) 
    a) Se debe mantener el nombre del trabajador que está uƟlizando la aplicación. 
    b) Se debe poder añadir y quitar leche o refresco seleccionando de una lista
    c) Se debe controlar que no se pueden quitar mas unidades de las que haya, en ese caso mostrar error.
-->

<?php //para procesar la inc¡formacion (CONTROLADOR)
//when user click on a button (if from POST has been submitted)
    session_start();

// define session products if they do not exist
if (!isset($_SESSION['softDrink'])) {
    $_SESSION['softDrink'] = 0;
}
if (!isset($_SESSION['milk'])) {
    $_SESSION['milk'] = 0;
}
if (!isset($_SESSION['worker'])) {
    $_SESSION['worker'] = null;
}
//if from POST has been submited
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// get data from form
        $worker = $_POST['worker'];
        $product = $_POST['product'] ;
        $quantity = $_POST['Quantity'];
        // save in session worker
        $_SESSION["worker"] = $worker;
        // add products
        if (isset($_POST['add'])) {
            switch ($product) {
                case 'milk':
                    $_SESSION['milk']+=$quantity;
                    break;
                case 'softDrink':
                    $_SESSION['softDrink']+=$quantity;
                    break;
                default:
                    # code...
                    break;
            }
            //remove products
            }elseif (isset($_POST['remove'])) {

                switch ($product) {
                    case 'milk':
                        if ($_SESSION['milk'] - $quantity < 0) {
                            echo "<br> <font color= 'red'> <p> Error: It is impossible remove more quantity than we have in store.</p></dont>";
                        } else {
                            $_SESSION['milk'] -= $quantity;
                        }
                        break;
                    case 'softDrink':
                        if ($_SESSION['softDrink'] - $quantity < 0) {
                            echo "<br> <font color= 'red'> <p> Error: It is impossible remove more quantity than we have in store.</p></dont>";
                        } else {
                            $_SESSION['softDrink'] -= $quantity;
                        }                        break;
                    default:
                    echo "<br> <font color= 'red'> <p> Error: Product not found.</p></dont>";
                        break;
                }
                }
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
        <form method="POST" action="ej01.php">
            <!-- WORKER -->
            <label for="worker">Worker name:</label>
            <input type="text" id="worker" name="worker" required><br>

            <!-- PRODUCT -->
            <h2>Choose product:</h2>
            <select id="product" name="Product">
                <option value="milk">Milk</option>
                <option value="soft drink">Soft drink</option>
            </select><br>

            <!-- QUANTITY -->
            <h2>Quantity: </h2>
            <input type="number" id="quantity" name="Quantity" required><br>

            <!-- BUTTONS -->
            <button type="submit" name="action" value="add">Add</button>
            <button type="submit" name="action" value="remove">Remove</button>
        </form>
<!--tiene que tener 3 bortones -->
    <h2>Inventory:</h2>
    <p>worker: <?php echo isset($_SESSION['worker']) ? $_SESSION['worker'] : ''; ?></p>
    <p>units milk: <?php echo isset($_SESSION['milk']) ? $_SESSION['milk'] : ''; ?></p>
    <p>units soft drink: <?php echo isset($_SESSION['softDrink']) ? $_SESSION['softDrink'] : ''; ?></p>
</body>
</html>