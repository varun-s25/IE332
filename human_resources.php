<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$server = 'mydb.ics.purdue.edu';
$dbname = 'g1130865';
$username = 'g1130865';
$password = 'GroupNine';

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$storeID = '';  // Initialize the storeID variable
$applicants = [];  // Initialize an empty array to store applicant data

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['store_id']) && $_POST['store_id'] !== '') {
    $storeID = $_POST['store_id'];

    // Prepare and execute the SQL query
    $query = $conn->prepare("SELECT Applicant_First_Name, Applicant_Last_Name, Applicant_Phone, Application_Status FROM human_resources WHERE Store_ID = ?");
    if ($query) {
        $query->bind_param("i", $storeID);
        $query->execute();
        
        // Bind result variables
        $query->bind_result($firstName, $lastName, $phone, $status);
        
        // Fetch values
        while ($query->fetch()) {
            $applicants[] = [
                'Applicant_First_Name' => $firstName,
                'Applicant_Last_Name' => $lastName,
                'Applicant_Phone' => $phone,
                'Application_Status' => $status
            ];
        }
        $query->close();
    } else {
        echo "Failed to prepare the query: " . htmlspecialchars($conn->error);
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Details</title>
</head>
<body>
    <h1>Applicant Information Viewer</h1>
    <form method="post">
        Enter Store ID: <input type="text" name="store_id" value="<?php echo htmlspecialchars($storeID); ?>">
        <button type="submit">View Applicants</button>
    </form>

    <?php if (!empty($applicants)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Application Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applicants as $applicant): ?>
            <tr>
                <td><?php echo htmlspecialchars($applicant['Applicant_First_Name']); ?></td>
                <td><?php echo htmlspecialchars($applicant['Applicant_Last_Name']); ?></td>
                <td><?php echo htmlspecialchars($applicant['Applicant_Phone']); ?></td>
                <td><?php echo htmlspecialchars($applicant['Application_Status']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</body>
</html>
