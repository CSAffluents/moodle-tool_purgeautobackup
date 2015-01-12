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
 * Defines the renderer for the purge deleted course external auto backup helper plugin.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Renderer for the purge deleted course external auto backup helper plugin.
 *
 * @package    tool_purgeautobackup
 * @copyright  2015 Gilles-Philippe Leblanc <contact@gpleblanc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_purgeautobackup_renderer extends plugin_renderer_base {

    /**
     * Render the index page.
     *
     * @param string $detected information about what sort of site was detected.
     * @param array $actions list of actions to show on this page.
     * @return string html to output.
     */
    public function index_page($detected, array $actions) {
        $output = '';
        $output .= $this->header();
        $output .= $this->heading(get_string('pluginname', 'tool_purgeautobackup'));
        $output .= $this->box($detected);
        $output .= html_writer::start_tag('ul');
        foreach ($actions as $action) {
            $output .= html_writer::tag('li',
                    html_writer::link($action->url, $action->name) . ' - ' .
                    $action->description);
        }
        $output .= html_writer::end_tag('ul');
        $output .= $this->footer();
        return $output;
    }

    /**
     * Render a page that is just a simple message.
     *
     * @param string $title The title of this page.
     * @param string $message The message to display.
     * @return string html to output.
     */
    public function simple_message_page($title, $message) {
        $output = '';
        $output .= $this->header();
        $output .= $this->heading($title);
        $output .= $message;
        $output .= $this->back_to_index();
        $output .= $this->footer();
        return $output;
    }

    /**
     * Render the preview page to display infos about the backups.
     *
     * @param array $backupsinfos A list containing informations about the backups.
     * @return string html to output.
     */
    public function preview_page($backupsinfos) {
        $output = '';
        $output .= $this->header();
        $output .= $this->heading(get_string('preview', 'tool_purgeautobackup'));

        list($filecount, $totalsize) = $backupsinfos;
        $params = new stdClass();
        $params->filecount = $filecount;
        $params->totalsize = display_size($totalsize);
        $output .= $this->confirm(get_string('previewconfirmation', 'tool_purgeautobackup', $params),
                new single_button(tool_purgeautobackup_helper::get_url('deletebackups'),
                        get_string('deletebackups', 'tool_purgeautobackup')), tool_purgeautobackup_helper::get_url('index'));

        $output .= $this->footer();
        return $output;
    }

    /**
     * Render the delete confirmation page to display infos about the backups and to confirm the deletion.
     *
     * @return string html to output.
     */
    public function delete_confirmation() {
        $output = '';
        $output .= $this->header();
        $output .= $this->heading(get_string('deletebackups', 'tool_purgeautobackup'));

        $params = array('confirmed' => 1, 'sesskey' => sesskey());
        $output .= $this->confirm(get_string('deletebackupsconfirmation', 'tool_purgeautobackup'),
                new single_button(tool_purgeautobackup_helper::get_url('deletebackups', $params),
                        get_string('deletebackupsnow', 'tool_purgeautobackup')), tool_purgeautobackup_helper::get_url('index'));

        $output .= $this->footer();
        return $output;
    }

    /**
     * Render a link in a div, such as the 'Back to plugin main page' link.
     *
     * @param string|moodle_url $url the link URL.
     * @param string $text the link text.
     * @return string html to output.
     */
    public function end_of_page_link($url, $text) {
        return html_writer::tag('div', html_writer::link($url, $text), array('class' => 'mdl-align'));
    }

    /**
     * Output a link back to the plugin index page.
     *
     * @return string html to output.
     */
    public function back_to_index() {
        return $this->end_of_page_link(tool_purgeautobackup_helper::get_url('index'),
                get_string('backtoindex', 'tool_purgeautobackup'));
    }

    /**
     * Format a list of errors.
     *
     * @param array $errors A list of errors.
     * @return string html to output.
     */
    public function format_errors($errors) {
        $output = '';
        if (!empty($errors)) {
            $output .= html_writer::alist($errors);
        }
        return $output;
    }
}
