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
		@brief Class for logging. This class requires 
		  CLog class for actual logging.
		@author Aleksi Räsänen
		@copyright Aleksi Räsänen, 2012
		@email aleksi.rasanen@runosydan.net
		@license GNU AGPL
	*/
	// ************************************************** 
	class CLogger
	{
		// Logging class instance
		private $log;

		// All function calls is stored here. We update this after
		// every In method... call and after every logReturn call.
		private $function_history;

		// Should we automatically add all param array values to log?
		private $log_array_values;


		// ************************************************** 
		//  __construct
		/*!
			@brief Initializes class variables
			@return Nothing
		*/
		// ************************************************** 
		public function __construct()
		{
			$this->log = '';
			$this->log_array_values = false;
		}

		// ************************************************** 
		//  setLoggingClassInstance
		/*!
			@brief Sets a logging class instance and calls a method
			  which set default message type regexpes.
			@param $log Logging class instance to use
			@return Nothing
		*/
		// ************************************************** 
		public function setLoggingClassInstance( $log )
		{
			$this->log = $log;
			$this->setDefaultMessageTypes();
		}

		// ************************************************** 
		//  setLogArrayValues
		/*!
			@brief Defines if we should log all array values when
			  we have got array as a function parameter when we use
			  logFunction method call
			@param $bool Boolean, true if we have to log all param values,
			  false if we want to log only 'param $xyz is an array.'
			@return Nothing
		*/
		// ************************************************** 
		public function setLogArrayValues( $bool )
		{
			$this->log_array_values = $bool;
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
			if( $this->log == '' )
				return -1;

			return $this->log;
		}

		// ************************************************** 
		//  logMsg
		/*!
			@brief Logs a message in a log if logging class is set.
			  If class is not set this does nothing.
			@param $msg Message
			@return Nothing
		*/
		// ************************************************** 
		public function logMsg( $msg )
		{
			if( $this->log != '' )
				$this->log->add( $msg );
		}

		// ************************************************** 
		//  logFunction
		/*!
			@brief Method which will simplify calling of
			  logMsg when we want to log 'In method:' messages
			  with its parameters
			@param $function_name Name of a caller function
			@param $paramters Parameters array
			@return Nothing
		*/
		// ************************************************** 
		public function logFunction( $function_name, $parameters )
		{
			if( $this->log == '' )
				return;

			$this->function_history[] = $function_name;
			$this->log->setFunctionWeLog( $function_name );
			$this->logMsg( 'In method: ' . $function_name );

			if(! is_array( $parameters ) )
				return;

			foreach( $parameters as $param_name => $param_value )
			{
				if( is_object( $param_value ) )
				{
					$this->logMsg( 'Param: $' . $param_name . ' is object.' );
					continue;
				}

				if(! is_array( $param_value ) )
				{
					$this->logMsg( 'Param: $' . $param_name 
						. ' is ' . $param_value );
					continue;
				}

				if(! $this->log_array_values )
				{
					$this->logMsg( 'Param: $' . $param_name . ' is an array.' );
					continue;
				}

				$this->logMsg( 'Param: $' . $param_name . ' is an array '
					. 'and it has next key/values: ' );

				foreach( $param_value as $key => $value )
					$this->logMsg( "\t" . $key . ' => ' . $value );
			}
		}

		// ************************************************** 
		//  writeLogToFile
		/*!
			@brief Writes a log to the file if logging class is set.
			  If class is not set, this does nothing.
			@param $filename Log filename to write
			@param $type Log file type, 'html' or 'text'
			@return Nothing
		*/
		// ************************************************** 
		public function writeLogToFile( $filename, $type )
		{
			if( $this->log != '' )
				$this->log->writeLogToFile( $filename, $type );
		}

		// ************************************************** 
		//  logReturn
		/*!
			@brief Returns back to the previous function.
			  This method should be called in the end of every function
			  so we can log current method correctly.
			@return Nothing 
		*/
		// ************************************************** 
		public function logReturn()
		{
			$num = count( $this->function_history ) -2;

			// Add previous method in function_history too!
			$this->function_history[] = $this->function_history[$num];
			$this->log->setFunctionWeLog( $this->function_history[$num] );
		}

		// ************************************************** 
		//  setDefaultMessageTypes
		/*!
			@brief Sets default message types which we normally
			  want to match. These are "In method:", "Param:",
			  "Error:", "Info:" and "Query:"
			@return Nothing
		*/
		// ************************************************** 
		private function setDefaultMessageTypes()
		{
			$this->log->setMessageType( 'in_method', '^In method:' );
			$this->log->setMessageType( 'param', '^Param:' );
			$this->log->setMessageType( 'error', '^Error:' );
			$this->log->setMessageType( 'info', '^Info:' );
			$this->log->setMessageType( 'query', '^Query:' );
		}
	}

?>
