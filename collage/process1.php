<?php
session_start();
$servername="localhost";
$username="root";
$password="";
$dbname="collage";

$conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die ("connection failed:" .$conn->connect_error);
}

function getAllcollages($conn){
    $sql = "SELECT CollegeCode,CourseCode FROM mst college GROUP BY CollegeCode,CourseName";
    $result = $conn->query($sql);
    $row=[];
    if($result->num_rows > 0){
        $row = $result->fetch_all();
    }
    return $row;
}
function getAllGroup($conn,$collagecode){
    try {
    $sql = "SELECT mstcollagecourse* FROM `mstcourse`
    LEFT JOIN mstcollege ON mstcollege.collagecode = mstcourse.courseCode
    where collagecode = '$collagecode'";
    
    $result = $conn->query($sql);
    $row=[];
    if($result->num_rows > 0){
        $row = $result->fetch_all();
    }
}
}   
    
