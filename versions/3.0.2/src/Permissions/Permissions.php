<?php
    namespace FacioCMS\Versions\v3\App\Source;

    /**
     * @name Permissions
     * Provides methods for Permissions checking
     */
    trait Permissions {
        private function HasAtLeast($role) {
            $user_permission_level = $this->user["permissions_level"];
            $at_least_level = $this->GetUserPermissionLevelByRoleString($role);

            return $user_permission_level >= $at_least_level;
        }
    }