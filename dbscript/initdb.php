<?php
/**
 * Create database, tables, parse sample data from ./progression.json and
 * ./exercise-session.json and populate tables
 * This script should not be in server *root* or anywhere where users can
 * run it!
 *
 * PHP version 5.6
 *
 * @package   Startbwtracker
 * @author    Marijan Svalina <marijan.svalina@gmail.com>
 * @copyright 2015 Marijan Svalina
 * @license   http://opensource.org/licenses/MIT MIT
 */


if (getenv("OPENSHIFT_MYSQL_DB_HOST") === false) {
    $host = "localhost";
    $username = "root";
    $password = "mantis5c";
    $database = "startbwtracker";
} else {
    $host = getenv("OPENSHIFT_MYSQL_DB_HOST");
    $username = getenv("OPENSHIFT_MYSQL_DB_USERNAME");
    $password = getenv("OPENSHIFT_MYSQL_DB_PASSWORD");
    $database = "startbwtracker";
}

try {
    $db = new PDO("mysql:host=$host;", $username, $password);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP DATABASE IF EXISTS $database; CREATE DATABASE $database;";
    // use exec() because no results are returned
    $db->exec($sql);
    echo "Database created successfully<br>";
    $db->exec("USE $database;");

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
    // use exec() because no results are returned
    $db->exec($sql);
    echo "Table User created successfully<br>";

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
          `custom` int(11) NULL DEFAULT NULL,
          `media` text,
          FOREIGN KEY (custom) REFERENCES User(id)
        );
