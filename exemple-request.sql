  -Ceci est une révision de nos requêtes sql.
--L'idée est d'exécuter chacune des requêtes ci-dessous dans l'onglet SQL de phpMyAdmin.
--Lorsque votre requête fonctionne, copiez-collez la ici, sous chaque consigne.


--  créer une table users, en utilisant phpMyAdmin, contenant toutes les colonnes suivaintes : id, username, email, subscription_date
  -- pensez aux types de colonnes !

--  faire un insert d'un nouvel utilisateur
INSERT INTO `users`(`id`, `username`, `email`, `subscription_date`) VALUES ('','Mit','mit@gmail.com',Now())

--  faire un insert, plusieurs valeurs en même temps, de 3 nouveaux utilisateurs
INSERT INTO `users`(`id`, `username`, `email`, `subscription_date`) VALUES ('','Nathan','nathan@gmail.com',Now());
INSERT INTO `users`(`id`, `username`, `email`, `subscription_date`) VALUES ('','Naomie','naomie@gmail.com',Now());
INSERT INTO `users`(`id`, `username`, `email`, `subscription_date`) VALUES ('','Jessie','jessie@gmail.com',Now())

--  modifier l'email d'un user au choix
UPDATE `users` SET `email`='nathank@gmail.com' WHERE id = 2

--  effacer un user au choix
DELETE FROM `users` WHERE id=4

--  faire un autre insert avec plusieurs valeurs (2 utilisateurs)
INSERT INTO `users`(`id`, `username`, `email`, `subscription_date`) VALUES ('','Rose','rose@gmail.com',Now())
INSERT INTO `users`(`id`, `username`, `email`, `subscription_date`) VALUES ('','Jessie','jessie@gmail.com',Now())

--  ajouter une colonne country après email, à l'aide de phpMyAdmin
ALTER TABLE `users` ADD `country` VARCHAR(255) NOT NULL AFTER `email`;

--  mettre la valeur de cette colonne à "FR" pour tous les utilisateurs, en update
UPDATE `users` SET `country`= 'FR'

--  mettre "UK" comme pays pour tous les utilisateurs dont l'id est plus petit que 3
UPDATE `users` SET `country`= 'UK' WHERE id <3

--  ajouter une colonne "language" à l'aide de phpMyAdmin
--  pour tous les utilisateurs dont le "country" est "FR", ajoutez une valeur de "FR" à cette nouvelle colonne
UPDATE `users` SET `language`='FR' WHERE country='FR'


--  mettre "EN" partout où le pays est "UK"
UPDATE `users` SET `language`='UK' WHERE country='UK'

--  ajouter une colonne "gender"
ALTER TABLE `users` ADD `gender` VARCHAR(1) NOT NULL AFTER `language`;
--  mettre m où l'id est plus petit que 4
UPDATE `users` SET `gender`='m' WHERE id<4

--  mettre f pour les autres
UPDATE `users` SET `gender`='f' WHERE id>4

--  sélectionnez tous les utilisateurs
SELECT * FROM `users`

--  sélectionnez tous les hommes
SELECT * FROM users WHERE gender = 'm'

--  sélectionnez tous les hommes, du plus récent au plus ancien
SELECT * FROM users WHERE gender = 'm' ORDER BY `subscription_date` DESC

--  sélectionnez toute les femmes par ordre alphabétique d'email
SELECT * FROM `users` WHERE gender = 'f' ORDER BY email ASC

--  sélectionnez les hommes francais
SELECT * FROM `users` WHERE gender = 'm' AND country ='FR'

--  sélectionnez ceux qui sont inscrit seulement depuis 10 minutes
SELECT * FROM `users` ORDER BY `subscription_date`>Now () - INTERVAL 10 MINUTES;

--  sélectionnez uniquement le premier inscrit
SELECT * FROM `users` ORDER BY `subscription_date` ASC LIMIT 1

--  sélectionnez les 2 premières femmes inscrites
SELECT * FROM `users` WHERE `gender` = 'f' ORDER BY `subscription_date` ASC LIMIT 2

--  sélectionnez le 1er et 2e francais à s'être inscrits
SELECT * FROM `users` WHERE `country` = 'FR' ORDER BY `subscription_date` ASC LIMIT 2

--  sélectionnez un user au hasard
SELECT * FROM `users` ORDER BY RAND() LIMIT 1;