<?php
$filename = dirname(__FILE__) . '/../config.php';
switch(filter_input(INPUT_GET, 'step', FILTER_VALIDATE_INT)) {
    case 2:
        //database config
        $disabled = '';
        //Testing the connection with the new settings once saved
        
        if(isset($_GET['test']) && filter_input(INPUT_GET, 'test', FILTER_VALIDATE_INT) === 1) {
            include $filename;
            try {
                $dbc = new PDO('mysql:host='. $db['host'] . ';port=' . $db['port']. ';dbname=' . $db['name'], $db['user'], $db['pass']);
                $alert = "Connection to db is successful";
                $alert_class = 'alert-success';
            }
            catch (PDOException $e) {
                $alert = "Connection to db failed";
                $alert_class = 'alert-danger';
            }
        }
        //save to file the database config
        if(isset($_GET['save']) && filter_input(INPUT_GET, 'save', FILTER_VALIDATE_INT) === 1) {
            $filename = dirname(__FILE__) . '/../config.php';
            
            if(is_writeable($filename)) {
                $data = $_POST;
                $configHandle = fopen($filename, 'w');
                //ftruncate($configHandle, 0);
                $configTxt = "<?php \n"
                . "\$db = [\n"
                    ."\t'host' => '".filter_var($data['dbhost'], FILTER_VALIDATE_DOMAIN)."',\n"
                    ."\t'port' => '".filter_var($data['dbport'], FILTER_VALIDATE_INT)."',\n"
                    ."\t'name' => '".filter_var($data['dbname'], FILTER_SANITIZE_STRING)."',\n"
                    ."\t'user' => '".filter_var($data['dbuser'], FILTER_SANITIZE_STRING)."',\n"
                    ."\t'pass' => '".filter_var($data['dbpass'], FILTER_SANITIZE_SPECIAL_CHARS)."'\n"
                ."];";
                fwrite($configHandle,$configTxt);
                fclose($configHandle);
                $disabled = 'disabled ';
            }
        }
        
        $form = '<h2 class="text-center">Database Configuration</h2>'
            . '<p class="text-center">You need to save before testing the connection to the database.</p>'
            . '<div class="row">'
            . '<form action="/install/?step=2&save=1" method="post">'
                . '<div class="offset-4 col-md-4">'
                    . '<div class="row">'
                        . '<div class="col-md-6">'
                            . '<label for="dbhost">Host : </label>'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<input type="text" name="dbhost" placeholder="DNS or IP" ' . $disabled . 'required />'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<label for="dbport">Port : </label>'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<input type="text" name="dbport" ' . $disabled . 'required />'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<label for="dbname">Database Name : </label>'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<input type="text" name="dbname" ' . $disabled . 'required />'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<label for="dbuser">User : </label>'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<input type="text" name="dbuser" ' . $disabled . 'required />'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<label for="dbpass">Password : </label>'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . '<input type="text" name="dbpass" ' . $disabled . 'required />'
                        . '</div>'
                    . '</div>'
                . '</div>'
                . '<div class="col-md-12 text-center">'
                    . '<div class="btn-group" role="group" aria-label="dbconfig">'
                        . '<a href="/install/?step=2&test=1" class="btn btn-primary">Test connection</a>'
                        . '<button type="submit"' . $disabled . ' class="btn btn-primary">Save</button>'
                        . '<a href="/install/?step=3" class="btn btn-primary">Next Step</a></div>'
                    . '</div>'
                . '</div>'
            . '</form>'
        . '</div>';
        
        $content = $form;
        break;
    case 3:
        if(isset($_GET['publish']) && filter_input(INPUT_GET, 'publish',FILTER_VALIDATE_INT) === 1) {
            include $filename;
            $disabled = '';
            // Get the sql queries ready for creating the database
            $sqlHandle = fopen('./buzzer.sql', 'r');
            $sql = fread($sqlHandle, filesize('./buzzer.sql'));
            try {
                $dbc = new PDO('mysql:host='. $db['host'] . ';port=' . $db['port']. ';dbname=' . $db['name'], $db['user'], $db['pass']);
                $dbc->query($sql);
                $alert = "Publish schema to db is successful";
                $alert_class = 'alert-success';
                $disabled = 'disabled ';
            }
            catch (PDOException $e) {
                $alert = "Connection to db failed";
                $alert_class = 'alert-danger';
            }

        }
        $content = '<p class="text-center">We need to publish the database schema.</p>'
                . '<div class="col-md-12 text-center">'
                    . '<div class="btn-group" role="group" aria-label="adminUser">'
                        . '<a href="/install/?step=3&publish=1" ' . $disabled . 'class="btn btn-primary">Publish</a>'
                        . '<a href="/install/?step=4" class="btn btn-primary">Next Step</a></div>'
                    . '</div>'
                . '</div>';
        break;
    case 4:
        //admin user setup
        $disabled = '';
        if(isset($_GET['save']) && filter_input(INPUT_GET, 'save', FILTER_VALIDATE_INT) === 1) {
            if($_POST['password'] !== $_POST['password2']) {
                $alert = "Password do not match";
                $alert_class = "alert-danger";
            } else {
                include $filename;
                
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
                
                try {
                    $dbc = new PDO('mysql:host='. $db['host'] . ';port=' . $db['port']. ';dbname=' . $db['name'], $db['user'], $db['pass']);
                    $dbc->query("INSERT INTO users (username, pass, enabled) VALUES ('" . filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING) . "','" . $hashed_pass . "', '1');");
                    $alert = "Created adminsitrator in db is successful";
                    $alert_class = 'alert-success';
                    $disabled = 'disabled ';
                }
                catch (PDOException $e) {
                    $alert = "Connection to db failed";
                    $alert_class = 'alert-danger';
                }
            }
        }
        $content = '<h2 class="text-center">Administrator creation</h2>'
        . '<div class="row">'
            . '<form action="/install/?step=4&save=1" method="post">'
                . '<div class="offset-4 col-md-4">'
                    . '<div class="row">'
                        . '<div class="col-md-12">'
                            . '<input type="text" name="username" ' . $disabled . 'placeholder="Username" value="' . $_POST['username'] . '" required />'
                        . '</div>'
                        . '<div class="col-md-12">'
                            . '<input type="password" name="password" ' . $disabled . 'placeholder="Password" required />'
                        . '</div>'
                        . '<div class="col-md-12">'
                            . '<input type="password" name="password2" ' . $disabled . 'placeholder="Repeat password" required />'
                        . '</div>'
                    . '</div>'
                . '</div>'
                . '<div class="col-md-12 text-center">'
                    . '<div class="btn-group" role="group" aria-label="adminUser">'
                        . '<button type="submit" ' . $disabled . 'class="btn btn-primary">Save</button>'
                        . '<a href="/install/?step=5" class="btn btn-primary">Next Step</a></div>'
                    . '</div>'
                . '</div>'
            . '</form>'
        . '</div>';
        break;
    case 5:
        $content = '<h2 class="text-center">Finished</h2>'
            . '<div class="row">'
            . '<div class="offset-4 col-md-4 text-center">'
            . '<a href="/" class="btn btn-primary">To the website</a>'
            . '</div>'
            . '</div>';
        break;
    case 1: 
    default:
        //welcome
        $pdo = (extension_loaded('pdo'))? 'installed': 'not installed';
        $pdoMysql = (extension_loaded('pdo_mysql'))? 'installed': 'not installed';
        $content = '<div class="row">'
                . '<div class="col-md-12 text-center">'
                    . 'Requirements'
                . '</div>'
                . '<div class="offset-4 col-md-4">'
                    . '<div class="row">'
                        . '<div class="col-md-6">'
                            . 'PDO'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . $pdo
                        . '</div>'
                        . '<div class="col-md-6">'
                            . 'PDO Mysql'
                        . '</div>'
                        . '<div class="col-md-6">'
                            . $pdoMysql
                        . '</div>'
                    . '</div>'
                . '</div>'
                . '<div class="col-md-12 text-center">'
                    . '<a href="/install/?step=2" class="btn btn-primary">Next Step</a></div>'
                . '</div>'
            . '</div>';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Installer</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" type="text/css">
    </head>
    <body>
        <main>
            <section id="steps">
                <div class="container">
                    <h1 class="text-center">Welcome to the buzzer for trivia installer</h1>
                    <?php if(isset($alert)){ ?>
                    <div class="row">
                        <div class="offset-3 col-md-6">
                            <div class="alert <?= $alert_class ?>" role="alert">
                                <?= $alert; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?= $content; ?>
                </div>
            </section>
        </main>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    </body>
</html>