SQL;
    $db->exec($sql);
    echo "Table Progression created successfully<br>";

    // sql to create ExerciseSession table
    $sql = <<<SQL
        DROP TABLE IF EXISTS `ExerciseSession`;
        CREATE TABLE `ExerciseSession` (
          `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `datetime` datetime NOT NULL,
          `goal` int(11) NOT NULL,
          `performed` int(11) NOT NULL,
          `repeat` tinyint(1) NOT NULL,
          `next` tinyint(1) NOT NULL,
          `notes` text NOT NULL,
          `usr_id` int(11) NOT NULL,
          `prg_id` int(11) NOT NULL,
          FOREIGN KEY(prg_id) REFERENCES Progression(id),
          FOREIGN KEY(usr_id) REFERENCES User(id)
        );
SQL;
    $db->exec($sql);
    echo "Table ExerciseSession created successfully<br>";

    echo "Inserting users into User table <br>";
    $sql = <<<SQL
            INSERT INTO User (id, username, password, email)
            VALUES (1, "makiator", "123", "m@n.com");
SQL;
    $db->exec($sql);


    $progressions = parseProgression();
    if (!$progressions == null) {
        echo "Inserting progressions into Progression table<br>";
        // PDO Way
        $stmnt = $db->prepare(
            'INSERT INTO `Progression` (`type`, `name`, `position`,
            `description`, `goal`, `custom`, `media`) VALUES
            (?,?,?,?,?,?,?)'
        );
        foreach ($progressions as $prg) {
            $stmnt->execute(array_values($prg));
        }
    }

    $exSessions = parseExerciseSession();
    if (!$exSessions == null) {
        echo "Inserting exercise sessions into ExerciseSession table<br>";
        // PDO Way
        $stmnt = $db->prepare(
            'INSERT INTO `ExerciseSession` (`datetime`, `prg_id`, `usr_id`,
            `goal`, `performed`, `repeat`, `next`, `notes`) VALUES
            (?,?,?,?,?,?,?,?)'
        );
        foreach ($exSessions as $exSes) {
            $stmnt->execute(array_values($exSes));
        }
    }

    $stmt = $db->query("SELECT * FROM `Progression`");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<br>";
        echo $row['id'].' '.$row['name'].' '; //etc...
    }

    $stmt = $db->query(
        "SELECT ExerciseSession.id, ExerciseSession.datetime,
        ExerciseSession.goal, ExerciseSession.performed, ExerciseSession.prg_id,
        Progression.name, ExerciseSession.notes FROM ExerciseSession INNER JOIN
        Progression ON ExerciseSession.prg_id=Progression.id;"
    );

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<br>";
        echo $row['id'].' '.$row['prg_id'].' '.$row['name'].' '.$row['notes'];
    }
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

/**
 * Parses ./progression.json return array of progressions
 *
 * @return progressions array|null
 * @author Marijan Svalina
 **/
function parseProgression()
{
    echo "Reading ./progression.json <br>";
    if (!file_exists("./progression.json")) {
        echo "./progression.json does not exists <br>";
        return;
    }
    $file = file_get_contents("./progression.json");
    $progressionsJson = json_decode($file, true);
    if ($progressionsJson == null) {
        echo "json_decode failed <br>";
        return;
    }

    $progressions = array();

    /**
     * Assumption: ./progression.json is an unorderd list of objects
     * (progression types) with an ordered list of objects in which there at
     * least these key/value pairs:
     *  "Squats": [
     *      {
     *          "name": "Deep Assisted Squats",
     *          "position": 105
     *      },
     */
    foreach ($progressionsJson as $prgTypeName => $prgTypeVal) {
        $type = $prgTypeName;
        foreach ($prgTypeVal as $prgPropertiesArray) {
            /* Setting description, goal, media to default values so they can be */
            /* left out in ./progression.json */
            $description = null;
            $goal = 888;
            $media = null;
            $custom = null;
            foreach ($prgPropertiesArray as $prgKey => $prgValue) {
                /* print "$prgKey => $prgValue\n"; */
                switch ($prgKey) {
                case 'type':
                    $type = $prgValue;
                    break;
                case 'name':
                    $name = "$prgValue";
                    break;
                case 'position':
                    $position = $prgValue;
                    break;
                case 'description':
                    $description = $prgValue;
                    break;
                case 'goal':
                    $goal = $prgValue;
                    break;
                case 'custom':
                    $custom = $prgValue;
                    break;
                case 'media':
                    $media = $prgValue;
                    break;
                default:
                    echo "IGNORING: $prgKey: $prgValue <br>";
                    break;
                }
            }
            $prg = array (
                "type" => $type,
                "name" => $name,
                "position" => $position,
                "description" => $description,
                "goal" => $goal,
                "custom" => $custom,
                "media" => $media
            );
            array_push($progressions, $prg);
        }
    }
    return $progressions;
}

/**
 * Parse ./exercise-session.json
 *
 * @return $exSessions array|null
 * @author Marijan Svalina
 **/
function parseExerciseSession()
{
    echo "Reading ./exercise-session.json <br>";
    if (!file_exists("./exercise-session.json")) {
        echo "./exercise-session.json does not exists <br>";
        return;
    }
    $file = file_get_contents("./exercise-session.json");
    $exSessionsJson = json_decode("$file", true);
    if ($exSessionsJson == null) {
        echo "json_decode failed <br>";
        return;
    }
    $exSessions = array();

    /**
     * Assumption: ./exercise-session.json is an unorderd list of objects
     * with these key/value pairs:
     *  {
     *      "datetime": "2015-04-20T18:45:42.222Z",
     *      "prg_id": 560,
     *      "usr_id": 1,
     *      "goal": 666,
     *      "performed": 666,
     *      "repeat": false,
     *      "next": false,
     *      "notes": "fancy note"
     *  },
     */
    foreach ($exSessionsJson as $exSession) {
        foreach ($exSession as $exSessionKey => $exSessionVal) {
            switch ($exSessionKey) {
            case 'datetime':
                $datetime = $exSessionVal;
                break;
            case 'prg_id':
                $prg_id = $exSessionVal;
                break;
            case 'usr_id':
                $usr_id = $exSessionVal;
                break;
            case 'goal':
                $goal = $exSessionVal;
                break;
            case 'performed':
                $performed = $exSessionVal;
                break;
            case 'repeat':
                $repeat = $exSessionVal;
                break;
            case 'next':
                $next = $exSessionVal;
                break;
            case 'notes':
                $notes = $exSessionVal;
                break;
            default:
                echo "IGNORING: $exSessionKey: $exSessionVal <br>";
                break;
            }
        }
        $exSes = array (
            "datetime" => $datetime,
            "prg_id" => $prg_id,
            "usr_id" => $usr_id,
            "goal" => $goal,
            "performed" => $performed,
            "repeat" => $repeat,
            "next" => $next,
            "notes" => $notes
        );
        array_push($exSessions, $exSes);
    }
    return $exSessions;
}
