#��������� ������#
* ��������� ����� � ����� �����, �.�. ���� ���������� ����������� ����������� ����� � ������ �����, ��� �������� ��������� �� ������� � ����� � ����� ���������� "/rest" c
  ����������
* ����������� ������ ��� ��������� ��������� ������ [[!payqr?&page=product&id=[[*id]]]]
* ����������� ������ ��� ������ �� �������. ������� ����, ���������� �� ����������� ������ � ��������� [[!payqr?&page=category&id=[[+id]]]]
* ����������� ������ � ������� ������� [[!payqr?&page=cart]]
* ��� ������������� �������� ���������� ����� � ���������� ������ shopkeeper ������ ������� � � �������� ����������� �������� ���������� ���, ��� � ��������� ������ PayQR




#��������� �����������#
������ .htaccess ���� � ������ ��������� ������ ``` RewriteRule ^rest/index.php$ rest/index.php?_rest=$1 [QSA,NC,L] ```

���������� ������, ��� :
  - ������ ������������ �� ��������� ��������� shopkeper3:
    ~ ��������� ������� ������ �������� � ��������� payments �� ������� modx_shopkeeper3_config
    ~ ���������� pickpoints (�. ����������)



!!! � ����� resolve.tables.php ����������������� �������� ������ ���.111 //$saved = $payqr_settings->save();
 � �� ������ ���. 149



















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