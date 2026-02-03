<?php
$result = ""; // stores the calculation result

if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operator = $_POST['operator'];

    // Simple validation
    if (is_numeric($num1) && is_numeric($num2)) {
        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = "Cannot divide by zero!";
                }
                break;
            default:
                $result = "Invalid operator!";
        }
    } else {
        $result = "Please enter valid numbers!";
    }
}
?>

<!DOCTYPE html>
<html><?php
session_start();

// Initialize or reset calculator display
if (!isset($_SESSION['calc'])) {
    $_SESSION['calc'] = '';
}

// Reset button
if (isset($_POST['clear'])) {
    $_SESSION['calc'] = '';
}

// Equals button
if (isset($_POST['equals'])) {
    // Evaluate the expression safely
    $expression = $_SESSION['calc'];
    // Only allow numbers and operators
    if (preg_match('/^[0-9+\-*\/.() ]+$/', $expression)) {
        try {
            // eval is safe here because of regex check
            $_SESSION['calc'] = eval("return $expression;");
        } catch (Throwable $e) {
            $_SESSION['calc'] = 'Error';
        }
    } else {
        $_SESSION['calc'] = 'Error';
    }
}

// Button pressed
if (isset($_POST['btn'])) {
    $_SESSION['calc'] .= $_POST['btn'];
}

$display = $_SESSION['calc'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interactive Calculator</title>
    <style>
        body { font-family: Arial; text-align: center; margin-top: 50px; }
        .calculator { display: inline-block; border: 2px solid #333; padding: 10px; border-radius: 10px; }
        .display { width: 180px; height: 40px; margin-bottom: 10px; text-align: right; padding: 5px; font-size: 20px; border: 1px solid #999; }
        .button { width: 40px; height: 40px; margin: 2px; font-size: 18px; cursor: pointer; }
        .button.operator { background-color: #f0ad4e; color: white; }
        .button.equals { background-color: #5cb85c; color: white; }
        .button.clear { background-color: #d9534f; color: white; }
    </style>
</head>
<body>
    <h2>Calculator</h2>
    <form method="POST">
        <div class="calculator">
            <input type="text" class="display" value="<?= htmlspecialchars($display) ?>" readonly>

            <br>
            <!-- Numbers -->
            <?php
            $buttons = [
                ['7','8','9','/'],
                ['4','5','6','*'],
                ['1','2','3','-'],
                ['0','.','=','+']
            ];
            foreach ($buttons as $row) {
                foreach ($row as $btn) {
                    if ($btn == '=') {
                        echo "<button class='button equals' name='equals'>$btn</button>";
                    } elseif (in_array($btn, ['+','-','*','/'])) {
                        echo "<button class='button operator' name='btn' value='$btn'>$btn</button>";
                    } else {
                        echo "<button class='button' name='btn' value='$btn'>$btn</button>";
                    }
                }
                echo "<br>";
            }
            ?>
            <button class="button clear" name="clear">C</button>
        </div>
    </form>
</body>
</html>

<head>
    <title>Simple Calculator</title>
</head>
<body>
    <h2>Simple Calculator</h2>
    <form method="POST">
        <input type="number" name="num1" placeholder="Number 1" required>
        <select name="operator" required>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="number" name="num2" placeholder="Number 2" required>
        <button name="calculate">Calculate</button>
    </form>

    <?php if ($result !== ""): ?>
        <h3>Result: <?= $result ?></h3>
    <?php endif; ?>
</body>
</html>
<!-- Open XAMPP Control Panel.

Start Apache (you don’t need MySQL for this). -->