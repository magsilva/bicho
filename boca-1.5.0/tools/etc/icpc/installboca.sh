#!/bin/bash
di=`date +%s`
echo "==================================================="
echo "=================== obtaining BOCA  ==============="
echo "==================================================="

wget -O /tmp/.boca.tmp "http://www.ime.usp.br/~cassio/boca/boca.date.txt"
echo ">>>>>>>>>>"
echo ">>>>>>>>>> Downloading boca release `cat /tmp/.boca.tmp`"
echo ">>>>>>>>>>"

if [ "$1" == "" ]; then
wget -O /tmp/.boca.tmp "http://www.ime.usp.br/~cassio/boca/bocaver.txt"
bocaver=`cat /tmp/.boca.tmp`
else
bocaver=$1
fi
echo "Looking for BOCA version $bocaver from http://www.ime.usp.br/~cassio/boca/"
if [ "$2" == "" ]; then
basedir=/var/www
else
if [ -d "$2" ]; then
basedir=$2
else
echo "Directory $2 does not exist"
exit 1
fi
fi

cd $basedir
rm -f boca-$bocaver.tgz
wget -O boca-$bocaver.tgz "http://www.ime.usp.br/~cassio/boca/download.php?filename=boca-$bocaver.tgz"
if [ "$?" != "0" -o ! -f boca-$bocaver.tgz ]; then
  echo "ERROR downloading BOCA package version $bocaver. Aborting *****************"
  exit 1
fi
grep -qi "bad parameters" boca-$bocaver.tgz
if [ "$?" == "0" ]; then
  echo "ERROR downloading BOCA package version $bocaver. Aborting *****************"
  exit 1
fi
echo "==========================================================="
echo "====================== BACKUPING OLD BOCA   ==============="
echo "==========================================================="
if [ -d boca-$bocaver ]; then
  mv boca-$bocaver boca-$bocaver.$di
  echo "OLD BOCA FOLDER for version $bocaver saved as boca-$bocaver.$di"
fi

echo "bocadir=$basedir/boca" > /etc/boca.conf
chmod 644 /etc/boca.conf

echo "====================================================="
echo "=================== EXTRACTING BOCA   ==============="
echo "====================================================="

OK=x
if [ -f boca-$bocaver.$di/src/private/conf.php ]; then
 echo "OLD CONFIG FILE EXISTS"
 OK=x
 while [ "$OK" != "y" -a "$OK" != "n" ]; do
   OK=x
   read -p "Do you want to keep the old private/conf.php file [y/n] (note that the old file might be incompatible with this version)? " OK
 done
 if [ "$OK" == "n" ]; then
   echo "You probably need to update the new file boca-$bocaver/src/private/conf.php with the correct passwords - PLEASE CHECK IT - NOT DONE AUTOMATICALLY"
 fi
fi

apacheuser=
[ -r /etc/icpc/apacheuser ] && apacheuser=`cat /etc/icpc/apacheuser | sed 's/ \t\n//g'`
[ "$apacheuser" == "" ] && apacheuser=www-data
id -u $apacheuser >/dev/null 2>/dev/null
if [ $? != 0 ]; then
  echo "User $apacheuser not found -- error to set permissions with chown/chmod"
  apacheuser=root
fi

tar xzf boca-$bocaver.tgz
chown -R root.$apacheuser boca-$bocaver/
chmod -R g+rx,u+rwx boca-$bocaver/

chmod 600 boca-$bocaver/src/private/*.php
[ -f boca-$bocaver.$di/src/private/remotescores/otherservers ] && cp -f boca-$bocaver.$di/src/private/remotescores/otherservers boca-$bocaver/src/private/remotescores/otherservers
if [ "$OK" == "y" ]; then
  cp -f boca-$bocaver.$di/src/private/conf.php boca-$bocaver/src/private/conf.php
fi
chmod 700 boca-$bocaver/tools/*.sh

cat > boca-$bocaver/src/.htaccess <<EOF
php_flag output_buffering on
php_value memory_limit 256M
php_value post_max_size 128M
php_flag magic_quotes_gpc off
php_value upload_max_filesize 128M
EOF
chmod 755 boca-$bocaver/src/.htaccess
cat > boca-$bocaver/tools/.htaccess <<EOF
Deny from all
EOF
chmod 755 boca-$bocaver/tools/.htaccess
cp boca-$bocaver/tools/.htaccess boca-$bocaver/doc/.htaccess
cp boca-$bocaver/tools/.htaccess boca-$bocaver/old/.htaccess
cp boca-$bocaver/tools/.htaccess boca-$bocaver/src/private/.htaccess
cp boca-$bocaver/tools/.htaccess boca-$bocaver/src/webcast/.htaccess

chmod -R 770 boca-$bocaver/src/private
chmod -R 775 boca-$bocaver/src/balloons

echo "=========================================================================================="
echo "=========== SETTING UP SOME LINKS (main apache server index.html updated)  ==============="
echo "=========================================================================================="

rm -f $basedir/boca /usr/bin/makebkp.sh
ln -s $basedir/boca-$bocaver $basedir/boca
ln -s $basedir/boca/tools/makebkp.sh /usr/bin/makebkp.sh
chmod 755 $basedir/boca/tools/makebkp.sh
chmod 755 $basedir/boca/tools/singlefilebkp.sh

echo "=============================================================="
echo "================== COMPILING safeexec utility  ==============="
echo "=============================================================="

cd $basedir/boca/tools
gcc -static -O2 -Wall safeexec.c -o safeexec
if [ $? == 0 ]; then
  echo "COMPILATION OK"
fi
strip safeexec
cp -f safeexec /usr/bin
chmod 4555 /usr/bin/safeexec

echo "=================================================="
echo "=================== SERVER SETUP   ==============="
echo "=================================================="

OK=n
echo "You can run at anytime later the script /etc/icpc/becomeserver.sh to prepare the computer to be the BOCA server"
read -p "Do you want me to call the script to make this computer the server (don't do it if this install is for a team or autojudge) [y/N]? " OK
if [ "$OK" == "y" -o "$OK" == "Y" ]; then
  OK=n
  read -p "Do you really want to make this computer the server (you don't need to do it if you are only upgrading BOCA)? [y/N]? " OK
  if [ "$OK" == "y" -o "$OK" == "Y" ]; then
  /etc/icpc/becomeserver.sh
  fi
fi

cat > /etc/apache2/conf.d/boca <<EOF
<Directory $basedir/boca/src>
       AllowOverride Options AuthConfig Limit
       Order Allow,Deny
       Allow from all
       AddDefaultCharset utf-8
</Directory>
<Directory $basedir/boca/src/private>
       AllowOverride Options AuthConfig Limit
       Deny from all
</Directory>
<Directory $basedir/boca>
       AllowOverride Options AuthConfig Limit
       Deny from all
</Directory>
Alias /boca $basedir/boca/src
EOF
