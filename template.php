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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Modify the email template
 *
 * @package    tool_emailtemplate
 * @author     Benjamin Walker <benjaminwalker@catalyst-au.net>
 * @copyright  2024, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

// This is locked behind a separate capability so the task can be delegated to non-admins.
require_login();
$context = context_system::instance();
require_capability('tool/emailtemplate:manage', $context);

// Set up the page.
$url = new moodle_url('/admin/tool/emailtemplate/template.php');
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('emailtemplate:manage', 'tool_emailtemplate'));
$PAGE->set_heading($SITE->fullname);

// Create the form and load current config.
$mform = new \tool_emailtemplate\form\template();
$mform->load_form_config();

// Handle form submission.
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/admin/tool/emailtemplate/index.php'));
} else if ($data = $mform->get_data()) {
    $mform->save_form_config($data);
    redirect($url, get_string('changessaved'), null, \core\output\notification::NOTIFY_SUCCESS);
}

// Display the form.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('emailtemplate:manage', 'tool_emailtemplate'));
$mform->display();
echo $OUTPUT->footer();
