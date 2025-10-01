<?php

namespace App\Entity;

use Exception;

class Entity
{
    // La fonction createAndHydrate permet d'instancier un objet et de l'hydrater avec les données du tableau passé en paramètre
    public static function createAndHydrate(array $data): static
    {
        $entity =  new static();
        $entity->Hydrate($data);
        return $entity;
    }

    // La fonction Hydrate permet de récupérer les données de chaque enregistrement de la table et de les assigner aux attributs d'un objet avec un setter
    public function Hydrate(array $data): void
    {
        foreach ($data as $key => $value) {

            // foreach parcourt le tableau $data
            // $key = nom de la colonne
            // $value = valeur du champ de la colonne

            // str_replace remplace les - et _ par rien
            $methodName = str_replace(array("-", "_"), "", $key);
            // ucwords met en majuscule la premiere lettre de chaque mot
            $methodName = ucwords($methodName);
            // str_replace remplace les espaces par rien
            $methodName = str_replace(" ", "", $methodName);
            // On définit le nom de la méthode qu'on va appeler
            // Par exemple : set Name
            $methodName = "set" . $methodName;

            if (!method_exists($this, $methodName)) {
                throw new \Exception("La méthode {$methodName} n'existe pas dans la class " . get_class($this));
            }
            if ($key === "date" && $value !== null) {
                $value = new \DateTimeImmutable($value);
            }
            if ($key === "time" && $value !== null) {
                $value = new \DateTimeImmutable($value);
            }

            // On appelle la méthode
            $this->{$methodName}($value);
        }
    }
}
