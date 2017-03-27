ActiveCampaign PHP Coding Standards
===================================

This repository provides a ruleset and custom sniffs for  [PHP\_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) to verify adherence to the ActiveCampaign [PHP Code Standards](https://activecampaign.atlassian.net/wiki/display/DEV/Code+Standards). Note that these standards apply primarily to legacy PHP code; newer microservices should adhere to the [PSR-2](http://www.php-fig.org/psr/psr-2/) standard.

## Install

Install using Composer. First, you will need to add this repository to the project's `composer.json`:

```
"repositories": [
	{
		"type": "vcs",
		"url": "https://github.com/rpalladino/php-coding-standards.git"
	}
]
```

Then you can install it as you would any Composer package:

```
$ composer require --dev activecampaign/php-coding-standards
```

If it is not already installed, `PHP_CodeSniffer` will be installed into the project for you.

## Configure

After installing you will need to configure your project to use the provided `ActiveCampaign` standard when running `phpcs` by creating a file called `phpcs.xml`. Here is an example with the minimum configuration you'll need to get going:

```
<?xml version="1.0"?>
<ruleset name="AC Coding Standards">
	<!-- Install the ActiveCampaign PHP coding standards. -->
	<config name="installed_paths" value="vendor/activecampaign/php-coding-standards"/>

	<!-- Use the ActiveCampaign ruleset. -->
	<rule ref="ActiveCampaign"/>

	<!-- Replace tabs by 4 spaces for sniffs that expect space indents. -->
	<arg name="tab-width" value="4"/>

	<!-- Use colors in output. -->
	<arg name="colors"/>
</ruleset>
```

## Usage

There are two ways you can run the `PHP_CodeSniffer` checks: either directly from the command line, or using an editor/IDE integration. Using an integration is strongly recommended.

### CLI

From the project root (and ssh'd into vagrant), simply run the `vendor/bin/phpcs` command with the path to the source files you want to check. As long as you have created a `phpcs.xml` config file as specified above, code will be checked using the `ActiveCampaign` standard. Here's an example:

```
$ vendor/bin/phpcs admin/classes/Subscriber.php
```

To suppress warnings, run the command with the `-n` flag.

Note that our legacy code, even code recently written, will have numerous violations of our coding standards. It is not advisable to run `phpcs` against an entire codebase, but only some particular files that you wish to check.

One recommended workflow is to just check the files that you have modified during a development session. The following command will do this (note: this requires git to be installed, which it normally is not in our vagrant box):

```
$ git ls-files -m | grep php | xargs -n 1 phpcs -n
```

So that you don't have to remember this command, you can add it to the project's `composer.json` as a script:

```
"scripts": {
	"cs": "git ls-files -m | grep php | xargs -n 1 phpcs -n"
}
```

Then you can simply run `composer cs`.

### Editor/IDE Integration

Using an editor/IDE integration to run the `PHP_CodeSniffer` checks automatically is highly recommended so that you get immediate feedback about standards violations. There are `PHP_CodeSniffer` integrations for virtually every popular editor or IDE, including the main that ActiveCampaign developers use:

- Atom: [linter-phpcs](https://atom.io/packages/linter-phpcs)
- PHPStorm: built-in [plugin](https://www.jetbrains.com/help/phpstorm/10.0/using-php-code-sniffer-tool.html)
- Sublime: [sublime-phpcs](https://github.com/benmatselby/sublime-phpcs)
- Vim: [vim-phpcs](https://github.com/bpearson/vim-phpcs)

Refer to the links above for setting up and configuring the integration for your editor.

While it is possible to configure an integration to run the `phpcs` command from within your vagrant VM, it is usually easier to install and run it directly on your host system. The easiest way to do this is to take the additional step of installing `PHP_CodeSniffer` globally using Composer. If you go this route, consider using [cgr](https://github.com/consolidation/cgr) to do so safely. Then, configure your editor integration to use that global `phpcs` and, if possible, to check for a configuration file in your project's root directory. The following configuration for `linter-phpcs` in Atom is an example that works:

![Atom linter-phpcs settings](https://d1ax1i5f2y3x71.cloudfront.net/items/063o2H3D0u1M0k0v0L05/Image%202017-03-26%20at%207.55.08%20PM.png?X-CloudApp-Visitor-Id=2104030)

In Atom, this will give you a nice view of all standards violations whenever you save the file:

![errors view](https://d1ax1i5f2y3x71.cloudfront.net/items/3X451g1n2Q443Q0P0B3T/Image%202017-03-26%20at%208.09.00%20PM.png?X-CloudApp-Visitor-Id=2104030)
