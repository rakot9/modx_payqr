#Установка модуля#
* Отображение кнопки при детальном просмотре товара
* Отображение кпноки под каждым из товаров. Находим Чанк, отвечающий за отображение товара и вставляем [[payqr?&page=product&id=[[+id]]]]
* Отображение кнопки в корзине товаров [[payqr?&page=cart]]



```[[payqr?&page=[[*id]]]]``` 

#Для себя#
настройки->Наборы параметров
* cart_catalog -> Shopkeeper3:
    cartRowTpl      на shopCartRow_small
    cartTpl         на shopCart_small
    flyToCart       на nofly
    orderFormPageId на 6

* cart_order_page -> Shopkeeper3
    cartRowTpl      на shopCartRow_full
    cartTpl         на shopCart_full
    orderFormPageId на 6
    flyToCart       на nofly