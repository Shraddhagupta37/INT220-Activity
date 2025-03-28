<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Form</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            background-color: #f4f4f4;
        }

        .error {
            color: red;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 400px;
            padding: 30px;
            border-radius: 8px;
            background-color: azure;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            /* align-items: center; */
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .success {
            font-weight: bold;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .success button {
            margin-top: 10px;
            padding: 8px 16px;
            border: none;
            background: green;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <?php
        $name = $email = $pass = "";
        $nameErr = $emailErr = $passErr = "";
        $display = false;

        function test_input($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Name Validation
            if (empty($_POST["name"])) {
                $nameErr = "Name is required!";
            } else {
                $name = test_input($_POST["name"]);
                if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                    $nameErr = "Invalid name!";
                    $name = "";
                }
            }

            // Email Validation
            if (empty($_POST["email"])) {
                $emailErr = "Email is required!";
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email!";
                    $email = "";
                }
            }

            // Password Validation
            if (empty($_POST["pass"])) {
                $passErr = "Password is required!";
            } else {
                $pass = $_POST["pass"];
                if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/", $pass)) {
                    $passErr = "Password must be at least 6 characters, alphanumeric, and contain @, $, !, %, *, ?, &";
                    $pass = "";
                }
            }

            if($nameErr == "" && $emailErr == "" && $passErr == "") {
                $display = true;
            }
        }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-container">
        <div>
            <label for="name">Enter your name:</label>
            <input type="text" name="name" id="name" placeholder="Enter name" value="<?php echo $name; ?>">
            <span class="error"><?php echo $nameErr; ?></span>
        </div>
        
        <div>
            <label for="email">Enter your email:</label>
            <input type="text" name="email" id="email" placeholder="Enter email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $emailErr; ?></span>
        </div>

        <div>
            <label for="pass">Enter your password:</label>
            <input type="password" name="pass" id="pass" placeholder="Enter password" value="<?php echo $pass; ?>">
            <span class="error"><?php echo $passErr; ?></span>
        </div>

        <div style="display: flex; justify-content: center;">
            <input type="submit" value="LOGIN">
        </div>
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($display == true) {
                echo "<div class='success'>
                        <h3>Login Successful!</h3>
                        <form method='get'>
                            <button type='submit'>OK</button>
                        </form>
                    </div>";
            }
        }
    ?>

</body>
</html>