<?php
include_once 'Initialize.php';
include_once BASEPATH . 'model/AccessLevel.php';

class Authorization
{
    private $accesslevels = array();

    public function __construct ()
    {
        // TODO: to read from file
        array_push($this->accesslevels, new AccessLevel("tinyfilemanager.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("profile.php", "VSTOR"));
        array_push($this->accesslevels, new AccessLevel("profile.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("post.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("post.php|ANSR", "VSTOR"));
        array_push($this->accesslevels, new AccessLevel("post.php|COMT", "VSTOR"));
        array_push($this->accesslevels, new AccessLevel("post.php|FILE", "VSTOR"));
        array_push($this->accesslevels, new AccessLevel("settings.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("users.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("box.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("box.php", "VSTOR"));
        array_push($this->accesslevels, new AccessLevel("view_question.php", "VSTOR", true));
        array_push($this->accesslevels, new AccessLevel("view_question.php", "ADMIN", true));
        array_push($this->accesslevels, new AccessLevel("database.php", "VSTOR"));
        array_push($this->accesslevels, new AccessLevel("database.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("question.php", "ADMIN"));
        array_push($this->accesslevels, new AccessLevel("answers_table.php", "ADMIN", true));
        array_push($this->accesslevels, new AccessLevel("comment_helper.php", "ADMIN", true));
        array_push($this->accesslevels, new AccessLevel("post_comment_delete.php", "ADMIN", true));
    }
    
    // TODO: Needs attention -> this will not work anymore
    // To check who can access what!
    public function Validate($path, $role)
    {
        foreach ($this->accesslevels as $acccesslevel)
        {
            if (((string)$acccesslevel) == $role)
                if ($acccesslevel->path == $path)
                    return true;
        }
        return false;
    }
}
?>
