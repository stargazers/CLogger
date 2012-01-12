<?php

	require '../CLog/CLog.php';
	require 'CLogger.php';

	// Actual logging class
	$log = new CLog;

	// Class what we use as a higher level class
	$lc = new CLogger;

	// A test what will NOT be logged but it won't crash or
	// make any errors etc. because logging class is not set yet.
	$lc->logMsg( 'This is a line what will never be seen in a log.' );

	// Set log class to use 
	$lc->setLoggingClassInstance( $log );

	// Create couple of sample lines in log
	$lc->logMsg( 'Hi! This is a first row in log!' );
	$lc->logMsg( 'And this is the second one.' );

	// Note that we use istance of CLog when we want to get log messages!
	echo $log->getLog( 'html' );

?>
