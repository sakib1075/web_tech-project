
$(document).ready(function() {
    $('.update_quantity').click(function(e) {
        e.preventDefault();
        
        var productId = $(this).siblings('[name="product_id"]').val();
        var newQuantity = $(this).siblings('[name="new_quantity"]').val();
        
        $.ajax({
            type: 'POST',
            url: 'cart.php',
            data: {
                update_quantity: true,
                product_id: productId,
                new_quantity: newQuantity
            },
            success: function(response) {
                $('.shopping_cart').html(response);
            }
        });
    });

    $('.remove_button').click(function(e) {
        e.preventDefault();
        
        var productId = $(this).data('product-id');
        
        if (confirm('Are you sure, you want to delete this item')) {
            $.ajax({
                type: 'GET',
                url: 'cart.php',
                data: {
                    remove: productId
                },
                success: function(response) {
                    $('.shopping_cart').html(response);
                }
            });
        }
    });

    $('.delete_all_btn').click(function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure, you want to delete all items')) {
            $.ajax({
                type: 'GET',
                url: 'cart.php',
                data: {
                    delete_all: true
                },
                success: function(response) {
                    $('.shopping_cart').html(response);
                }
            });
        }
    });
});
