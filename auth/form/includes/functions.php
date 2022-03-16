<?php

// Check for empty input signup
function emptyInput($lastname, $firstname, $ens1, $spec1, $q1, $ens2, $spec2, $q2) {
	$result;
	if (empty($lastname) || empty($firstname) || empty($ens1) || empty($spec1) || empty($q1) || empty($ens2) || empty($spec2) || empty($q2)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

// Insert new user into database
function createForm($conn, $lastname, $firstname, $ens1, $spec1, $q1, $ens2, $spec2, $q2) {
  $sql = "INSERT INTO form (form_last, form_first, form_ens1, form_spec1, form_q1, form_ens2, form_spec2, form_q2) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: ../index.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ssssssss", $lastname, $firstname, $ens1, $spec1, $q1, $ens2, $spec2, $q2);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	header("location: ../index.php?error=none");
	exit();
}

