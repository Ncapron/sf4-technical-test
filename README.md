### Installation

git clone https://github.com/Ncapron/sf4-technical-test.git
composer install dans la console dans le projet
configurer la bdd dans le fichier "parameters.yml"

php app/console doctrine:database:create

php app/console doctrine:generate:entities GithubBundle

php app/console doctrine:schema:update --force

php app/console asset install


## Informations sur le projet  

### Recherche et commentaires

Au départ j'avais fait une recherche direct par rapport aux informations inscrite dans l'input (j'ai laissé en commentaire l'ancienne version) mais à cause de la Rate Limit github j'ai alors utilisé un bouton recherche basique.

Vous inscrivez le nom d'un utilisateur et le tableau se remplit s'il trouve des utilisateurs.

Au clic sur son nom, vous arrivez sur un formulaire qui vous demande le nom et le commentaire.

J'ai essayé de le faire en select avec des options (j'ai laissé en commentaire) mais je n'ai pas réussi à le valider, j'avais une erreur m'indiquant que la value était vide.

Lorsque vous inscrivez "username/repoName" tel que "Ncapron/AJAX" une recherche se fait afin d'être sur que ce repo existe, s'il existe, un message indique que le commentaire a été créé et vous redirige sur la création d'un commentaire pour le même utilisateur.

Si en revenche ce repo n'existe pas un message vous indique de vérifier le nom du repo et celui ci n'est pas enregistré.

Un edit et une suppression est possible pour chaque commentaire.

Les commentaires créés pour un utilisateur ne sont visible que lorsque vous cliquez sur celui ci. Par exemple les commentaires créés pour "Ncapron" ne sont pas visible si vous allez sur "nicaproni". (findByUsername)

Je n'ai pas eu le temps de faire le redirect si la personne n'est pas loggué. Mais FosUser est installé /register + /login. J'ai eu un soucis dans l'edit pour les boutons supprimer et annuler qui ne sont pas alligné.

### Durée effectuée
mardi Début 18h15
mercredi Pause 19h00
reprise mercredi 20h25
Pause mercredi 20h50
reprise samedi 13h30
fin samedi 16h10





# StadLine Technical Test

### Tache

Le sujet de base est simple : Il faut créer une page sécurisée qui permet à un utilisateur de se loguer et de faire un commentaire sur un dépôt publique d'un utilisateur GitHub.
La fonctionnalité de commentaire n'existe pas sur Github, vous devrez donc stocker et afficher ces commentaires dans votre espace sécurisé.

### Règles

* Le temps est libre mais il est tout de même conseillé de passer moins de 4h sur le sujet (temps de setup d'environnement compris)
* Il est conseillé de finir les points requis avant de s'attaquer au bonus.
* Il est aussi conseillé de faire un maximum de commit pour bien détailler les étapes de votre raisonnement au cours du développement.
* N'hésitez pas à nous faire des retours et nous expliquer les éventuelles problématiques bloquantes que vous auriez rencontrées durant le développement vous empéchant de finir.

### Setup

* La charte graphique n'est pas imposée et sera jugée en bonus. L'emploi d'un framework CSS type Twitter Bootstrap est fortement conseillé.
* Vous aurez besoin d'un environnement php5.5, Symfony2 et un serveur pour l'application.

### Les pré-requis

* Vous êtes libre d'utiliser un bundle d'authentification externe ou votre propre bundle.
* Le formulaire de connexion doit avoir une validation coté serveur.
* Toutes les pages doivent être sécurisées et pointer sur la page de login si l'utilisateur n'est pas connecté.
* Le choix du client HTTP est laissé à discrétion pour appeller l'API de GitHub.
* Une fois connecté, il est nécessaire d'implémenter un champ de recherche qui permette de chercher les utilisateurs GitHub. La documentation est disponible ici : https://developer.github.com/v3/search/#search-users .
* Vous devez appeller l'API suivante avec q=searchFieldContent :
```
https://api.github.com/search/users
```
* Une fois le champ de recherche validé et l'utilisateur sélectionné, on arrive sur l'url /{username}/comment, on affiche un formulaire qui sera composé des champs suivants : un champ texte pour le nom d'un dépôt ({user}/{repos}, e.g : stadline/sf2-technical-test), un textArea pour le commentaire, un bouton valider permettant d'ajouter un commentaire.
* On affichera en dessous la liste des commentaires déjà saisis pour l'utilisateur.
* Lors de la validation du formulaire, on vérifiera que le repository sélectionné est bien un dépôt appartenant à l'utilisateur précédement recherché.
* On attend aussi de vous que le code soit testable et testé.

### Bonus

* On changera le choix du dépôt par un multiselect afin de lister directement dans le formulaire les dépôts de l'utilisateur.
* Utilisation d'un frameworkJS pour afficher les résultats
* Toutes les fonctionnalités que vous aurez le temps d'ajouter seront aussi bonnes à prendre. Un bonus autour de votre créativité pourra être considéré.

### Délivrabilité

* Forkez le projet sur GitHub et codez directement dans le projet forké.
* Commitez aussi souvent que possible et commentez vos commits pour détailler votre chemin de pensée.
* Mettez à jour le README pour ajouter le temps passé et tout ce que vous jugerez nécessaire de nous faire savoir.
* Envoyez le lien avec le projet à recrutement@stadline.com.

**Bonne chance !**
