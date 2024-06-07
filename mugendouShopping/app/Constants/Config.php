<?php

namespace App\Constants;

class Config
{
    // 在庫増減タイプ
    const PRODUCT_ADD = 1;
    const PRODUCT_REDUCE = 2;

    // 商品の表示順
    const SORT_RECOMMEND = 0;
    const SORT_HIGHER_PRICE = 1;
    const SORT_LOWER_PRICE = 2;
    const SORT_LATER = 3;
    const SORT_OLDER = 4;

    // 商品の件数
    const PAGINATION_12 = 12;
    const PAGINATION_24 = 24;
    const PAGINATION_36 = 36;
    const PAGINATION_48 = 48;
    const PAGINATION_60 = 60;
}
