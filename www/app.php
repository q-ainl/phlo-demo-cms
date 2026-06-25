<?php
require('/srv/control/phlo/phlo.php');
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
