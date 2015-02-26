# aGov [![Build Status](https://travis-ci.org/previousnext/agov.svg?branch=2.x)](https://travis-ci.org/previousnext/agov)

## Download

aGov is available as a full drupal site in tgz and zip format at: http://drupal.org/project/agov

## Building from Source

Source is available from GitHub at https://github.com/previousnext/agov

### Requirements

Install phing and drush in the standard way. You can use composer to install both
tools using the following:

```
composer global require --prefer-dist --no-interaction drush/drush:6.*
composer global require --prefer-dist --no-interaction phing/phing:2.7.*
```

### Building
To install a local working copy of aGov follow these steps.

First create a copy of build.properties and update it for your local settings.

```
cp build.example.properties build.properties
```

The phing build creates a full install of Drupal, outside the current project dir.
This directory can be specified in the build.properties (defaults to ../agov-local).

To run a clean build, and all behat tests:

```
phing
```

### Vagrant

Simplify your local aGov development using Vagrant.

Use the _separate_ agov_local git project, checked out in a directory above the current project directory.

Follow the setup documentation for agov-local at https://github.com/previousnext/agov-local

Once you have vagrant and the required plugins, you can run the following:

```
cd ..
git clone https://github.com/previousnext/agov-local.git
cd agov-local
vagrant up --provision
```

You should then be able to access your agov site at

```
http://agov.dev
```

### Testing

aGov uses behat for its functional tests. To run behat tests, use the following:

```
phing test:all
```
