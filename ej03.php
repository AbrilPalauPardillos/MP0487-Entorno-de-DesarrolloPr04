<!--
Crea un código php que permita gesƟonar una lista de la compra. 
    a) Permite asignar un nombre, canƟdad y precio a un item. 
    b) Permite añadir un nuevo item.  
    c) Permite editar un item en concreto.  
    d) Permite borrar un item en concreto. 
    e) Permite almacenar de cada item su coste total  
    f) Muestra el coste total de la lista.  
-->
<?php
session_start();

# initializa list if not exist in session
if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
}

$error = $message = "";
$name = $quantity = $price = "";
$index = -1;
$totalValue = 0;

# add new item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    
    if ($name && $quantity > 0 && $price > 0) {
        $_SESSION['list'][] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];
        $message = "Item added successfully.";
    } else {
        $error = "Please fill all fields correctly.";
    }
}

# modify item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $index = $_POST['index'];
}

# update item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $index = (int)$_POST['index'];
    if ($index >= 0 && isset($_SESSION['list'][$index])) {
        $_SESSION['list'][$index] = [
            'name' => trim($_POST['name']),
            'quantity' => (int)$_POST['quantity'],
            'price' => (float)$_POST['price']
        ];
        $message = "Item updated successfully.";
    } else {
        $error = "Invalid item selection.";
    }
}

# delete item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $index = (int)$_POST['index'];
    if ($index >= 0 && isset($_SESSION['list'][$index])) {
        array_splice($_SESSION['list'], $index, 1);
        $message = "Item deleted successfully.";
    } else {
        $error = "Invalid item selection.";
    }
}

# calculate the total cost
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['total'])) {
    foreach ($_SESSION['list'] as $item) {
        $totalValue += $item['quantity'] * $item['price'];
    }
}

# reset list
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
    $_SESSION['list'] = [];
    $message = "Shopping list cleared.";
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo $price; ?>">
        <br>
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
    <p style="color:green;"><?php echo $message; ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['list'] as $index => $item) { ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity'] * $item['price']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="name" value="<?php echo $item['name']; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">
                            <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="submit" name="edit" value="Edit">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo $totalValue; ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</body>