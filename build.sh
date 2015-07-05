#!/bin/bash

WHERE=`pwd`

if [ -a .encoded ]; then
  TGZ_NAME="xmlrpcgateway-enc-1.0.1.tgz"
  DIR_NAME="xmlrpcgateway-enc"
else
  TGZ_NAME="xmlrpcgateway-1.0.1.tgz"
  DIR_NAME="xmlrpcgateway"
fi

cd ..
tar -cvz --exclude=OLD --exclude=*~ --exclude=CVS --exclude=.?* --exclude=np --exclude=.cvsignore -f $TGZ_NAME $DIR_NAME
cd $WHERE
