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
 * File containing the helper class.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Class containing a set of helpers.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_purgeautobackup_helper {

    /**
     * Get the URL of a script within this plugin.
     * @param string $script the script name, without .php. E.g. 'index'
     * @param array $params URL parameters (optional)
     * @return moodle_url
     */
    public static function get_url($script, $params = array()) {
        return new moodle_url('/admin/tool/purgeautobackup/' . $script . '.php', $params);
    }
}
