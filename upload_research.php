<?php
include 'database.php';

$message = "";

if(isset($_POST['submit_upload'])){
    // Capture and sanitize the updated form parameters
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $abstract = mysqli_real_escape_string($conn, $_POST['abstract']);
    $author   = mysqli_real_escape_string($conn, $_POST['author']);
    
    // NEW & UPDATED FIELDS
    $category       = mysqli_real_escape_string($conn, $_POST['research_category']);
    $type           = mysqli_real_escape_string($conn, $_POST['research_type']);
    $grade_level    = mysqli_real_escape_string($conn, $_POST['grade_level']);
    $strand         = mysqli_real_escape_string($conn, $_POST['strand']);
    $year_completed = intval($_POST['year_completed']);

    // File Upload handling (Updated to match name="research_file" from your modal)
    $file_name = $_FILES['research_file']['name'];
    $file_tmp  = $_FILES['research_file']['tmp_name'];

    // Move file destination directory check
    if(move_uploaded_file($file_tmp, "uploads/" . $file_name)){
        
        // RE-ENGINEERED SQL QUERY
        $query = "INSERT INTO research_articles 
                  (title, abstract, author, research_category, research_type, grade_level, strand, year_completed, file) 
                  VALUES 
                  ('$title', '$abstract', '$author', '$category', '$type', '$grade_level', '$strand', '$year_completed', '$file_name')";
        
        if(mysqli_query($conn, $query)){
            // Redirect back to research file with pending status alert query indicator
            header("Location: research.php?status=pending");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Database Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Failed to upload file. Check folder permissions.</div>";
    }
}
?>