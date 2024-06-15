<?php include('partials-front/menu.php'); ?>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        .contact-section {
            background: #fff;
            padding: 40px;
            margin: 40px auto;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .contact-section h2 {
            margin-top: 0;
            font-size: 2em;
            color: #333;
        }

        .contact-section p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, textarea {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
            width: 100%;
        }

        button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 15px;
            font-size: 1em;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #555;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #333;
            color: #fff;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>BUCHI's RESTAURANT</h1>
    </header>
    <main>
        <section class="contact-section">
            <h2>Contact Us</h2>
            <p>We would love to hear from you. Please fill out the form below and we will get in touch with you shortly.</p>
            <form id="contactForm" method="POST" action="">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    <?php include('partials-front/footer.php'); ?>
</body>
</html>

<?php
// Database configuration
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "food_order_system"; // Replace with your database name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $name = htmlspecialchars(strip_tags(trim($_POST["name"])));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST["message"])));

    // Validate input
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        echo "Invalid input. Please fill out the form correctly.";
        exit;
    }

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tbl_contact (name, email, message) VALUES (?, ?, ?)");
    if ($stmt === FALSE) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Thank you for contacting us, $name. We will get back to you shortly.');</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong, and we couldn't send your message.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
