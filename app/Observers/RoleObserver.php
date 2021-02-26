<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver extends Observer
{
    /**
     * Handle the role "deleting" event.
     *
     * @param  \App\Models\Role $role
     * @return boolean
     */
    public function deleting(Role $role)
    {
        // If a role is not removable, it cannot be deleted.
        // Tested in: tests/Unit/Models/RoleTest.php
        return $role->removable;
    }
}
