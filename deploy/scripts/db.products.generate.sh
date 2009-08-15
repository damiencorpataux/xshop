#!/bin/sh
F="/tmp/_xs.sql"
rm -f $F
for i in {4..999}
do
   echo "INSERT INTO Products ( \
    id , \
    creation_date , \
    active ,  \
    price ,  \
    stock , \
    weight , \
    measure_unit , \
    picturefile \
) \
VALUES ( \
    $i , \
    CURRENT_TIMESTAMP , '1', '$i.35', '$i', '$i', 'g', NULL \
);" >> $F
   echo "INSERT INTO Products_description ( \
fk_product_id , \
lang , \
name , \
description \
) \
VALUES ( \
'$i', 'en', 'Generated product $i', 'This product is generated from bash script' \
), ( \
'$i', 'fr', 'Produit produit $i', 'Ce produit est produit par script bash' \
), ( \
'$i', 'de', 'Generiert Product $i', 'Dieses Produkt generiert mit Bash-Skript' \
);" >> $F
    echo "INSERT INTO Products_custom ( \
fk_product_id , \
gluten_free , \
lactose_free , \
cholesterol_free \
) \
VALUES ( \
'$i', '1', '0', '0' \
);" >> $F

done
#cat /tmp/_xs.sql
mysql -uxshop -pxshop xshop < /tmp/_xs.sql
