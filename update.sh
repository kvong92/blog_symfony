#!/bin/bash

# Vérifier si Composer est installé
if ! command -v composer &> /dev/null; then
    echo "Composer n'est pas installé. Veuillez installer Composer et exécuter 'composer install' manuellement."
    exit 1
fi

# Vérifier si Node.js est installé
if ! command -v node &> /dev/null; then
    echo "Node.js n'est pas installé. Veuillez installer Node.js et exécuter 'npm install' manuellement."
    exit 1
fi

# Récupérer les modifications du dépôt distant
git pull

# Exécuter d'autres tâches de mise à jour si nécessaire
# Par exemple, vous pouvez ajouter des commandes pour mettre à jour les dépendances, migrer les bases de données, etc.

# Exemple : Mettre à jour les dépendances Composer pour un projet PHP
composer install

# Exemple : Exécuter les migrations de la base de données
# php bin/console doctrine:migrations:migrate

# Exemple : Installer les dépendances Node.js pour un projet Node.js
npm install

# Les tâches de mise à jour supplémentaires vont ici...

echo "Mise à jour terminée."

