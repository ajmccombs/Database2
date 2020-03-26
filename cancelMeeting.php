<?php

session_start();
define("BREAKLINE", "<br></br>");
$mysqli = mysqli_connect("localhost", "root", "", "db2");

//Query for meetings with <3 mentors
$less3_sql = "SELECT meet_id FROM enroll2 GROUP BY meet_id HAVING count(meet_id) < 3";
$less_result = $mysqli->query($less3_sql);
$less3ment = $less_result->fetch_assoc();

$date = date("l");

if ($date == "Friday") {

    //Cancel meetings in above query and sent notification

    echo "It's Friday! Cancelling meetings with less than 3 mentors!";
    echo BREAKLINE;

    //$cancelFile = 'Canceled Meetings ' . date(DATE_RFC850) . '.txt';
    $myfile = fopen('Canceled Meetings.txt', 'w+');

   // while($less3ment = $less_result->fetch_assoc()){

        $less3 = $less3ment["meet_id"];

        if($myfile){

            $sql = "SELECT name,email FROM users WHERE id IN
                ((SELECT mentee_id FROM enroll WHERE meet_id = $less3) UNION 
                (SELECT mentor_id FROM enroll2 WHERE meet_id = $less3))";

            $result = $mysqli->query($sql);
        

            while($list = $result->fetch_assoc()) {
              $txt = $list["name"] . "," . $list["email"] . "\n";
           
              fwrite($myfile, $txt);
            
            }
       // }
        fclose($myfile);
    }
}


?>

