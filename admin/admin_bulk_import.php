<?php
include '../database.php';

$message = "";
$messageClass = "";
$error_logs = [];

if (isset($_POST['import_csv'])) {
    // Verify a file was actually provided
    if (!empty($_FILES['csv_file']['name'])) {
        $filename = $_FILES['csv_file']['tmp_name'];
        $file = fopen($filename, "r");
        
        // Skip the first title header line row of the template (UID, Name, Email, etc.)
        fgetcsv($file); 
        
        $inserted_count = 0;
        $skipped_count = 0;
        $row_index = 1; // Used to trace line positions during errors

        // Process document line-by-line
        while (($column = fgetcsv($file, 1000, ",")) !== FALSE) {
            $row_index++;
            
            // Clean inputs to shield database string evaluations
            $uid      = mysqli_real_escape_string($conn, trim($column[0]));
            $name     = mysqli_real_escape_string($conn, trim($column[1]));
            $email    = mysqli_real_escape_string($conn, trim($column[2]));
            $password = mysqli_real_escape_string($conn, trim($column[3]));
            $role     = strtolower(trim($column[4])); // standardizes to lowercase

            // Setup table specific configuration maps
            if ($role === 'student') {
                $target_table = 'portal_students';
                $uid_column   = 'student_uid';
            } elseif ($role === 'faculty') {
                $target_table = 'portal_faculty';
                $uid_column   = 'faculty_uid';
            } elseif ($role === 'non-teaching') {
                $target_table = 'portal_non_teaching';
                $uid_column   = 'staff_uid';
            } else {
                $error_logs[] = "Line {$row_index}: Unknown role framework classification value '{$role}' for user {$name}.";
                $skipped_count++;
                continue; // Breaks out of current loop position to process next row
            }

            // --- UPDATED DUP CHECK: Verify BOTH UID and Email uniqueness ---
            
            // 1. Check if UID already exists in the TARGET table
            $uid_check = mysqli_query($conn, "SELECT 1 FROM {$target_table} WHERE {$uid_column} = '{$uid}' LIMIT 1");
            
            // 2. Check if Email already exists anywhere within the TARGET table
            $email_check = mysqli_query($conn, "SELECT 1 FROM {$target_table} WHERE email = '{$email}' LIMIT 1");
            
            if (mysqli_num_rows($uid_check) > 0) {
                $error_logs[] = "Line {$row_index}: Skipped! UID '{$uid}' is already registered in '{$target_table}' for {$name}.";
                $skipped_count++;
                continue; // Skip this row and continue processing the spreadsheet
            }
            
            if (mysqli_num_rows($email_check) > 0) {
                $error_logs[] = "Line {$row_index}: Skipped! Email '{$email}' is already in use inside '{$target_table}' for another account.";
                $skipped_count++;
                continue; // Skip this row and continue processing the spreadsheet
            }

            // Perform execution row push (Line 61)
            $insert_query = "INSERT INTO {$target_table} ({$uid_column}, name, email, password) 
                             VALUES ('{$uid}', '{$name}', '$email', '$password')";
            
            if (mysqli_query($conn, $insert_query)) {
                $inserted_count++;
            } else {
                $error_logs[] = "Line {$row_index}: System execution error on row generation: " . mysqli_error($conn);
                $skipped_count++;
            }
        }
        
        fclose($file);
        
        $message = "Bulk Import Complete! Successfully created {$inserted_count} accounts. Skipped/Failed: {$skipped_count}.";
        $messageClass = $skipped_count > 0 ? "alert-warning" : "alert-success";
        
    } else {
        $message = "Please select a valid CSV template document first.";
        $messageClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bulk Account Import</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="../img/admin.png"/>
</head>
<body class="bg-light py-5">

<div class="container" style="max-width: 750px;">
    <?php if (!empty($message)): ?>
        <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-file-earmark-spreadsheet-fill text-success me-2"></i> Bulk User Account Import Center</h5>
        </div>
        <div class="card-body p-4 bg-white">
            
            <div class="alert alert-secondary mb-4 small py-2 px-3">
                <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Structured Template Format Guide:</h6>
                <p class="mb-2">Your CSV upload spreadsheet must contain exactly 5 column cells arranged in this precise row order:</p>
                <code class="d-block bg-dark text-light p-2 rounded mb-2">uid, name, email, password, role</code>
                <span class="text-muted text-xs">Supported Role string variations allowed: <strong>student</strong>, <strong>faculty</strong>, or <strong>non-teaching</strong>.</span>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Select Spreadsheet Source File (.csv format only)</label>
                    <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                </div>
                <div class="d-flex gap-2">
                    <a href="admin_user.php" class="btn btn-light px-3"><i class="bi bi-arrow-left"></i> Back to Users</a>
                    <button type="submit" name="import_csv" class="btn text-white px-4" style="background-color: #7e3af2;">
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Run Processing Cycle
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php if (!empty($error_logs)): ?>
        <div class="card border-0 shadow-sm rounded-3 bg-white">
            <div class="card-header bg-danger-subtle text-danger fw-bold py-2.5 small">
                <i class="bi bi-bug-fill me-1"></i> Account Processing Error/Skipped Row Trace Summary:
            </div>
            <div class="card-body p-3 font-monospace small" style="max-height: 250px; overflow-y: auto; background-color: #fdfafd;">
                <ul class="mb-0 text-danger ps-3">
                    <?php foreach ($error_logs as $log): ?>
                        <li class="mb-1"><?php echo htmlspecialchars($log); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>