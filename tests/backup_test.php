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
 * File containing tests for the course class.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * Backup test case.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or late
 */
class tool_purgeautobackup_backup_testcase extends advanced_testcase {

    /**
     * Correct backup filename 1.
     */
    const CORRECT_BACKUP_1 = "backup-moodle2-course-1-20150104-1234.mbz";

    /**
     * Correct backup filename 2.
     */
    const CORRECT_BACKUP_2 = "sauvegarde-moodle2-course-9999-20150104-4321.mbz";

    /**
     * Incorrect backup filename.
     */
    const INCORRECT_BACKUP = "notabackupfile";

    public function test_has_valid_name() {
        $this->assertTrue(tool_purgeautobackup_backup::has_valid_name(self::CORRECT_BACKUP_1));
        $this->assertTrue(tool_purgeautobackup_backup::has_valid_name(self::CORRECT_BACKUP_2));
        $this->assertFalse(tool_purgeautobackup_backup::has_valid_name(self::INCORRECT_BACKUP));
    }

    public function test_get_courseid_from_name() {
        $this->assertEquals(1, tool_purgeautobackup_backup::get_courseid_from_name(self::CORRECT_BACKUP_1));
        $this->assertEquals(9999, tool_purgeautobackup_backup::get_courseid_from_name(self::CORRECT_BACKUP_2));
        $this->assertEquals(0, tool_purgeautobackup_backup::get_courseid_from_name(self::INCORRECT_BACKUP));
    }
}
