<?php
namespace Zhp\KujPom\Naorbitach;

function kopernik_mysqli(array $kopernik_config, bool $full_debug)
{
    if($full_debug){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    } else {
        mysqli_report(MYSQLI_REPORT_OFF);
    }
    
    $mysqli = new \mysqli(        
        $kopernik_config['mysqli_host'],
        $kopernik_config['mysqli_user'],
        $kopernik_config['mysqli_pw'],
        $kopernik_config['mysqli_db'],
        $kopernik_config['mysqli_port'],
        $kopernik_config['mysqli_socket']
    );
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}

function save_action(\mysqli $mysqli, array $data)
{
    $stmt = $mysqli->prepare("INSERT INTO activities (scoutunit, activity, participants, distance, image_name_new) " .
                                                "VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiis", $data['scoutunit'], $data['activity'], $data['participants'], $data['distance'], $data['image']);
    $stmt->execute();
    $stmt->close();
    if($mysqli->error)
    {
        return array( $mysqli->errno, $mysqli->error );
    }
    return false;
    //$result = mysqli_query($mysqli, "SELECT Name, CountryCode FROM City ORDER BY ID LIMIT 3");
} 


function read_total(\mysqli $mysqli)
{
    $query = "SELECT scoutunit, walking, running, cycling, swimming, updated_at, unitname" .
        " from totals";
    $mysqli->query($query);

    $json_result = '';
    if ($result = $mysqli->query($query)) {

        $totals = array();
        while($row = $result->fetch_assoc())
        {
            $totals[] = $row;
        }

        $json_result = json_encode(array('totals' => $totals));
    } else {
        $json_result = '{ "error": "'.$mysqli->errno.' '.$mysqli->error  .'"}';
    }
    $result->close();
    unset($obj);
    return $json_result;
}

