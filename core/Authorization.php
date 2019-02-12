<?php
include_once 'Initialize.php';
include_once BASEPATH . 'model/PathAccessLevel.php';

class Authorization
{    
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
