<?php
Class WebUser extends CWebUser
{
    public function checkAccess($operation, $params=array())
    {
        if (empty($this->id)) {
            return false;
        }
        $role = $this->getState("roles");
        if ($role === "Administrator") {
            return true; 
        }
        else{
            return false;
        }
    }
}