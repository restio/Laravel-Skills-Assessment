<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<title>Laravel</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <form id="form-to-submit" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="product_name" class="col-sm-2 col-form-label">Product name</label>
                    <div class="col-sm-10">
                        <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Product name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="quantity_in_stock" class="col-sm-2 col-form-label">Quantity in stock</label>
                    <div class="col-sm-10">
                        <input type="number" name="quantity_in_stock" class="form-control" id="quantity_in_stock" placeholder="Quantity in stock">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="price_per_item" class="col-sm-2 col-form-label">Price per item</label>
                    <div class="col-sm-10">
                        <input type="text" name="price_per_item" class="form-control" id="price_per_item" placeholder="Price per item">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product name</th>
                        <th scope="col">Quantity in stock</th>
                        <th scope="col">Price per item</th>
                        <th scope="col">Datetime submitted</th>
                        <th scope="col">Total value number</th>
                    </tr>
                </thead>
                <tbody id="products-table-body">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
var token = document.head.querySelector('meta[name="csrf-token"]').content;
var products = {};
$( "#form-to-submit" ).submit(function( event ) {
    event.preventDefault();
    $.ajax({
        method: 'POST',
        url: 'product',
        dataType: "json",
        data: $('#form-to-submit').serializeArray(),
        headers: {"X-CSRF-TOKEN": token}
    }).done(function( data ) {
        location.reload();
    })
});
$.ajax({
    method: "GET",
    url: "product",
    dataType: "json",
    headers: {"X-CSRF-TOKEN": token}
}).done(function( data ) {
    var total = 0;
    for (var i in data) {
        currentValue = data[i]['quantity_in_stock'] * data[i]['price_per_item'];
        total += currentValue;
        var row = $( "#products-table-body" ).append('<tr></tr>');
        row.append('<td>'+data[i]['product_name']+'</td>');
        row.append('<td>'+data[i]['quantity_in_stock']+'</td>');
        row.append('<td>'+data[i]['price_per_item']+'</td>');
        row.append('<td>'+data[i]['created_at']+'</td>');
        row.append('<td>'+currentValue+'</td>');
    }
    $( "#products-table-body" ).append('<tr><td></td><td></td><td></td><td></td><td><strong>'+total+'</strong></td>total</tr>');
}).fail(function( jqXHR ) {
    // TODO
});
</script>
</body>
</html>
