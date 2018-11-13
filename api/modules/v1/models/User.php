<?php

namespace api\modules\v1\models;


class User extends \api\models\User
{
    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset(
            $fields['status'],
            $fields['auth_key'],
            $fields['password_hash'],
            $fields['password_reset_token'],
            $fields['account_activation_short_code'],
            $fields['access_token'],
            $fields['device_token'],
            $fields['created_at'],
            $fields['updated_at']
        );

        return $fields;
    }
}