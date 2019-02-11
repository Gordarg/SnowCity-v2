<?php
class AccessLevel {

    private $path;
    private $role;

    public function __construct ($path, $role, $helper = false) {
        if (!$helper)
            $this->path = config::Url_PATH . "/" . $path;
        else
            $this->path = $path;
        $this->role = $role;
    }

    public function __get($property) {
        if (property_exists($this, $property))
            return $this->$property;
    }

    public function __set($property, $value) {
        if (property_exists($this, $property))
            $this->$property = $value;
        return $this;
    }

    public function __toString()
    {
        return $this->role;
    }
}


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
    public function validate($path, $role)
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
