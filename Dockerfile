FROM debian:buster
RUN apt-get update
RUN apt install -y --no-install-recommends composer php-mysql php-imagick php-curl php-xml php-pgsql php-mbstring php-gd php-intl php-ldap php-sqlite3 webpack npm git ghostscript
RUN sed -i -e 's/rights="none" pattern="PDF"/rights="read|write" pattern="PDF"/g' $(find /etc -type d -iname "ImageMagick-*")/policy.xml
RUN mkdir /src
EXPOSE 8080
