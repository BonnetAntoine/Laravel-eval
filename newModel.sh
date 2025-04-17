#!/usr/bin/zsh
# exemple zsh newModel.sh Contrat/Client

cible=$1
cibleLower=`echo $cible | tr '[:upper:]' '[:lower:]'`
module=`echo $cible | sed -r 's/([a-zA-Z]*)\/[a-zA-Z]*/\1/g'`
model=`echo $cible | sed -r 's/[a-zA-Z]*\/([a-zA-Z]*)/\1/g'`
ability=`echo $model | sed -r 's/([A-Z])/_\L\1/g' | sed 's/^_//'`

php artisan make:model -rmcsf --test ${cible}
php artisan make:service -m${cible} ${module}/${model}Service
php artisan make:repository -m${cible} ${module}/${model}Repository
php artisan make:request-model -m${cible} ${module}/${model}ModelRequest

mkdir -p app/Http/Controllers/${module}
mv app/Http/Controllers/${model}Controller.php app/Http/Controllers/${module}/${model}Controller.php

sed -i -E "s/(.+)(_ability_)(.+)/\1$ability\3/" app/Http/Controllers/${module}/${model}Controller.php
sed -i -E "s/(.+)(module)(.+)/\1$module\3/" app/Http/Controllers/${module}/${model}Controller.php
sed -i -E "s/(.+)(module)(.+)/\1$module\3/" app/Http/Services/${module}/${model}Service.php
sed -i -E "s/(.+)(module)(.+)/\1$module\3/" app/Http/Repositories/${module}/${model}Repository.php
sed -i -E "s/(.+)(modelVariable)(.+)/\1$ability\3/" tests/Feature/Models/${module}/${model}Test.php
sed -i -E "s/(.+)(modelName)(.+)/\1$model\3/" tests/Feature/Models/${module}/${model}Test.php
sed -i -E "s/(.+)(module)(.+)/\1$module\3/" tests/Feature/Models/${module}/${model}Test.php
echo "Mise à jour du fichier [app/Http/Controllers/${module}/${model}Controller.php]";
echo "Mise à jour du fichier [app/Http/Services/${module}/${model}Service.php]";
echo "Mise à jour du fichier [app/Http/Repositories/${module}/${model}Repository.php]";
echo "Mise à jour du fichier [tests/Feature/Models/${module}/${model}Test.php]";

for file in database/migrations/*create_${ability}*.php ;
do
    sed -i -E "s/(.+)(ability)(.+)/\1$ability\3/" $file
    echo "Mise à jour du fichier [$file]";
done

# Création des fichiers resources
mkdir -p resources/views/$ability
echo "Création du répertoire des vues views/$ability"

exit 0
