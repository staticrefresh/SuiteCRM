<?php
use Api\V8\Param\Options\Attributes;

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    class SRUserLoggedinStatus
    {
        function onUserLogin($bean, $event, $arguments)
        {
                global $timedate;
                global $current_user;

                LoggerManager::getLogger()->info("SR:User '" . $current_user->user_name . "' has logged in.");
                
                if ($current_user->is_loggedin_c) {
                    LoggerManager::getLogger()->warn()("SR:Issue:User '" . $current_user->user_name . "' logged in without being logged out!");
                }
                $current_user->is_loggedin_c = true;
                $current_user->save();
/*                
                // Create the entries for the historical list of logic/logout times kept in the User Activity module
                $activityBean = BeanFactory::newBean('rcual_useractivity');
                $activityBean->useractivitytype = "login";
                $activityBean->useractivitytime = $timedate->nowDb();
                $activityBean->save();
                // Load the relationship between the Contacts and the Notes module
                $bean->load_relationship('users_rcual_useractivity_1');
                // Relate the new entry to the user
                $bean->users_rcual_useractivity_1->add($activityBean);
*/                
        }

        function onUserLogout($bean, $event, $arguments)
        {
            
                global $timedate;
                global $current_user;

                LoggerManager::getLogger()->info("SR:User '" . $current_user->user_name . "' has logged out.");
                
                if (!$current_user->is_loggedin_c) {
                        LoggerManager::getLogger()->warn()("SR:Issue:User '" . $current_user->user_name . "' logged out without being logged in!");
                }
                $current_user->is_loggedin_c = false;
                $current_user->save();
/*     
                // Create the entries for the historical list of logic/logout times kept in the User Activity module
                $activityBean = BeanFactory::newBean('rcual_useractivity');
                $activityBean->useractivitytype = "logout";
                $activityBean->useractivitytime = $timedate->nowDb();
                $activityBean->save();
                // Load the relationship between the Contacts and the Notes module
                $bean->load_relationship('users_rcual_useractivity_1');
                // Relate the new entry to the user
                $bean->users_rcual_useractivity_1->add($activityBean);
*/                
        }
    }

?>
