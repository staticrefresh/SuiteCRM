<?php
function install_srExtensions()
{
    installLog("start srExtensions");

    require_once('ModuleInstall/ModuleInstaller.php');
    $ModuleInstaller = new ModuleInstaller();
    $ModuleInstaller->install_custom_fields(getUserStatusCustomFields());

    installUserStatusHooks();
    
    installLog("end srExtensions");
}


function installUserStatusHooks()
{
    $hooks= array(
        array(
            'module' => 'Users',
            'hook' => 'after_login',
            'order' => 98,
            'description' => 'User logged-in',
            'file' => 'modules/Users/srUserLoggedinStatus.php',
            'class' => 'SRUserLoggedinStatus',
            'function' => 'onUserLogin',
        ),
        array(
            'module' => 'Users',
            'hook' => 'before_logout',
            'order' => 99,
            'description' => 'User logged-out',
            'file' => 'modules/Users/srUserLoggedinStatus.php',
            'class' => 'SRUserLoggedinStatus',
            'function' => 'onUserLogout',
        ),
    );

    foreach ($hooks as $hook) {
        check_logic_hook_file($hook['module'], $hook['hook'], array($hook['order'], $hook['description'],  $hook['file'], $hook['class'], $hook['function']));
    }
}

function getUserStatusCustomFields()
{
    $custom_fields =
        array(
            'sr_Users_is_loggedin_c' =>
            array(
                'id' => 'sr_Users_is_loggedin_c',
                'name' => 'is_loggedin_c',
                'label' => 'LBL_IS_USER_LOGGEDIN',
                'type' => 'bool',
                'module' => 'Users',
                'default_value' => false,
                'help' => 'Is the User logged in',
                'comment' => 'true if the User is logged in',
                'audited' => false,
                'mass_update' => false,
                'duplicate_merge' => false,
                'inline_edit' => false,
                'reportable' => true,
                'importable' => false,
            ),
        );

    return $custom_fields;
}
