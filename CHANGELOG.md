# Change Log

## [2.4.0](https://github.com/php-slack/slack/releases/tag/2.4.0)
 - Fix PhpUnit tests warning.
 - Add PhpUnit tests GitHub Action.
 - Fix tests: Exclude abstract `TestCase` class in `phpunit.xml.dist`.
 - Fix tests: new `<source>` section for PHPUnit 10+ (PHP 8.1+).
 - Fix tests: Separate config for PhpUnit 10+.
 - Fix tests: Support `DataProvider` as PHP attribute for PhpUnit 12+.
 - CI: Add tests launch on PHP `8.5`.
 - CI: Tests: Add full matrix of PHP & Guzzle to execute tests on.
 - CI: Tests: no audit while install dependencies.
 - CI: Tests: fix no audit while install dependencies.
 - CI: Tests: empty line to rerun jobs after GitHub Actions outage.
 - CI: Tests: add Guzzle `^8.0` to matrix.
 - CI: remove Travis integration (we migrated to GH Actions).
 - Add Guzzle `^8.0` support. Closes #88. Replaces #89.

## [2026.06](https://github.com/php-slack/slack/releases/tag/2026.06)
 - add alek13/slack as a replacement for maknz/slack in composer.json

## [2.3.0](https://github.com/php-slack/slack/releases/tag/2.3.0)
 - Support PHP 8.1, 8.2, 8.3, 8.4
   - Arguments with a null default must be nullable
   - Test PHP 8.1 through 8.4
   - Fix warnings for PHPUnit

