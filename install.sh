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

# Cloner le dépôt (remplacez par l'URL réelle de votre dépôt)
git clone https://github.com/kvong92/blog_symfony.git
cd blog_symfony

# Installer les dépendances PHP
composer install

# Installer les dépendances Node.js
npm install

# Étapes de configuration supplémentaires si nécessaire

echo "Configuration terminée ! Vous pouvez maintenant commencer à travailler sur le projet."

