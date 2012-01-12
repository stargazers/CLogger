<?php

/* 
CLogger - A class for logging using CLog class.
Copyright (C) 2012 Aleksi Räsänen <aleksi.rasanen@runosydan.net>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
 
	// ************************************************** 
	//  CLogger
	/*!
		@brief Class for logging. This class requires CLog
		  class for actual logging.
		@author Aleksi Räsänen
		@copyright Aleksi Räsänen, 2012
		@email aleksi.rasanen@runosydan.net
		@license GNU AGPL
	*/
	// ************************************************** 
	class CLogger
	{
		private $loggingClassInstance;

		// ************************************************** 
		//  __construct
		/*!
			@brief Initializes class variables
		*/
		// ************************************************** 
		public function __construct()
		{
			$this->loggingClassInstance = '';
		}

		// ************************************************** 
		//  setLoggingClassInstance
		/*!
			@brief Sets a logging class instance
			@param $log Logging class instance to use
		*/
		// ************************************************** 
		public function setLoggingClassInstance( $log )
		{
			$this->loggingClassInstance = $log;
		}

		// ************************************************** 
		//  getLoggingClassInstance
		/*!
			@brief Gets a logging class instance what we have used
			@return Logging class instance. If it is not set, 
			  we return -1.
		*/
		// ************************************************** 
		public function getLoggingClassInstance()
		{
			if( $this->loggingClassInstance == '' )
				return -1;

			return $this->loggingClassInstance;
		}

		// ************************************************** 
		//  logMsg
		/*!
			@brief Logs a message in a log if logging class is set.
			  If class is not set this does nothing.
			@param $msg Message
		*/
		// ************************************************** 
		public function logMsg( $msg )
		{
			if( $this->loggingClassInstance != '' )
				$this->loggingClassInstance->add( $msg );
		}
	}

?>
