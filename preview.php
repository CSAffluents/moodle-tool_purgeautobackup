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
 * Script to show informations about external automatic backups from deleted courses.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// This calls require_login and checks moodle/site:config.
admin_externalpage_setup('purgeautobackup', '', array(), tool_purgeautobackup_helper::get_url('preview'));
$title = get_string('preview', 'tool_purgeautobackup');
$PAGE->navbar->add($title);

$renderer = $PAGE->get_renderer('tool_purgeautobackup');

if (tool_purgeautobackup_backup::any_deletable()) {
    $backupsinfos = tool_purgeautobackup_backup::get_infos();
    echo $renderer->preview_page($backupsinfos);
} else {
    $message = $renderer->notification(get_string('nobackuptodelete', 'tool_purgeautobackup'), 'notifymessage');
    echo $renderer->simple_message_page($title, $message);
}
