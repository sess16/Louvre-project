#Louvre

Project based on **Symfony 4.0**.

##How to use ?

Configure MySQL server and e-mail server credentials in a .env file.
>php bin/console doctrine:database:create

>php bin/console doctrine:schema:update --force

>composer self-update

>composer update

Import database/louvreStructureAndData.sql into your MySQL server.

Now you are ready to use the project.

**Have fun**