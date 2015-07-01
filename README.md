Moodle tool - Purge external auto backups
===================

Information
-----------

This tool purge all the external auto backup files from deleted courses.

It was created by Gilles-Philippe Leblanc, developer at Université de Montréal.

To install it using git, type this command in the root of your Moodle install:
```
git clone https://github.com/leblangi/moodle-tool_purgeautobackup.git admin/tool
```
Then add /admin/tool/purgeautobackup to your git ignore.

Alternatively, download the zip from
<https://github.com/leblangi/moodle-tool_purgeautobackup/archive/master.zip>,
unzip it into the admin/tool folder, and then rename the new folder to "purgeautobackup".

After you have installed this admin/tool plugin, you
should see a new option in the settings block:

> Site administration -> Courses -> Backups -> External automatic backups removal

I hope you find this tool useful. Please feel free to enhance it.
Report any idea or bug @
<https://github.com/leblangi/moodle-tool_purgeautobackup/issues>, thanks!
