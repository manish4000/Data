<?php

namespace App\Policies;

use App\Models\MenuGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuGroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuGroup  $menuGroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MenuGroup $menuGroup)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('add-menu-group')
                ? Response::allow()
                : Response::deny('You do not have permission to add menu group.');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuGroup  $menuGroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MenuGroup $menuGroup)
    {
        return $user->can('update-menu-group')
                ? Response::allow()
                : Response::deny('You do not have permission to update menu group.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuGroup  $menuGroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MenuGroup $menuGroup)
    {
        return $user->can('delete-menu-group')
                ? Response::allow()
                : Response::deny('You do not have permission to delete menu group.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuGroup  $menuGroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MenuGroup $menuGroup)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MenuGroup  $menuGroup
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MenuGroup $menuGroup)
    {
        //
    }
}
