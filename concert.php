<?php
// MariaDB connection configuration TO BE FIXED****
$servername = "hermes.waketech.edu";
$username = "jrussell8";
$password = "csc124";
$dbname = "Customers";
$port = 3306;

// Create a connection to the database using prepared statements
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $name = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'userPhone', FILTER_SANITIZE_EMAIL);
    $adultTickets = filter_input(INPUT_POST, 'adultTickets', FILTER_VALIDATE_INT);
    $childTickets = filter_input(INPUT_POST, 'childTickets', FILTER_VALIDATE_INT);
    $date = filter_input(INPUT_POST, 'eventDate', FILTER_SANITIZE_STRING);

    // Check if any input is invalid
    if ($name !== null && $email !== null && $adultTickets !== false && $childTickets !== false && $date !== null) {
        // Constants
        define("TAX", 0.07);
        define("ADULT_COST", 36.75);
        define("CHILD_COST", 25.50);
        define("MIN_FEE", 0.50);
        define("MAX_FEE", 1.00);
        define("ATTEND", 5);

        // Total tickets calculation
        $totalTickets = $adultTickets + $childTickets;

        // Fee calculation based on the number of tickets
        $fee = ($totalTickets <= ATTEND) ? $totalTickets * MAX_FEE : $totalTickets * MIN_FEE;

        // Subtotal calculation
        $subtotal = ($adultTickets * ADULT_COST) + ($childTickets * CHILD_COST);

        // Sales tax calculation
        $salesTax = $subtotal * TAX;

        // Total cost calculation
        $totalCost = $subtotal + $salesTax + $fee;

        // SQL to insert data into the Customer table
        $sql = "INSERT INTO Customer (LastName, FirstName, Email, AdultTicket, ChildTicket, Date, Location, Subtotal, Tax, Fee, TotalCost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare and bind the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiisdddd", $name, $email, $adultTickets, $childTickets, $date, $location, $subtotal, $salesTax, $fee, $totalCost);
        
        // Execute the statement
        $stmt->execute();
        
        // Close statement
        $stmt->close();

        // Display the results
        echo "<p>Thank you <b>$name</b> at <b>$email</b>.<br/>";
        echo "Details of your total cost <b>$" . number_format($totalCost, 2) . "</b> are shown below:</p>";
        echo "<ul>";
        echo "<li>Adult Tickets: $adultTickets</li>";
        echo "<li>Child Tickets: $childTickets</li>";
        echo "<li>Date: $date</li>";
        echo "<li>Sub-total: $" . number_format($subtotal, 2) . "</li>";
        echo "<li>Sales tax: $" . number_format($salesTax, 2) . "</li>";
        echo "<li>Fee: $" . number_format($fee, 2) . "</li>";
        echo "<li><b>TOTAL:</b> $" . number_format($totalCost, 2) . "</li>";
        echo "</ul>";
        echo "<h3>Thank you for using this program!</h3>";
    } else {
        echo "Invalid input data!";
    }
}

// Close the connection
$conn->close();
?>
