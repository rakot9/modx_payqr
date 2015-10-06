#Установка модуля#
* Проверить права в корне сайта, т.к. сайт попытается скопировать необходимые файлы в корень сайта, при успешной установке вы найдете в корне с сайта директорию "/rest" c
  содержимым
* Отображение кнопки при детальном просмотре товара [[!payqr?&page=product&id=[[*id]]]]
* Отображение кпноки под каждым из товаров. Находим Чанк, отвечающий за отображение товара и вставляем [[!payqr?&page=category&id=[[+id]]]]
* Отображение кнопки в корзине товаров [[!payqr?&page=cart]]
* Для синхронизации статусов необходимо найти в интерфейсе модуля shopkeeper список заказов и в точности скопировать названия параметров так, как в настройке модуля PayQR




#настройка уведомлений#
правим .htaccess файл и вносим следующие строки ``` RewriteRule ^rest/index.php$ rest/index.php?_rest=$1 [QSA,NC,L] ```

Необходимо учесть, что :
  - модуль ориентирован на следующие настройки shopkeper3:
    ~ платежные системы должны хранится в переменно payments из таблицы modx_shopkeeper3_config
    ~ отсутсвует pickpoints (т. самовывоза)



!!! В файле resolve.tables.php раскомментировать удаление таблиц стр.111 //$saved = $payqr_settings->save();
 и на строке стр. 149



















#Для себя#
настройки->Наборы параметров
* cart_catalog -> Shopkeeper3:
    cartRowTpl      на shopCartRow_small
    cartTpl         на shopCart_small
    flyToCart       на nofly
    orderFormPageId на 6
    className       ShopContent
    packageName     shop

* cart_order_page -> Shopkeeper3
    cartRowTpl      на shopCartRow_full
    cartTpl         на shopCart_full
    orderFormPageId на 6
    flyToCart       на nofly
    className       ShopContent
    packageName     shop