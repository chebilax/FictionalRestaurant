# Restaurant fictif
Restaurant fictif avec back-office
Site web dynamique développé en PHP, utilisant Javascript.
Permet aux utilisateurs de visualiser des informations sur un restaurant fictif, de réserver une table et de passer une commande.


Utilise la Programmation Orientée Objet (POO) avec le langage de programmation PHP. 
Exemple 1 : classe Product utilisée pour créer un nouvel objet produit à chaque fois qu'un nouveau produit est ajouté à la base de données. 
Exemple 2 : La classe ProductController hérite de la classe SecurityController, ce qui montre également l'utilisation de la POO.


Chaque classe est définie dans un namespace particulier. 
Exemple :  la classe Product définie dans le namespace models, la classe SecurityController définie dans le namespace controllers, et ainsi de suite. Permet de mieux organiser le code et de faciliter la maintenance.
Permet aussi d'importer des classes depuis d'autres namespaces. 
Exemple : la classe ProductController hérite de la classe SecurityController qui est définie dans un autre namespace. 


index.php sert de point d'entrée de l'application et joue le rôle de routeur en redirigeant les requêtes HTTP entrantes vers les bonnes actions à effectuer. Il inclut les fichiers de configuration nécessaires
autoload  permet de charger automatiquement les classes en fonction de leur namespace.
Commence par démarrer la session PHP en appelant la fonction session_start(). Inclut ensuite les fichiers de configuration et les contrôleurs nécessaires. 
Définit également la constante BASE_URL qui contient l'URL de base de l'application.
Ensuite, le code analyse l'URL demandée pour déterminer l'action à effectuer. S'il y a un paramètre action dans l'URL, le code l'utilise pour sélectionner l'action à effectuer, sinon il utilise une action par défaut, qui est ici la liste des produits.
En fonction de l'action sélectionnée, le code crée une instance du contrôleur approprié et appelle la méthode correspondante. Par exemple, si l'action est addProduct, le code crée une instance de ProductController et appelle sa méthode addProduct(). Si l'action est login, le code crée une instance de UserController et appelle sa méthode login().
Le routeur permet donc de gérer les requêtes HTTP entrantes et de diriger le flux de contrôle vers le contrôleur approprié en fonction de l'action demandée.

Requêtes AJAX pour envoyer et recevoir des données asynchrones entre le navigateur et le serveur, sans avoir à recharger la page. Le code AJAX est écrit en utilisant la bibliothèque JavaScript jQuery. 
cmdAjax()  : Cette fonction récupère les détails d'un produit en utilisant son ID et retourne les données sous forme de JSON. Elle est appelée lorsqu'un utilisateur clique sur un produit pour voir ses détails.
cmdAjax2() : Cette fonction est utilisée pour insérer une nouvelle commande dans la base de données. Elle récupère les détails de la commande (tels que les produits, le prix total et le client) via une requête AJAX et les insère dans la base de données.

Base de données MySQL pour stocker et récupérer les informations de réservation soumises par les utilisateurs. La base de données est hébergée localement sur le serveur où le site est déployé. Le code PHP utilise la bibliothèque PDO (PHP Data Objects) pour interagir avec la base de données et exécuter les requêtes SQL nécessaires. Par exemple, lorsqu'un utilisateur soumet une demande de réservation, le code PHP insère les informations dans la base de données, qui peuvent être consultées ultérieurement par les propriétaires du restaurant.

Enfin, le projet FictionalRestaurant est disponible sous forme de code source sur la plateforme de développement collaboratif GitHub, ce qui permet aux utilisateurs de le consulter, de contribuer et de l'utiliser comme base pour leurs propres projets. Le projet est donc ouvert et évolutif, ce qui facilite la collaboration et la création de nouveaux projets à partir de ce code source.

Résumé :  	- Développé en PHP (POO)
            - Fichier routeur
            - Requêtes AJAX
            - Base de donnée MySQL (connexion PDO)
            - Dispo sur GitHub

