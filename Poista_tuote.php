<?php
include_once "inc/header.php";
require_once 'inc/database.php';
?>

<?php
// Check if elementtiID is provided in the URL
if (isset($_GET['elementtiID'])) {
    $elementtiID = intval($_GET['elementtiID']); // Sanitize the elementtiID input
    
    try {
        // Prepare the SQL DELETE statement
        $sql = "DELETE FROM elementit WHERE elementtiID = :elementtiID";
        $stmt = $pdo->prepare($sql);
        
        // Bind the elementtiID parameter
        $stmt->bindParam(':elementtiID', $elementtiID, PDO::PARAM_INT);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "The item with elementtiID $elementtiID has been deleted successfully.";
        } else {
            echo "An error occurred while trying to delete the item.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No item elementtiID specified.";
}
?>


<?php
include_once "inc/footer.php";
?>