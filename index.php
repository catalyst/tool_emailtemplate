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
 * Version
 *
 * @package    tool_emailtemplate
 * @author     Brendan Heywood <brendanheywood@catalyst-au.net>
 * @copyright  2022, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../config.php');

require_login();

$pluginname = get_string('pluginname', 'tool_emailtemplate');

$url = new moodle_url('/admin/tool/emailtemplate/index.php');
$context = context_system::instance();
$context = context_user::instance($USER->id);
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_url($url);
$PAGE->navigation->extend_for_user($USER);
$PAGE->navbar->add(get_string('profile'), new moodle_url('/user/profile.php', array('id' => $USER->id)));
$PAGE->navbar->add($pluginname);

// Check for caps.
require_capability('tool/emailtemplate:view', context_system::instance());
echo $OUTPUT->header();
echo $OUTPUT->heading($pluginname);

$config = get_config('tool_emailtemplate');
$template = $config->template;

$data = user_get_user_details($USER);

unset($data['preferences']);

// Set some convenient values:
$data['fullname'] = fullname($USER);
$data['countryname'] = get_string($data['country'], 'countries');
$data['site'] = [
    'logocompact' => $OUTPUT->get_compact_logo_url()->out(),
    'fullname'  => $SITE->fullname,
    'shortname' => $SITE->shortname,
    'wwwroot'   => $CFG->wwwroot,
];

$html = $OUTPUT->render_from_template('tool_emailtemplate/email', $data);

echo '<div class="shadow">';
echo $html;
echo '</div>';

echo html_writer::tag('textarea', $html, ['style' => 'width: 100%; height: 10em']);

echo '<pre>';
echo var_dump($data);
echo '</pre>';


echo $OUTPUT->footer();

