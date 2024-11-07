<?php
include_once 'inc/header.php';
require_once 'inc/database.php';

// Check if elementtiID is provided in the URL
if (!isset($_GET['elementtiID'])) {
    echo "No item elementtiID specified.";
    exit;
}

$elementtiID = intval($_GET['elementtiID']); // Sanitize the elementtiID input

// Fetch the current item data
try {
    $sql = "SELECT * FROM elementit WHERE elementtiID = :elementtiID";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':elementtiID', $elementtiID, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo "Item not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Handle form submission for updating the item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valmistaja = $_POST['valmistaja'] ?? '';
    $malli = $_POST['malli'] ?? '';
    $koko = $_POST['koko'] ?? '';
    $rms = $_POST['rms'] ?? '';
    $peak = $_POST['peak'] ?? '';
    $fs = $_POST['fs'] ?? '';
    $xmax = $_POST['xmax'] ?? '';
    $spl = $_POST['spl'] ?? '';

    // Validate input
    $valid = true;
    if (empty($valmistaja)) { $valid = false; $valmistajaError = "Syötä valmistaja"; }
    if (empty($malli)) { $valid = false; $malliError = "Syötä malli"; }
    if (empty($koko)) { $valid = false; $kokoError = "Syötä koko"; }
    if (empty($rms)) { $valid = false; $rmsError = "Syötä RMS"; }
    if (empty($peak)) { $valid = false; $peakError = "Syötä PEAK"; }
    if (empty($fs)) { $valid = false; $fsError = "Syötä FS"; }
    if (empty($xmax)) { $valid = false; $xmaxError = "Syötä xmax"; }
    if (empty($spl)) { $valid = false; $splError = "Syötä SPL"; }

    // If input is valid, update the item in the database
    if ($valid) {
        try {
            $sql = "UPDATE elementit SET valmistaja = :valmistaja, malli = :malli, koko = :koko, rms = :rms, peak = :peak, fs = :fs, xmax = :xmax, spl = :spl WHERE elementtiID = :elementtiID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':valmistaja', $valmistaja);
            $stmt->bindParam(':malli', $malli);
            $stmt->bindParam(':koko', $koko);
            $stmt->bindParam(':rms', $rms);
            $stmt->bindParam(':peak', $peak);
            $stmt->bindParam(':fs', $fs);
            $stmt->bindParam(':xmax', $xmax);
            $stmt->bindParam(':spl', $spl);
            $stmt->bindParam(':elementtiID', $elementtiID, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect to the list or detail page after successful update
            header("Location: elementit.php");
            exit;
        } catch (PDOException $e) {
            echo "Error updating item: " . $e->getMessage();
        }
    }
}
?>

<div class="row">
    <div class="col-8 mx-auto">
        <div class="card card-body bg-light mt-3">
            <h3>Muokkaa tuotetietoja</h3>
            <form method="post" class="needs-validation" novalidate>

                <?php
                // Form fields with pre-filled values
                $fields = [
                    'valmistaja' => 'Valmistaja',
                    'malli' => 'Malli',
                    'koko' => 'Koko',
                    'rms' => 'RMS',
                    'peak' => 'Peak',
                    'fs' => 'Fs',
                    'xmax' => 'Xmax',
                    'spl' => 'SPL'
                ];

                foreach ($fields as $field => $label) {
                    $errorVar = $field . "Error";
                    $errorText = $$errorVar ?? '';
                    $value = $_POST[$field] ?? $item[$field];
                    echo "
                    <div class='mb-3'>
                        <label for='$field' class='form-label'>$label</label>
                        <input type='text' value='$value' 
                            class='form-control " . (!empty($errorText) ? 'is-invalid' : '') . "' 
                            id='$field' name='$field' required>
                        <div class='invalid-feedback'><small>$errorText</small></div>
                    </div>";
                }
                ?>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php
include_once 'inc/footer.php';
?>
