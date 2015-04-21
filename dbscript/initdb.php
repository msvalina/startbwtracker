<?php 
/* Create database, create tables, read ./progression.json
 * and populate tables */

echo "Reading ./progression.json <br>";
$progressions = file_get_contents("./progression.json");
$progressionsArray = json_decode($progressions, TRUE);

$prgsArray = array();
$id = 0;

foreach ($progressionsArray as $prgTypeName => $prgTypeVal) {
    $type = $prgTypeName;
    foreach ($prgTypeVal as $prgPropsArray) {
        $id++;
        /* Setting description, goal, media to default values so they can be */
        /* left out in ./progression.json */ 
        $description = NULL;
        $goal = 888;
        $media = NULL;
        foreach ($prgPropsArray as $key => $value) {
            /* print "$key => $value\n"; */
            switch ($key) {
                case 'type':
                    $type = $value;
                    break;
                case 'name':
                    $name = "$value";
                    break;
                case 'position':
                    $position = $value;
                    break;
                case 'description':
                    $description = $value;
                    break;
                case 'goal':
                    $goal = $value;
                    break;
                case 'media':
                    $media = $value;
                    break;
                default:
                    echo "Ups I Shouldn't be here";
                    break;
            }
        }
        $prg = array (
            "id" => $id, 
            "type" => $type, 
            "name" => $name, 
            "position" => $position, 
            "description" => $description, 
            "goal" => $goal, 
            "media" => $media
        );
        array_push($prgsArray, $prg);
    }
}

$servername = "localhost";
$username = "root";
$password = "mantis5c";
$database = "startbwtracker";

try {
    $db = new PDO("mysql:host=$servername;", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP DATABASE IF EXISTS $database; CREATE DATABASE $database;";
    // use exec() because no results are returned
    $db->exec($sql);
    echo "Database created successfully<br>";
    $db->exec("USE $database;");
    
    // sql to create Progression table
    $sql = <<<SQL
        DROP TABLE IF EXISTS `Progression`;
        CREATE TABLE `Progression` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `type` varchar(30) NOT NULL,
          `name` varchar(50) NOT NULL,
          `position` int(11) NOT NULL,
          `description` text,
          `goal` int(11) NOT NULL,
          `media` text
        );
SQL;
    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table Progression created successfully<br>";

    // sql to create Users table
    $sql = <<<SQL
        DROP TABLE IF EXISTS `User`;
        CREATE TABLE `User` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `username` varchar(50) NOT NULL,
          `password` varchar(50) NOT NULL,
          `email` varchar(50) NOT NULL
        );
SQL;
    $db->exec($sql);
    echo "Table User created successfully<br>";

    $sql = <<<SQL
        DROP TABLE IF EXISTS `ExerciseSession`;
        CREATE TABLE `ExerciseSession` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `date` date NOT NULL,
          `goal` int(11) NOT NULL,
          `performed` int(11) NOT NULL,
          `repeat` boolean NOT NULL default TRUE,
          `next_progression` boolean NOT NULL default TRUE,
          `notes` text NOT NULL,
          `usr_id` int(11) NOT NULL,
          `prg_id` int(11) NOT NULL, 
          FOREIGN KEY(prg_id) REFERENCES Progression(id),
          FOREIGN KEY(usr_id) REFERENCES User(id)
        );
SQL;
    $db->exec($sql);
    echo "Table ExerciseSession created successfully<br>";


    echo "Inserting progressions into Progression table<br>";
    foreach ($prgsArray as $prg) {
        // Maybe this should be done with pdo prepare and execute but I tried
        // and didn't get far, so fuck it it ain't wort my time. Maybe later.
        /* $sql = sprintf( */
        /*     'INSERT INTO Progression (%s) VALUES ("%s")', */
        /*     implode(',',array_keys($prg)), */
        /*        // prevent SQL injection with imploding "" */
        /*     implode('","',array_values($prg)) */
        /* ); */
        /* $db->exec($sql); */

        // PDO Way
        $stmnt = $db->prepare('INSERT INTO Progression (id, type, name, position,
                               description, goal, media) VALUES (?,?,?,?,?,?,?)');
        $stmnt->execute(array_values($prg));
    }

    $sql = <<<SQL
            INSERT INTO User (id, username, password, email) 
            VALUES (1, "makiator", "123", "makivuk@g.com");
SQL;
    $db->exec($sql);

    $stmt = $db->query("SELECT * FROM Progression");
     
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<br>";
        echo $row['id'].' '.$row['position'].' '.$row['name'].' '; //etc...
    }
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

?>
