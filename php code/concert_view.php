<DOCTYPE html>
<html>
<head>
<title>Concert View</title>
</head>
<body>

<?php
// Database connection
$servername = "hermes.waketech.edu";
$username = "kamarante";
$password = "csc124";
$dbname = "Customer";
$port = 3306;

$id = $_POST['id'];
$name = $_POSR['name'];

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Database lookup
$sql = "SELECT Lastname, FirstName, Email, AdultTicket, ChildTicket, 
Date, Location, Subtotal, Tax, Fee, TotalCost, CustomerID 
FROM Customer WHERE LastName = '$name' OR CustomerID = '$id';";

$result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            print("<p>The following record was retrieved from the Customer table:</p>");
            print("<table border = \"1\">");
            print("<tr><th>LastName</th><th>FirstName</th><th>Email</th>
            <th>AdultTicket</th><th>ChildTicket></th><th>Date</th>
            <th>Location</th><th>Subtotal</th><th>Tax</th>
            <th>Fee</th><th>TotalCost</th><th>CustomerID</th>");
         while($row = mysqli_fetch_assoc($result)) {
            print("<tr><td>".$row['LastName']."</td><td>".$row['FirstName']."</td><td>"
            .$row['Email']."</td><td>".$row['AdultTicket']."</td><td>".$row['ChildTicket']."</td><td>"
            .$row['Date']."</td><td>".$row['Location']."</td><td>".$row['Subtotal']."</td><td>"
            .$row['tax']."</td><td>".$row['Fee']."</td><td>".$row['TotalCost']."</td><td>".$row['CustomerID']."</td></tr>");
         }
         print("</table>");
        } else{
            echo "0 results";
        }
?>
</body>
</html>