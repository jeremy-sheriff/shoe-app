What is a PHP debugger?

A PHP debugger lets you pause (break) your code while it’s running, inspect variables, step through lines, set
breakpoints and watches, and view the call stack. This makes it far easier to understand program flow and find bugs than
using echo/var_dump logging. The de‑facto standard PHP debugger is Xdebug.

How this project is typically run

This repository appears to be run on your host machine (e.g., Laravel Herd on macOS) with only MySQL in Docker (see
docker-compose.yml). That means the easiest path is to enable Xdebug in your host PHP (Herd) and use your editor (VS
Code or PhpStorm) to listen for connections.

Option A: Enable Xdebug with Laravel Herd (macOS)

1) Turn on Xdebug in Herd
    - Open the Herd app → PHP tab → Enable Xdebug for the PHP version you’re using for this project.
    - Herd manages the correct Xdebug installation for you.

2) Recommended Xdebug 3 settings (Herd usually sets reasonable defaults)
   If you want to customize, add these to your user php.ini or Herd’s overrides for the active PHP version:

   xdebug.mode=debug,develop
   xdebug.start_with_request=yes
   xdebug.client_host=127.0.0.1
   xdebug.client_port=9003

   Notes:
    - Xdebug 3 defaults to port 9003 (not 9000).
    - start_with_request=yes makes every request attempt to debug. You can also use trigger to only debug when a special
      cookie/GET param/header is present; see “Selective debugging” below.

3) Configure your editor to listen
    - VS Code: install “PHP Debug” extension (xdebug.php-debug by xdebug).
      This repo includes .vscode/launch.json with two configurations: “Listen for Xdebug” (web) and “Launch currently
      open script” (CLI/tests).
    - PhpStorm: Preferences → PHP → Debug → Check “Start listening for PHP Debug connections”. IDE key can be default.
      Map the project root to the local directory if prompted.

4) Set a breakpoint and test
    - In a controller, Livewire component, job, etc., set a breakpoint in the editor.
    - For web requests (artisan serve, Valet, Herd Nginx), open the page in your browser while your editor is listening.
    - For CLI (php artisan tinker, phpunit), your editor must be listening; Xdebug will connect when the script runs.

Option B: Using a custom PHP (non-Herd) on macOS/Linux

1) Install Xdebug for your PHP version
    - pecl install xdebug
    - Or use your OS package manager (brew, apt) to install the Xdebug module compatible with your PHP.

2) Enable and configure Xdebug in php.ini or conf.d/xdebug.ini
   Add something like:

   zend_extension="xdebug"
   xdebug.mode=debug,develop
   xdebug.start_with_request=trigger
   xdebug.client_host=127.0.0.1
   xdebug.client_port=9003

   Then restart your PHP-FPM or your web server if applicable. For CLI debugging (php, phpunit), no restart is needed;
   your next command invocation will use the new settings.

3) Configure your editor (VS Code/PhpStorm) as above and test.

Verifying Xdebug is active

- CLI: run php -v and look for an Xdebug line, or run php -i | grep -i xdebug.
- Web: create a quick route that calls phpinfo(); and open it in the browser, then search for Xdebug.

Selective debugging (recommended for performance)

If you don’t want every request to try to debug, use triggers:

- Set xdebug.start_with_request=trigger.
- Use one of these to activate debugging on demand:
    - Cookie: XDEBUG_SESSION=1
    - GET param: ?XDEBUG_SESSION_START=1
    - Header: X-Debug: 1 (with xdebug.trigger_value=1 if you want to customize)

VS Code quickstart

1) Install the “PHP Debug” extension (xdebug.php-debug).
2) Open this project folder in VS Code.
3) Ensure Xdebug is enabled (Herd or your PHP install).
4) Press F5 and choose “Listen for Xdebug”, or select “Launch currently open script” for CLI scripts.
5) Set breakpoints and reload the page / run your script.

PhpStorm quickstart

1) Preferences → Plugins → ensure PHP and PHP Docker plugins (optional) are enabled.
2) Preferences → PHP → Debug → Check “Start listening for PHP Debug connections”.
3) Set “Debugger port” to 9003 (Xdebug 3 default).
4) Set breakpoints and debug.

Remote host mapping hints

- On macOS/Windows with local PHP, xdebug.client_host=127.0.0.1 (or localhost) usually works.
- Inside Docker containers that need to connect out to your host IDE, use xdebug.client_host=host.docker.internal (works
  on Docker Desktop). In this repo, PHP does not run in Docker by default, so you likely don’t need this.

Common pitfalls

- Multiple PHP versions installed; ensure you enabled Xdebug for the one running your app.
- Port conflicts with old Xdebug 2 configs (9000). Use 9003 for Xdebug 3.
- Firewalls or VPNs can block the debug connection.
- Performance: Xdebug slows down PHP. Disable it in production and consider using trigger mode during development.

Repository additions in this change

- .vscode/launch.json: Provides a ready-to-use VS Code debug configuration for Xdebug.
- This docs/DEBUGGING.md: A quick guide for enabling and using Xdebug with Herd or custom PHP.
