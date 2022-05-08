<?php
echo date(DATE_RFC822).'<br/>';

$ini = parse_ini_file("db.ini", true /* will scope sectionally */);
$servername=$ini['DB']['host'];
$username='';
$password='';
$db_name='';

// Connect to MySQL
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die('Connection failed: '.$conn->connect_error);
}

//include './db_conn.php';
drop_database($conn, $db_name);
create_database($conn, $db_name);
create_columns($conn);


while($conn->more_results()){
    $conn->next_result();
    $conn->use_result();
}

create_tables($conn);

$conn->close();


// functions
function drop_database($conn, $db_name) {
    echo 'Droping database '.$db_name.'...<br/>';
    if ($conn->query('DROP DATABASE IF EXISTS '.$db_name) === TRUE) {
        echo 'Database has been drop successfully<br/>';
    } else {
        die('Error droping database: '.$conn->error);
    }
}

function create_database($conn, $db_name) {
    if (mysqli_select_db($conn, $db_name)){
        return;
    }
    echo 'Creating database '.$db_name.'...<br/>';
    if ($conn->query('CREATE DATABASE '.$db_name) === TRUE) {
        echo 'Database has been created successfully<br/>';
        if ($conn->query('use '.$db_name) === TRUE) {
            echo 'Using '.$db_name.'...<br/>';
        } else {
            die('Unable to use database '.$db_name);
        }
    } else {
        die('Error creating database: '.$conn->error);
    }
}

function create_columns($conn) {
    echo 'Creating columns table...<br/>';
    if ($conn->multi_query(file_get_contents("columns.sql")) === TRUE) {
        echo 'Columns table has been created successfully<br/>';
    } else {
        die('Error creating columns table: '.$conn->error);
    }
}

function create_tables($conn) {
    echo 'Creating tables table...<br/>';
    if ($conn->multi_query(file_get_contents("tables.sql")) === TRUE) {
        echo 'Tables table has been created successfully<br/>';
    } else {
        die('Error creating tables table: '.$conn->error);
    }
}


?>