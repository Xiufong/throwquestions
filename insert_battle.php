<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * The main throwquestions configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package mod_throwquestions
 * @copyright 2015 Xiu-Fong Lin <xlin@alumnos.uai.cl>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *         
 *         
 */
require_once ('../../config.php');
require_once ($CFG->dirroot . "/mod/throwquestions/locallib.php");
require_once ($CFG->dirroot . "/lib/questionlib.php");

global $PAGE, $CFG, $OUTPUT, $DB;

// Required parameters in that where passed via url
$cmid = required_param ( 'id', PARAM_INT );
$questionid = required_param ( 'qid', PARAM_INT );
$sender = required_param ( 'sender', PARAM_INT );
$oponent = required_param ( 'oponent', PARAM_INT );
$status = required_param ( 'status', PARAM_INT );

// Insert fields that are going to be added to the database.
$insert = array (
		'question' => $questionid,
		'sender_id' => $sender,
		'receiver_id' => $oponent,
		'status' => $status,
		'cm_id' => $cmid 
);
// URL where the redirection is going to be targeted.
$url = new moodle_url ( '/mod/throwquestions/view.php', array (
		'id' => $cmid 
) );
$newbattle = $DB->insert_record ( 'battle', $insert );

// Validates if the insertion was executed correctly, if it wasn't it will display a message.
if (! $newbattle) {
	$validation = get_string ( 'battlecouldnotbecomplete', 'mod_throwquestions' );
	redirect ( $url, $validation, 5 );
} else {
	$validation = get_string ( 'youhavesentabattle', 'mod_throwquestions' );
	redirect ( $url, $validation, 5 );
}