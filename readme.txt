#��������� ������#
* ����������� ������ ��� ��������� ��������� ������ [[!payqr?&page=product&id=[[+id]]]]
* ����������� ������ ��� ������ �� �������. ������� ����, ���������� �� ����������� ������ � ��������� [[!payqr?&page=category&id=[[+id]]]]
* ����������� ������ � ������� ������� [[!payqr?&page=cart]]


#��������� �����������#
������ .htaccess ���� � ������ ��������� ������ ``` RewriteRule ^rest/index.php$ rest/index.php?_rest=$1 [QSA,NC,L] ```



```[[payqr?&page=[[*id]]]]``` 

#��� ����#
���������->������ ����������
* cart_catalog -> Shopkeeper3:
    cartRowTpl      �� shopCartRow_small
    cartTpl         �� shopCart_small
    flyToCart       �� nofly
    orderFormPageId �� 6
    className       ShopContent
    packageName     shop

* cart_order_page -> Shopkeeper3
    cartRowTpl      �� shopCartRow_full
    cartTpl         �� shopCart_full
    orderFormPageId �� 6
    flyToCart       �� nofly
    className       ShopContent
    packageName     shop