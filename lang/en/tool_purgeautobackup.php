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
 * Strings for the external backups removal tool
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$string['backtoindex'] = 'Back to index';
$string['deletebackups'] = 'Delete backups';
$string['deletebackups_desc'] = 'Purge all external auto backups from deleted courses.';
$string['deletebackupsconfirmation'] = 'This will erase all external automatic backups from deleted course. Are you sure?';
$string['deletebackupsnow'] = 'Delete backups now';
$string['deletetioncomplete'] = 'Deletion completed';
$string['deletetionfailed'] = 'The deletion of the backups was not successful.';
$string['deletetionstatus'] = 'Deletion status';
$string['invalidbackupdir'] = 'The backup directory cannot be found or is unreadable.';
$string['nobackuptodelete'] = 'There are no backups that require to be deleted.';
$string['notdeletablebackup'] = 'The following backup cannot be deleted: {$a}';
$string['pluginname'] = 'External automatic backups removal';
$string['preview'] = 'Preview';
$string['preview_desc'] = 'Check if deleted course external auto backup need to be purged.';
$string['previewconfirmation'] = 'There are currently {$a->filecount} external automatic backups from courses that have been deleted for a total size of {$a->totalsize}.';
$string['tooldescription'] = 'This tool is used to remove all automated external backups from courses that have been removed since.';

