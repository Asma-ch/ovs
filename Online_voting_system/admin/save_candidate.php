<?php
include('dbcon.php');
if (isset($_POST['save'])) {

    $rfirstname = $_POST['rfirstname'];
    $rlastname = $_POST['rlastname'];
    $rgender = $_POST['rgender'];
    $ryear = $_POST['ryear'];
    $rposition = $_POST['rposition'];
    $rmname = $_POST['rmname'];
    $party = $_POST['party'];
    $user_name = $_POST['user_name'];
    $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_name = addslashes($_FILES['image']['name']);
    $image_size = getimagesize($_FILES['image']['tmp_name']);

    // Check for duplicates
    $query = "SELECT * FROM candidate WHERE FirstName='$rfirstname' AND LastName='$rlastname' AND Position='$rposition'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Candidate already exists!'); window.location='candidate_list.php';</script>";
        exit;
    }

     //Check Overlapping Elections: Use SQL queries to check if an election for a given position already exists in the specified year or date range.

     $query = "SELECT * FROM candidate 
               WHERE Position = '$rposition' 
               AND Year = '$ryear'";
     $result = mysqli_query($conn, $query);
     if (mysqli_num_rows($result) > 0) {
         echo "<script>alert('An election for this position and date already exists!'); window.location='candidate_list.php';</script>";
         exit;
     }

    $location = "";
    if ($image_name) {
        $location = "upload/" . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $location);
    }

    // Insert candidate based on position
    if ($rposition == "Governor") {
        mysqli_query($conn, "INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc)
            VALUES ('$rfirstname', '$rlastname', '$ryear', '$rposition', '$rgender', '$rmname', '$location', '$party', 'a')")
        or die(mysqli_error($conn));
    }

    if ($rposition == "Vice-Governor") {
        mysqli_query($conn, "INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc)
            VALUES ('$rfirstname', '$rlastname', '$ryear', '$rposition', '$rgender', '$rmname', '$location', '$party', 'b')")
        or die(mysqli_error($conn));
    }

    if ($rposition == "1st Year Representative") {
        mysqli_query($conn, "INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc)
            VALUES ('$rfirstname', '$rlastname', '$ryear', '$rposition', '$rgender', '$rmname', '$location', '$party', 'c')")
        or die(mysqli_error($conn));
    }

    if ($rposition == "2nd Year Representative") {
        mysqli_query($conn, "INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc)
            VALUES ('$rfirstname', '$rlastname', '$ryear', '$rposition', '$rgender', '$rmname', '$location', '$party', 'd')")
        or die(mysqli_error($conn));
    }

    if ($rposition == "3rd Year Representative") {
        mysqli_query($conn, "INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc)
            VALUES ('$rfirstname', '$rlastname', '$ryear', '$rposition', '$rgender', '$rmname', '$location', '$party', 'e')")
        or die(mysqli_error($conn));
    }

    if ($rposition == "4th Year Representative") {
        mysqli_query($conn, "INSERT INTO candidate (FirstName, LastName, Year, Position, Gender, MiddleName, Photo, Party, abc)
            VALUES ('$rfirstname', '$rlastname', '$ryear', '$rposition', '$rgender', '$rmname', '$location', '$party', 'f')")
        or die(mysqli_error($conn));
    }

    // Add to history
    mysqli_query($conn, "INSERT INTO history (data, action, date, user) 
        VALUES ('$rfirstname $rlastname', 'Added Candidate', NOW(), '$user_name')")
    or die(mysqli_error($conn));

    header('location:candidate_list.php');
}
?>
