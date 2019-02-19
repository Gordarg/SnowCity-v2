<?php
class PathAccessLevel{
    public static function Load()
    {
        $output = array();

        // TODO: to read from file
        array_push($output, new PathAccessLevelModel("dashboard", "EDTOR"));
        array_push($output, new PathAccessLevelModel("dashboard", "ADMIN"));
        array_push($output, new PathAccessLevelModel("say|", "EDTOR"));
        array_push($output, new PathAccessLevelModel("say|", "ADMIN"));
        array_push($output, new PathAccessLevelModel("say|post", "EDTOR"));
        array_push($output, new PathAccessLevelModel("say|post", "ADMIN"));
        array_push($output, new PathAccessLevelModel("say|file", "ADMIN"));

        return $output;
    }
}

class PathAccessLevelModel {
    private $path;
    private $role;

    public function __construct ($path, $role) {
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
?>