# Google Cloud PHP Development Scripts

Google Cloud PHP includes a Symfony Console application in `dev/google-cloud`
to automate certain development and maintenance tasks. The console app can be
easily invoked by running `composer google-cloud` at the command line.

## Commands

* `composer google-cloud release <major|minor|patch|version-number>` Create a new release of Google Cloud PHP.
* `composer google-cloud docfx` Generate and upload Google Cloud PHP documentation in DocFX format (PHP 8.0 only).

