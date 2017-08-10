# json-repository

[![Build Status](https://travis-ci.org/chrisharrison/json-repository.svg?branch=master)](https://travis-ci.org/chrisharrison/json-repository)

Implement simple repositories backed with JSON files. The flat JSON files can be persisted using a local filesystem or an abstract filesystem provided by [Flysystem](https://github.com/thephpleague/flysystem) (e.g. Amazon S3).

This package is useful for providing a temporary persistence layer when developing repository interfaces.

## Requirements ##

Requires PHP 7.1

## Installation ##

`composer require chrisharrison/json-repository`
