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
 * Settings
 *
 * @package    tool_emailtemplate
 * @author     Brendan Heywood <brendanheywood@catalyst-au.net>
 * @copyright  2022, Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $category = new admin_category('tool_emailtemplate', get_string('pluginname', 'tool_emailtemplate'));
    $ADMIN->add('tools', $category);

    $settings = new admin_settingpage('tool_emailtemplate_settings', get_string('generalsettings', 'admin'));
    $ADMIN->add('tool_emailtemplate', $settings);

    $ADMIN->add('tool_emailtemplate', new admin_externalpage(
        'tool_emailtemplate_template',
        get_string('emailtemplate:manage', 'tool_emailtemplate'),
        new moodle_url('/admin/tool/emailtemplate/template.php'),
        'tool/emailtemplate:manage'
    ));

    $settings->add(new admin_setting_configcheckbox(
        'tool_emailtemplate/tracking',
        get_string('tracking', 'tool_emailtemplate'),
        get_string('trackingdesc', 'tool_emailtemplate'),
        0
    ));

    $settings = null;
}
