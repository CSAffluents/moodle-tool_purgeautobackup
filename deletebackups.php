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
 * Script to purge all external automatic backups from deleted courses.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// This calls require_login and checks moodle/site:config.
admin_externalpage_setup('purgeautobackup', '', array(), tool_purgeautobackup_helper::get_url('deletebackups'));
$title = get_string('deletebackups', 'tool_purgeautobackup');
$PAGE->navbar->add($title);

$renderer = $PAGE->get_renderer('tool_purgeautobackup');
$confirm = optional_param('confirmed', 0, PARAM_INT);

if (tool_purgeautobackup_backup::any_deletable()) {
    if (!$confirm) {
        echo $renderer->delete_confirmation();
    } else {
        $title = get_string('deletetionstatus', 'tool_purgeautobackup');
        $message = '';
        $errors = array();

        // We may need a bit of extra execution time and memory here.
        @set_time_limit(HOURSECS);
        raise_memory_limit(MEMORY_EXTRA);
        tool_purgeautobackup_backup::purge_all($errors);
        if (empty($errors)) {
            $message = $renderer->notification(get_string('deletetioncomplete', 'tool_purgeautobackup'), 'notifysuccess');
        } else {
            $message = $renderer->format_errors($errors);
            $message = $renderer->notification(get_string('deletetionfailed', 'tool_purgeautobackup') . $message, 'notifyproblem');
        }
        echo $renderer->simple_message_page($title, $message);
    }
} else {
    $message = $renderer->notification(get_string('nobackuptodelete', 'tool_purgeautobackup'), 'notifymessage');
    echo $renderer->simple_message_page($title, $message);
}
