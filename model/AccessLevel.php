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
?>