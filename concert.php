<?php
// Declare and define global named constants
define("TAX", 0.07);
define("ADULT_COST", 36.75);
define("CHILD_COST", 25.50);
define("MIN_FEE", 0.50);
define("MAX_FEE", 1.00);
define("ATTEND", 5);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['userName']; // User's name
    $email = $_POST['userPhone']; // User's phone number
    $adultTickets = $_POST['adultTickets']; // Number of adult tickets
    $childTickets = $_POST['childTickets']; // Number of child tickets
    $date = $_POST['eventDate']; // Selected event date

    // Total tickets calculation
    $totalTickets = $adultTickets + $childTickets;

    // Fee calculation based on the number of tickets
    if ($totalTickets <= ATTEND) {
        $fee = $totalTickets * MAX_FEE;
    } else {
        $fee = $totalTickets * MIN_FEE;
    }

    // Subtotal calculation
    $subtotal = ($adultTickets * ADULT_COST) + ($childTickets * CHILD_COST);
    
    // Sales tax calculation
    $salesTax = $subtotal * TAX;
    
    // Total cost calculation
    $totalCost = $subtotal + $salesTax + $fee;

    // Display the results
    echo "<p>Thank you <b>$name</b> at <b>$email</b>.<br/>";
    echo "Details of your total cost <b>$" . number_format($totalCost, 2) . "</b> are shown below:</p>";
    echo "<ul>";
    echo "<li>Adult Tickets: $adultTickets</li>";
    echo "<li>Child Tickets: $childTickets</li>";
    echo "<li>Date: $date</li>";
    // The location should be added here if you have that data.
    echo "<li>Sub-total: $" . number_format($subtotal, 2) . "</li>";
    echo "<li>Sales tax: $" . number_format($salesTax, 2) . "</li>";
    echo "<li>Fee: $" . number_format($fee, 2) . "</li>";
    echo "<li><b>TOTAL:</b> $" . number_format($totalCost, 2) . "</li>";
    echo "</ul>";
    echo "<h3>Thank you for using this program!</h3>";
}
?>
