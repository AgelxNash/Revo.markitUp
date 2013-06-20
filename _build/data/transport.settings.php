<?php
$settings = array();

$settings['settings']= $modx->newObject('modSystemSetting');
$settings['settings']->fromArray(array(
    'key' => 'markitup.settings',
    'xtype' => 'textarea',
    'value' => file_get_contents($sources['source_assets'].'/markitup/sets/full/set.js'),
    'namespace' => 'markitup',
    'area' => 'general'
),'',true,true);

$settings['speller_disable']= $modx->newObject('modSystemSetting');
$settings['speller_disable']->fromArray(array(
    'key' => 'markitup.speller_disable',
    'xtype' => 'combo-boolean',
    'value' => '',
    'namespace' => 'markitup',
    'area' => 'general'
),'',true,true);

return $settings;