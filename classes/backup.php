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
 * Purge deleted course external auto backup tool library functions
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/backup/util/interfaces/checksumable.class.php');
require_once($CFG->dirroot . '/backup/backup.class.php');


/**
 * Helper class to handle automatic external backups manipulations.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_purgeautobackup_backup {

    /**
     * Determine if there are any backups that can be deleted.
     *
     * @return boolean $deletable Are there any backups that can be deleted
     */
    public static function any_deletable() {
        return !empty(self::get_all_deletable_backups());
    }

    /**
     * Get a list of all backups that can be deleted.
     * The result is cached for faster execution.
     * 
     * @return array $backups A list of all backups that can be deleted.
     */
    public static function get_all_deletable_backups() {
        global $DB;
        $cache = cache::make('tool_purgeautobackup', 'backup');
        if (($backups = $cache->get('backups')) === false) {
            $dir = self::get_backup_dir();
            $backups = array();
            $oldcourseid = 0;
            if (!empty($dir)) {
                foreach (scandir($dir) as $file) {
                    // Skip files not matching the naming convention.
                    $courseid = self::get_courseid_from_name($file);
                    if (empty($courseid)) {
                        continue;
                    }
                    // If the course do not exist in the database, add the backup to the list.
                    if ($oldcourseid == $courseid || !$DB->record_exists('course', array('id' => $courseid))) {
                        $backups[] = $file;
                        $oldcourseid = $courseid;
                    }
                }
            }
            $cache->set('backups', $backups);
        }
        return $backups;
    }

    /**
     * Get the backup directory from the backup configuration.
     *
     * @return The backup directory or null if an error occur with this directory.
     */
    private static function get_backup_dir() {
        $config = get_config('backup');
        $dir = $config->backup_auto_destination;
        if (!file_exists($dir) || !is_dir($dir) || !is_writable($dir)) {
            $dir = null;
        }
        return $dir;
    }

    /**
     * Purge all external automatic backups from deleted courses.
     * @param array $errors will be populated with errors found.
     */
    public static function purge_all(&$errors = array()) {
        $dir = self::get_backup_dir();
        if (!empty($dir)) {
            $backups = self::get_all_deletable_backups();
            foreach ($backups as $file) {
                $filename = $dir . "/" . $file;
                if (is_writable($filename)) {
                    unlink($filename);
                } else {
                    $errors[] = get_string('notdeletablebackup', 'tool_purgeautobackup', $file);
                }
            }
            cache_helper::purge_by_event('externalbackupsdeleted');
            return;
        }
        $errors[] = get_string('invalidbackupdir', 'tool_purgeautobackup');
    }

    /**
     * Get informations external automatic backups from deleted courses.
     * like the number of backups and their total filesize.
     */
    public static function get_infos() {
        $cache = cache::make('tool_purgeautobackup', 'backup');
        if (($backupsinfos = $cache->get('backupsinfos')) === false) {
            $dir = self::get_backup_dir();
            $backups = self::get_all_deletable_backups();
            $filecount = 0;
            $totalsize = 0;
            if (!empty($dir)) {
                foreach ($backups as $file) {
                    $filename = $dir . "/" . $file;
                    if (file_exists($filename)) {
                        $totalsize += filesize($filename);
                        $filecount++;
                    }
                }
            }
            $backupsinfos = array($filecount, $totalsize);
            $cache->set('backupsinfos', $backupsinfos);
        }
        return $backupsinfos;
    }

    /**
     * Check if the filename is a valid backup name.
     *
     * @param string $filename The filename of the backup.
     * @return boolean if the filename is a valid backup name.
     */
    public static function has_valid_name($filename) {
        $sep = '-';
        $format = $sep . backup::FORMAT_MOODLE . $sep . backup::TYPE_1COURSE . $sep;
        $regex = '#^\w+'.preg_quote($format, '#').'[1-9][0-9]*\-.*\.mbz$#';
        return (boolean) preg_match($regex, $filename);
    }

    /**
     * Get the id of a course based on the filename of is backup.
     *
     * @param string $filename The filename of the backup.
     * @return int $id The id of the course, 0 if the format is invalid.
     */
    public static function get_courseid_from_name($filename) {
        $parts = explode("-", $filename);
        $id = 0;
        if (self::has_valid_name($filename)) {
            $id = (int) $parts[3];
        }
        return $id;
    }


}
