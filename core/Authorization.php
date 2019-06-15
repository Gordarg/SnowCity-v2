<?php
include_once 'Initialize.php';
include_once BASEPATH . 'model/PathAccessLevel.php';

class Authorization
{
    // TODO: 
    var $association_userrole_posttype_action = [

        // Unauth guest
        [0, "POST", "READ"],

        // Authed subscriber (USER)
        [1, "POST", "READ"],
        [1, "COMT", "READ"],
        [1, "COMT", "POST"],
        [1, "COMT", "PUT"],
        [1, "COMT", "DELETE"],

        // Editor (EDTOR)
        [2, "POST", "READ"],
        [2, "", "READ"],
        [2, "POST", "READ"],
        [2, "POST", "READ"],
        [2, "POST", "READ"],
        [2, "POST", "READ"],

        // Admin (ADMIN)
        [3, "POST", "READ"],
        [3, "POST", "READ"],
        [3, "POST", "READ"],
        [3, "POST", "READ"],
        [3, "POST", "READ"],
        [3, "POST", "READ"],


    ];

    // TODO: Needs attention -> this will not work anymore
    // To check who can access what!
    public static function ValidatePath($Role, $Path)
    {
        $output = true;
        foreach (PathAccessLevel::Load() as $acccesslevel)
        {
            if ($acccesslevel->path == $Path)
            {
                $output = false;
                if (((string)$acccesslevel) == $Role)
                    return true;
            }
        }
        return $output;
    }

    public static function ValidatePostSelect($UserId, $Post, $PostId = null)
    {
        // Note: Used by api controllers
        // TODO
    }
    public static function ValidatePostInsert($UserId, $PostType)
    {
        // Note: Used by api controllers
        // TODO
    }
    public static function ValidatePostUpdate($UserId, $PostId)
    {
        // Note: Used by api controllers
        // TODO
    }
    public static function ValidatePostDelete($UserId, $PostId)
    {
        return ValidatePostUpdate($UserId, $PostId);
    }
}
?>
