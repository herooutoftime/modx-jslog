JSLog Extra for MODx Revolution
=======================================

**PLEASE MIND: THIS IS STILL WORK IN PROGRESS**

This extra tracks JS (Java Script) errors and logs them server side and, if enabled, sends you an email if anything happens.
To prevent multiple emails of the same error there is a system setting `interval`, which will resend the error after this interval is met.
A simple log rotation based on the date (Y-m-d) is in place to prevent big blown up log files.

* JSLog stores client-side JS errors in server-side logs for better debugging on client errors.
* It's available for all contexts (in near future, right now it only tracks errors in `mgr` context)
** In `mgr` context the component uses `ExtJS` to perform AJAX-requests
** In all other contexts `XMLHttpRequest` will handle this

**Author:** Andreas Bilz <anti@herooutoftime.com> [Andreas Bilz](http://www.herooutoftime.com)
