# Käytä MySQL 5.7 -peruskuvaa
FROM mysql:5.7

# Kopioi mukautettu aloitusskripti säilöön (valinnainen)
# Täällä voit suorittaa SQL-komentoja, jotka ajetaan ensimmäisellä käynnistyskerralla
COPY ./init.sql /docker-entrypoint-initdb.d/

# Ympäristömuuttujat voidaan asettaa täällä tai ajon aikana
ENV MYSQL_ROOT_PASSWORD=kyberlinna
ENV MYSQL_DATABASE=vuotodb
ENV MYSQL_USER=vuotodb
ENV MYSQL_PASSWORD=kyberlinna

# Altista MySQL:n oletusportti
EXPOSE 3306