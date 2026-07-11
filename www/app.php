<?php
require is_file(__DIR__.'/../vendor/phlo/tech/phlo.php') ? __DIR__.'/../vendor/phlo/tech/phlo.php' : (getenv('PHLO_ENGINE') ?: '/phlo').'/phlo.php';
phlo_app (
	id:      'PhloCMSdemo',
	host:    'demo.cms.qdev.nl',
	build:   true,
	debug:   true,
	app:     dirname(__DIR__).'/',
	files:   dirname(__DIR__).'/data/uploads/files/',
	images:  dirname(__DIR__).'/data/uploads/images/',
	thumbs:  dirname(__DIR__).'/data/uploads/thumbs/',
);
