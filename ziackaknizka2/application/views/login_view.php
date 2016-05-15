<!DOCTYPE html>
<html>
  <head>
    <title>Žiacka Knižka</title>
      <!-- Bootstrap -->
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
      <!-- Optional theme -->
      <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

      <link rel="stylesheet" href="<?= base_url() ?>/css/main.css"/>
      <meta charset="utf-8" />
  </head>
  <body>
    <header>
      <h1>Prihlás sa</h1>
      <?php echo validation_errors(); ?>
    </header>
    <main>
      <form action="<?= base_url() ?>index.php/verifylogin/index" method="post" accept-charset="utf-8"  role="form" class="form-horizontal form-inline login-form">
        <label for="prihlasovacie_meno">Meno:</label>
        <input type="text" size="20" id="prihlasovacie_meno" name="prihlasovacie_meno" class"form-control"/>
        <br/>
        <label for="heslo">Heslo:</label>
        <input type="password" size="20" id="heslo" name="heslo" class"form-control"/>
        <br/>
        <input type="submit" value="Prihlás" class="btn btn-primary btn-sm"/>
      </form>
    </main>
  </body>
</html>