## [2.2.1](https://github.com/php-slack/slack/releases/tag/2.2.1)
- Update `.gitattributes`: Added /.styleci.yml export-ignore
- Fix empty initial values in multi dynamic selects (fix #74)
- Add Scrutinizer config with multiple php versions

## [2.2.0](https://github.com/php-slack/slack/releases/tag/2.2.0)
- Fix invitation link. Ralates to php-slack/slack#67
- Change fieldClass property to trait abstract
- Fix minor Scrutinizer issue with legacy Client injection to Message
- autoload-dev for tests directory to keep it out of production autoloader
- Set Content-Type header to application/json (#71). Closes #70
- Apply fixes from StyleCI (#73). Relates to #71, #70
- New Block Types (#75)
- Commit styleci yml (#77)

## [2.1.1](https://github.com/php-slack/slack/releases/tag/2.1.1)
- Add .gitattributes (#66)

## [2.1.0](https://github.com/php-slack/slack/releases/tag/2.1.0)
- Add "header" as a valid block type (#65)

## [2.0.2](https://github.com/php-slack/slack/releases/tag/2.0.2)
 - Fix to PSR-4
 - Update README.md compatible with guzzle 7.0

## [2.0.1](https://github.com/php-slack/slack/releases/tag/2.0.1)
 - Add tests for all BlockElement factory types
 - Fix BlockElement factory spec for Checkboxes (Fixes #60)

## [2.0.0](https://github.com/php-slack/slack/releases/tag/2.0.0)
 - ignore phpunit.xml & rename to phpunit.xml.dist fix #16
 - exclude 'tests' & 'vendor' from calc code coverage. closes #18
 - code style rules; add .editorconfig
 - migrate to phpunit 6.5. closes #7. & Update PhpUnit to 7.5. Closes #27
 - migrate to mockery 1.0. closes #19
 - drop support for php 5, 7.0 & hhvm (fixes builds)
 - php docblocks for tests. closes #8
 - decrease Attachment::__contruct() complexity. closes #9
 - rename attributes to options
 - decrease Client::__construct() complexity. closes #12
 - Added response_type to allow for 'in_channel' vs 'emphemeral' messages in channel
 - Blocks support (Integrate Blocks with main `Message/Client`) by @cmbuckley:
    - Button element and Confirmation object
    - Checkboxes element and Option object
    - DatePicker element
    - Image element
    - Overflow element
    - TextInput element
    - RadioButtons element
    - Select element and OptionGroup object
    - MultiSelect element
    - Actions block
    - Context block
    - Divider block
    - File block
    - Image block
    - Input block
 - Fix php doc-blocks. Closes #39.
 - correct initial option check (fixes #40)
 - add travis notification to Slack. Closes #17.
 - fix class name. fix #45
 - Improve test coverage for Block kit
 - Added callback_id to Attachment.php (#50) to allow for working with the interactivity callback api in slack
 - bugfix: prevent call on non-object
 - Update Composer and PHPUnit to PHP 8.0 (#56)
 - reuse `Payload` for `fillProperties()` (decrease complexity). resolves #13
 - decouple `Message` from `Client`. Closes #15, fixes maknz/slack#70

## [1.12.0](https://github.com/php-slack/slack/releases/tag/1.12.0)
 - add guzzle 7 support (by @esetnik)

## [1.11.0](https://github.com/alek13/slack/compare/1.10.1...1.11.0)
 - fix `AttachmentAction::__toArray`: no default confirmation popup if no `confirm` specified (fixes #41)
 - remove `5.5` & `hhvm` support, add `7.3` & `7.4` support; also remove builds for `nightly`
 - change travis & scrutinizer badge urls in readme
 - add `ext-json` dependency to `composer.json`
 - add Playground info in readme

## [1.10.1](https://github.com/alek13/slack/compare/1.10.0...1.10.1)
 - mark `Message::send` deprecated for #15
 - mark Laravel Provider as deprecated with link to new [separate package](https://github.com/alek13/slack-laravel)
 - add `Questions` section in readme
 - add `Quick Tour` section in readme

## [1.10.0](https://github.com/alek13/slack/compare/1.9.1...1.10.0)
 - Support of `url` field in `AttachmentAction` (by @rasmusdencker)

## [1.9.1](https://github.com/alek13/slack/compare/1.9.0...1.9.1)
 - improve & fix doc-block: right types + @throws added
 - fix Attachment::setIcon() return value

## [1.9.0](https://github.com/alek13/slack/compare/1.8.1...1.9.0)
 - Added optional footer attachments. Closes maknz/slack#87, closes #2 George* 6/15/16 12:08 AM
 - Php doc-blocks fixes. (Mesut Vatansever* 10/20/16 12:06 PM, Michal Vyšinský* 10/19/16 10:58 AM, Freek Van der Herten* 7/18/16 10:51 PM)

## [1.8.1](https://github.com/alek13/slack/compare/1.8.0...1.8.1)

 - Fix bug where message wouldn't get returned on send, closes maknz/slack#47 maknz* 6/26/16 8:06 AM
 - integrated Gemnasium; add dependency status badge Alexander Chibrikin 1/9/18 3:38 AM
 - integrated Scrutinizer-CI; change badge Alexander Chibrikin 1/9/18 3:36 AM
 - add slack welcome badge for community slack workspace Alexander Chibrikin 1/8/18 11:55 PM

## [1.8.0](https://github.com/alek13/slack/compare/1.7.0...1.8.0)
 - speed up builds: store composer cache Alexander Chibrikin 1/8/18 4:11 AM
 - add extra branch-alias for packagist Alexander Chibrikin 1/8/18 3:52 AM
 - bugfix: fail on build AttachmentAction without confirm (fixes #1, fixes maknz/slack#61) Alexander Chibrikin 1/7/18 5:33 PM
 - fix travis build; add builds for php 7.1, 7.2, nightly Alexander Chibrikin 1/6/18 8:48 PM
 - rename & publish new package on Packagist.org
 - add CHANGELOG.md Alexander Chibrikin 1/8/18 1:39 AM
 - Better Travis version testing maknz 6/25/16 5:43 AM
 - Drop PHP 5.4, throw an exception if JSON encoding fails maknz 5/28/16 8:29 AM
 - fixed code style Ion Bazan 6/22/16 12:04 PM
 - added Attachment Actions (buttons) with confirmations Ion Bazan 6/22/16 11:56 AM
 - StyleCI config, add badge to README maknz 5/28/16 7:36 AM
 - Code style fixes to abide by StyleCI laravel preset maknz 5/28/16 7:29 AM
 - Suggest nexylan/slack-bundle for Symfony support Regan McEntyre 3/8/16 10:45 PM
 - Update README with NexySlackBundle Regan McEntyre 3/8/16 10:41 PM
 - Fixed documentation color values Quentin McRee 1/20/16 4:37 AM
 - Removes unused Guzzle class reference from service provider Raj Abishek 12/21/15 8:01 AM
 - Fix Laravel 5 config publish instructions Regan McEntyre 6/15/15 10:59 AM
 - Add Scrutinizer badge Regan McEntyre 6/4/15 12:24 PM
