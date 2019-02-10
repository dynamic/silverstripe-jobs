# Silverstripe Jobs

Post open positions and receive online application submissions.

[![Build Status](https://travis-ci.org/dynamic/silverstripe-jobs.svg?branch=master)](https://travis-ci.org/dynamic/silverstripe-jobs)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dynamic/silverstripe-jobs/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-jobs/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/dynamic/silverstripe-jobs/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-jobs/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/dynamic/silverstripe-jobs/badges/build.png?b=master)](https://scrutinizer-ci.com/g/dynamic/silverstripe-jobs/build-status/master)
[![codecov](https://codecov.io/gh/dynamic/silverstripe-jobs/branch/master/graph/badge.svg)](https://codecov.io/gh/dynamic/silverstripe-jobs)

[![Latest Stable Version](https://poser.pugx.org/dynamic/silverstripe-jobs/v/stable)](https://packagist.org/packages/dynamic/silverstripe-jobs)
[![Total Downloads](https://poser.pugx.org/dynamic/silverstripe-jobs/downloads)](https://packagist.org/packages/dynamic/silverstripe-jobs)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/silverstripe-jobs/v/unstable)](https://packagist.org/packages/dynamic/silverstripe-jobs)
[![License](https://poser.pugx.org/dynamic/silverstripe-jobs/license)](https://packagist.org/packages/dynamic/silverstripe-jobs)

## Requirements

- SilverStripe 4.x

## Installation

`composer require dynamic/silverstripe-jobs`

## Example usage

Two new page types will be available - Job Collection and Job. Create a Job Collection page, and create new Jobs from the Child Pages tab.

Each job has an action to apply, which will save the submission to the database and send an email notification to specified email addresses.