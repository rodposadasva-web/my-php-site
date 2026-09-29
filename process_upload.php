<?php
include 'database.php';

if (isset($_POST['submit_upload'])) {
    $title    = mysqli_real_escape_string($conn, $_POST['title']);
    $abstract = mysqli_real_escape_string($conn, $_POST['abstract']);
    $author   = mysqli_real_escape_string($conn, $_POST['author']);
    
    $grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
    $strand      = mysqli_real_escape_string($conn, $_POST['strand']);
    
    // UPDATED: Matched to the new input element names from the modal
    $research_category = mysqli_real_escape_string($conn, $_POST['research_category']);
    $research_type     = mysqli_real_escape_string($conn, $_POST['research_type']);
    $year_completed    = mysqli_real_escape_string($conn, $_POST['year_completed']);
    
    // File upload location mapping
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    
    $file_name   = time() . '_' . basename($_FILES["research_file"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type   = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Safety checkpoints
    if ($file_type != "pdf") {
        header("Location: research.php?error=invalid_type");
        exit();
    } elseif ($_FILES["research_file"]["size"] > 10 * 1024 * 1024) { // 10MB limit
        header("Location: research.php?error=file_too_large");
        exit();
    } else {
        if (move_uploaded_file($_FILES["research_file"]["tmp_name"], $target_file)) {
            
            // --- STEP 1: Insert updated column schema values into the queue ---
            $insert_query = "INSERT INTO research_submissions 
                            (title, author, abstract, grade_level, strand, research_category, research_type, year_completed, file_path, status) 
                            VALUES 
                            ('$title', '$author', '$abstract', '$grade_level', '$strand', '$research_category', '$research_type', '$year_completed', '$target_file', 'Pending')";
            
            if (mysqli_query($conn, $insert_query)) {
                header("Location: research.php?status=pending");
                exit();
            } else {
                header("Location: research.php?error=db_error");
                exit();
            }
        } else {
            header("Location: research.php?error=upload_failed");
            exit();
        }
    }
} else {
    header("Location: research.php");
    exit();
}
?>