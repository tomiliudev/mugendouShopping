<html>
    <p class="mb-4">ご購入ありがとうございます！</p>
    <div class="mb-4">商品情報</div>
    @foreach ($productInfos as $productInfo)
    <ul class="mb-4">
        <li>商品名：{{$productInfo['name']}}</li>
        <li>単価：{{number_format($productInfo['price'])}} 円（税込）</li>
        <li>個数：{{number_format($productInfo['quantity'])}} 個</li>
        <li>合計：{{number_format($productInfo['quantity'] * $productInfo['price'])}} 円（税込）</li>
    </ul>
    @endforeach
</html>
