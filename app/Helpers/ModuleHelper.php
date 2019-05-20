<?php

/**
 * Check module
 *
 * @param
 * @return
 */
function isModuleExists($module)
{
    $module = ucfirst(strtolower($module));
    $module = app('modules')->find($module);

    if ($module) {
        $content = json_decode(file_get_contents($module->getPath() . '/module.json'), true);

        if ($content['active']) {
            return true;
        }
    }

    return false;
}
