<?php
include_once 'inc/header.php';
require_once 'inc/database.php';

if (!empty($_POST)) {

  $valmistaja = $_POST['valmistaja'] ?? '';
  $malli = $_POST['malli'];
  $koko = $_POST['koko'];
  $rms = $_POST['rms'];
  $peak = $_POST['peak'];
  $fs = $_POST['fs'];
  $xmax = $_POST['xmax'];
  $spl = $_POST['spl'];

  // tarkistetaan tietojen oikeeellisuus
  $valid = true;

  if (empty($valmistaja)) {
    $valid = false;
    $valmistajaError = "Syötä valmistaja";
  }

  if (empty($malli)) {
    $valid = false;
    $malliError = "Syötä malli";
  }

  if (empty($koko)) {
    $valid = false;
    $kokoError = "Syötä koko";
  }
  
  if (empty($rms)) {
    $valid = false;
    $rmsError = "Syötä RMS";
  }

  if (empty($peak)) {
    $valid = false;
    $peakError = "Syötä PEAK";
  }
  
  if (empty($fs)) {
    $valid = false;
    $fsError = "Syötä FS";
  }
    
  if (empty($xmax)) {
    $valid = false;
    $xmaxError = "Syötä xmax";
  }

  if (empty($spl)) {
    $valid = false;
    $splError = "Syötä spl";
  }
  
  if ($valid) {

    $sql = "INSERT INTO elementit (valmistaja,malli,koko,rms,peak,fs,xmax,spl) VALUES (:valmistaja,:malli,:koko,:rms,:peak,:fs,:xmax,:spl);";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':valmistaja', $valmistaja);
    $stmt->bindParam(':malli', $malli);
    $stmt->bindParam(':koko', $koko);
    $stmt->bindParam(':rms', $rms);
    $stmt->bindParam(':peak', $peak);
    $stmt->bindParam(':fs', $fs);
    $stmt->bindParam(':xmax', $xmax);
    $stmt->bindParam(':spl', $spl);

    $stmt->execute();

    header("Location: elementit.php");
    exit;
  }
} else {

  //yleiset ohjetekstit
  $valmistajaError = 'Syötä valmistaja';
  $malliError = 'Syötä malli';
  $kokoError = 'Syötä koko';
  $rmsError = 'Syötä rms';
  $peakError = 'Syötä peak';
  $fsError = 'Syötä fs';
  $xmaxError = 'Syötä xmax';
  $splError = 'Syötä spl';

}

?>
<div class="row">
  <div class="col-8 mx-auto">
    <div class="card card-body bg-light mt-3">
      <h3>Tuotetietojen lisääminen</h3>

      <form method="post" enctype="multipart/form-data"
      class="needs-validation" novalidate>

        <div class="mb-3">
          <label for ="valmistaja" class="form-label">valmistaja</label>
          <input type = "text" 
          value = "<?php echo (!empty($valmistaja)) ? $valmistaja : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($valmistajaError)) ? 'is-invalid' : ''; ?>" 
          id = "valmistaja" 
          name = "valmistaja" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $valmistajaError ?? ''; ?></small>
          </div>
        </div>

        <div class="mb-3">
          <label for ="malli" class="form-label">malli</label>
          <input type = "text" 
          value = "<?php echo (!empty($malli)) ? $malli : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($malliError)) ? 'is-invalid' : ''; ?>" 
          id = "malli" 
          name = "malli" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $malliError ?? ''; ?></small>
          </div>
        </div>

        <div class="mb-3">
          <label for ="koko" class="form-label">koko</label>
          <input type = "text" 
          value = "<?php echo (!empty($koko)) ? $koko : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($kokoError)) ? 'is-invalid' : ''; ?>" 
          id = "koko" 
          name = "koko" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $kokoError ?? ''; ?></small>
          </div>
        </div>

        <div class="mb-3">
          <label for ="rms" class="form-label">rms</label>
          <input type = "text" 
          value = "<?php echo (!empty($rms)) ? $rms : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($rmsError)) ? 'is-invalid' : ''; ?>" 
          id = "rms" 
          name = "rms" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $rmsError ?? ''; ?></small>
          </div>
        </div>
        
        <div class="mb-3">
          <label for ="peak" class="form-label">peak</label>
          <input type = "text" 
          value = "<?php echo (!empty($peak)) ? $peak : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($peakError)) ? 'is-invalid' : ''; ?>" 
          id = "peak" 
          name = "peak" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $peakError ?? ''; ?></small>
          </div>
        </div>
                
        <div class="mb-3">
          <label for ="fs" class="form-label">fs</label>
          <input type = "text" 
          value = "<?php echo (!empty($fs)) ? $fs : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($fsError)) ? 'is-invalid' : ''; ?>" 
          id = "fs" 
          name = "fs" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $fsError ?? ''; ?></small>
          </div>
        </div>
                        
        <div class="mb-3">
          <label for ="xmax" class="form-label">xmax</label>
          <input type = "text" 
          value = "<?php echo (!empty($xmax)) ? $xmax : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($xmaxError)) ? 'is-invalid' : ''; ?>" 
          id = "xmax" 
          name = "xmax" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $xmaxError ?? ''; ?></small>
          </div>
        </div>

                                
        <div class="mb-3">
          <label for ="spl" class="form-label">spl</label>
          <input type = "text" 
          value = "<?php echo (!empty($spl)) ? $spl : ''; ?>" 
          class = "form-control 
          <?php echo (!empty($_POST) && !empty($splError)) ? 'is-invalid' : ''; ?>" 
          id = "spl" 
          name = "spl" 
          aria-describedby=""
          required
          >
          <div class="invalid-feedback">
            <small><?php echo $splError ?? ''; ?></small>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      
      </form>
    </div>
  </div>
</div>
<?php
include_once 'inc/footer.php';
