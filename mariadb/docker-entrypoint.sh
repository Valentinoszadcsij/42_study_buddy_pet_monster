#!/bin/bash
set -e

# initialize MariaDB
echo "Running MariaDB init script"
mkdir -p /run/mysqld
mkdir -p /tmp
chown -R mysql:mysql /run/mysqld

echo "Initializing DB"
if [ ! -d /var/lib/mysql/mysql ]; then
    echo "Initializing MariaDB data directory..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql
fi

# start MariaDB service 
echo "Starting MariaDB..."
chown -R mysql:mysql /var/lib/mysql
chown -R mysql:mysql /tmp
mysqld --user=mysql --datadir=/var/lib/mysql --skip-networking &
pid="$!"

echo "Waiting for MariaDB to be ready..."
while ! mysqladmin ping --silent; do
    echo "-"
    sleep 1
done

# create database and user
echo "Creating DB and user"
echo "USER: $MARIADB_USER, PASS: $MARIADB_PASSWORD"
mysql -u root -p"$MARIADB_ROOT_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $MARIADB_DATABASE;"
mysql -u root -p"$MARIADB_ROOT_PASSWORD" -e "CREATE USER IF NOT EXISTS '$MARIADB_USER'@'%' IDENTIFIED BY '$MARIADB_PASSWORD';"
mysql -u root -p"$MARIADB_ROOT_PASSWORD" -e "GRANT ALL PRIVILEGES ON $MARIADB_DATABASE.* TO '$MARIADB_USER'@'%';"
mysql -u root -p"$MARIADB_ROOT_PASSWORD" -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '$MARIADB_ROOT_PASSWORD';"
mysql -u root -p"$MARIADB_ROOT_PASSWORD" -e "FLUSH PRIVILEGES;"

echo "Running init-users.sql script..."
mysql -u root -p"$MARIADB_ROOT_PASSWORD" "$MARIADB_DATABASE" < /docker-entrypoint-initdb.d/init-tables.sql

echo "Shutting down MariaDB..."
mysqladmin -u root -p"$MARIADB_ROOT_PASSWORD" shutdown

echo "Restarting MariaDB..."
exec mysqld --user=mysql --datadir=/var/lib/mysql