
function addLive(productadd) {
    $.ajax({
        url: "/php/plus.php",
        method: "POST",
        data: { productadd: productadd }, 
        success: function(response) {
            console.log(productadd)
            console.log(response)
            alert("Updated Successfully!");
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

}
$('.btn.add-cart').click(function(e) {
    e.preventDefault(); 
    var productadd = $(this).data('product-add'); 
    addLive(productadd);
});



