#��������� ������#
* ����������� ������ ��� ��������� ��������� ������
* ����������� ������ ��� ������ �� �������. ������� ����, ���������� �� ����������� ������ � ��������� [[!payqr?&page=category&id=[[+id]]]]
* ����������� ������ � ������� ������� [[!payqr?&page=cart]]



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