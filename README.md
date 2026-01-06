# Apache2 WebShop Configuration
## for Apache 2.4 on Debian/Ubuntu based distrabutions
Apache 2.4 WebShop Configuration. Optimized webserver setup.
 Includes such features as:
 - Maximised Concurent Server Connections
 - Development Mode Switching
   - including specialist scratch files (css/html)
   - ChromePHP  output as standard
 - Live Server Performance Advancements

Feature List

### Maximised Concurent Server Connections
All browsers set a maximun concurent connections limit (at varying levels),
following Section 8.1.4 of the HTTP/1.1 RFC
(http://www.w3.org/Protocols/rfc2616/rfc2616-sec8.html#sec8.1.4)

> By using multiple domain names, such as
> [style].mydomain.com, [func].mydomain.com, [media].mydomain.com, etc., &hellip;[it]&hellip; allows &hellip;[us]&hellip;
> to achieve a multiple of the per server connection limit.
> (http://www.stevesouders.com/blog/2008/03/20/roundup-on-parallel-connections/#more-9)
> Steve Souders. (http://www.stevesouders.com/)

This also alows us to optimize each sub-domain for its particular job and is used
extensivaly in many of the subsaquantly mentiond features.

### Development Mode Switching
By using a *dev.* sub-domain we can switch between differant views of
the same live website, automaticaly toggaling between debuging features and
optimized performance. Working in this way also enables us to layer improvments
onto the live site without interfering with its current state until each
change is vetted.

#### SCRATCH LIST
The Scratch List file (*list.scratch*) is provided as the
place to list all current Scratch Template and Scratch CSS files and is
the default root view when in Development Mode. This gives one easy
stating point from which developers can record, and clients view,
evolving ideas for the sites development.

#### SCRATCH TEMPLATE FILES
Scratch Template Files (files with a *.scratch* extension)
provid an effective method for testing new markup alone side all the
other website paraphenalia (i.e. its style and function), whilst being
inacccesible through the live site.

#### NEEDS REBUILD WARNING NOTIFICATION
If changes have been made that effect the live site without building

...

### Cascading Style Sheet Server (CSS-S)

 - Data URIs making CSS sprites
 - obsolete(http://www.nczonline.net/blog/2010/07/06/data-uris-make-css-sprites-obsolete/), using
CSSEmbed(https://github.com/nzakas/cssembed).
 - Losslessly optimization of PNG and JPG files prior to embedding Data URIs. Using
Trimage(http://trimage.org/).
 - ...

### JavaScript Server (JS-S)

### Media Server

 - Content Negosiation (favouring SGV)?...
 - Losslessly optimization of PNG and JPG files. Using Trimage(http://trimage.org/).
 - ...

### Live Server Performance?...

 - Automatically passes YSlow (minus CND)
 - Automatic versioning of css, javascript and media files
 
## Initialisation and Installation Script

The LAMP (Apache2, MySql, PHP) install can sometime get a bit picky about the order that packages are installed. Therefore it is recomended to use the below short BASH script to install this package.

> RECOMMENDATION: Looking to also install 'Web Project Management Tools' then use this [script](https://github.com/mrenyard/Web-Project-Managment-Tools?tab=readme-ov-file#initialisation-and-installation-script) instead.

Copy the below into a file on your Debian based Linux Server (init.sh):

```console
#!/bin/bash -eu

if [[ $EUID -ne 0 ]]; then echo "This script must be run as root" 1>&2; exit 1; fi
if [ $USER == 'root' ]; then USER=$SUDO_USER; HOME="/home/${SUDO_USER}"; fi
while [[ "${HOME}" == "/root" || ! -d "${HOME}" ]]; do
  echo "USER HOME PATH ${HOME} IS INVALID!";
  read -p "Enter username: " USERNAME
  HOME=`echo "/home/${USERNAME}"`;
done

sudo apt install curl

echo -e "\nINSTALLing Apache2 WebShop Configuration (LAMP)...";
sudo apt install openssl postfix apache2 -y;
sudo ufw allow "Apache Full";
sudo ufw enable;
sudo apt install mysql-server -y;
sudo apt install php libapache2-mod-php php-mysql php-xdebug -y;
VERSION=`curl -sk --head https://github.com/mrenyard/Apache2-WebShop-Configuration/releases/latest/ | grep -o "location: https://github.com/mrenyard/Apache2-WebShop-Configuration/releases/tag/v.*" | cut -d"v" -f2- | tr -d "\r"`;
wget https://github.com/mrenyard/Apache2-WebShop-Configuration/releases/download/v${VERSION}/apache2-webshop-conf_${VERSION}-0_all.deb
sudo chmod 644 apache2-webshop-conf_${VERSION}-0_all.deb;
sudo chown ${USER}:${USER} apache2-webshop-conf_${VERSION}-0_all.deb;
sudo dpkg -i apache2-webshop-conf_${VERSION}-0_all.deb;
if [ -d /etc/apache2/ssl ]; then sudo rm -rf /etc/apache2/ssl; fi;
sudo mkdir /etc/apache2/ssl;
echo "CREATING SELF-SIGNED SSL CERTIFICATE; USE ${LAN_HOSTNAME} as FDQN";
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/apache.key -out /etc/apache2/ssl/apache.crt;
sudo chown root:ssl-cert /etc/apache2/ssl/*;
sudo chmod 710 /etc/apache2/ssl/*;
sudo webstart;
sudo rm apache2-webshop-conf_${VERSION}-0_all.deb;
echo "  Apache2 WebShop Configuration (LAMP) INSTALLED...";
exit 0;
```
Change permisions to make sure it is executable:
```console 
sudo chmod 775 init.sh
```
and RUN:
```console
sudo ./init.sh
```
