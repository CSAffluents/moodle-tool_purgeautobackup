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

/**
 * Class to encapsulate one of the functionalities that this plugin offers.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_purgeautobackup_action {
    /** @var string the name of this action. */
    public $name;
    /** @var moodle_url the URL to launch this action. */
    public $url;
    /** @var string a description of this action. */
    public $description;

    /**
     * Constructor to set the fields.
     *
     * In order to create a new tool_purgeautobackup_action instance you must use
     * the tool_purgeautobackup_action::make
     * method.
     *
     * @param string $name the name of this action.
     * @param moodle_url $url the URL to launch this action.
     * @param string $description a description of this action.
     */
    protected function __construct($name, moodle_url $url, $description) {
        $this->name = $name;
        $this->url = $url;
        $this->description = $description;
    }

    /**
     * Make an action with standard values.
     * @param string $shortname internal name of the action. Used to get strings and build a URL.
     * @param array $params any URL params required.
     * @return tool_purgeautobackup_action
     */
    public static function make($shortname, $params = array()) {
        return new self(
                get_string($shortname, 'tool_purgeautobackup'),
                tool_purgeautobackup_helper::get_url($shortname, $params),
                get_string($shortname . '_desc', 'tool_purgeautobackup'));
    }
}
