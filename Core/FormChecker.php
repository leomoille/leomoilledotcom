<?php

namespace App\Core;

class FormChecker
{
    /**
     * @param array $form
     * @param array $fields
     *
     * @return bool
     */
    public static function validate(array $form, array $fields): bool
    {
        // On parcourt chaque champ
        foreach ($fields as $field) {
            // Si le champ est absent ou vide dans le tableau
            if (empty($form[$field])) {
                // On sort en retournant false
                return false;
            }
        }

        // Ici le formulaire est "valide"
        return true;
    }
}
