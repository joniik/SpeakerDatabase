<?php
include_once "inc/header.php";
require_once 'inc/database.php';

if(!empty($_POST)){

    $elementtiID = $_POST['elementtiID'];
    $valmistaja = $_POST['valmistaja'];
    $malli = $_POST['malli'];
    $koko = $_POST['koko'];
    $rms = $_POST['rms'];
    $peak = $_POST['peak'];
    $xmax = $_POST['xmax'];
    $spl = $_POST['spl'];

}
?>

<?php
  include_once 'inc/header.php';
?>

      <div style="padding-top:10px" class="row">
        <h3 style="color:White;">tuotetiedot</h3>
      </div>
      <div class="row">
        <p>
          <a href="lisaa_tuote.php" class="btn btn-dark">Lisää</a>
        </p>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Valmistaja</th>
              <th>Malli</th>
              <th>Koko inch</th>
              <th>Rms W</th>
              <th>Peak W</th>
              <th>Fs Hz</th>
              <th>Xmax mm</th>
              <th>Spl Db</th>
              <th>Toiminnot</th>
            </tr>
          </thead>
          <tbody>
            <?php
              //Luodaan yhteys tietokantaan ja haetaan tuotetietoja
              require_once 'inc/database.php';
              $sql = "SELECT * FROM elementit";
              $result = $pdo->query($sql);

              while($row = $result->fetch()):
            ?>
              <tr>
                <td><?php echo $row['elementtiID']; ?></td>
                <td><?php echo $row['valmistaja']; ?></td>
                <td><?php echo $row['malli']; ?></td>
                <td><?php echo $row['koko']; ?></td>
                <td><?php echo $row['rms']; ?></td>
                <td><?php echo $row['peak']; ?></td>
                <td><?php echo $row['fs']; ?></td>
                <td><?php echo $row['xmax']; ?></td>
                <td><?php echo $row['spl']; ?></td>

                <td>
                  <a href="Poista_tuote.php?elementtiID=<?php echo $row['elementtiID'];?>" class="btn btn-danger">Poista</a>
                  <a href="muokkaa_tuote.php?elementtiID=<?php echo $row['elementtiID'];?>" class="btn btn-dark">Päivitä</a>
                </td>
              </tr>

            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

<?php
include_once "inc/footer.php";
?>