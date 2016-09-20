<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div id="wrapper" align="center">


    <form action="" method="post">
      <h2>PDA</h2>
      <div class="isian">
        <label for="email">Masukan suku kata maksimal [20]</label>
        <br />
        <br />
        <input type="text" name="kata" value="" placeholder="Masukkan Bilangan">
        <br>
        <br>
        <input type="submit" name="submit" value="submit">
      </div>
    </form>


<?

require_once("latihan_pda.php");

//$alphabet=array("a","b");
if(isset($_POST['submit'])){

    $input = $_POST['kata'].' ';

    $states=array(
               "Q1"=>"start",
               "Q2"=>"kosong",
               "Q3"=>"final"
               );

    $transition=array();
    $transition["Q1"]["a"] = "Q1";
    $transition["Q1"]["b"] = "Q1";
    $transition["Q1"]["c"] = "Q2";

    $transition["Q2"]["a"] = "Q2";
    $transition["Q2"]["b"] = "Q2";

    $transition["Q2"][" "] = "Q3";

    //$transition["Q1"]["b"] = false;
    //$transition["Q2"]["a"] = false;
    //$transition["Q2"]["b"] = "Q3";
    //$transition["Q3"]["a"] = "Q2";
    //$transition["Q3"]["b"] = false;


    $kompileSatu = new latihan_pda($states,$transition);
    if ($kompileSatu->cek_input($input)) {?>
       <h3><?php echo $input; ?></h3>
       <h1>Diterima!</h1>
       <br />
       <?php  echo "merupakan PDA" ?>
    <?php
    }else{ ?>
      <h3><?php echo $input; ?></h3>
       <h1>Tidak diterima!</h1>
       <br/>
       <?php  echo $kompileSatu->show_error();?>
    <?php
    }
}
?>
    </div>
  </body>
</html>
