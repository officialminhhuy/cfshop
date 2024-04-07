// Show Navbar when small screen || Close Cart Items & Search Textbox
let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active'); 
    cartItem.classList.remove('active');
    searchForm.classList.remove('active');
}

// Show Cart Items || Close Navbar & Search Textbox
let cartItem = document.querySelector('.cart');

document.querySelector('#cart-btn').onclick = () => {
    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}
let searchForm = document.querySelector('.search-form');
let foundResults = document.getElementById('found');
document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
    foundResults.style.display = "none"
}
document.getElementById('search-box').onfocus = () => {
    foundResults.style.display = "block"
    navbar.classList.remove('active');
}

// Remove Active Icons on Scroll and Close it
window.onscroll = () => {
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    foundResults.style.display = "none"
}

// Script for making icon as button
document.getElementById('paper-plane-icon').addEventListener('click', function() {
    // Add your desired action here, e.g. submit form, trigger AJAX request, etc.
    alert('Paper airplane clicked!');
});


//Cart Working JS
if (document.readyState == 'loading') {
    document.addEventListener("DOMContentLoaded", ready);
} else {
    ready();
}

// FUNCTIONS FOR CART
function ready() {
    var removeCartButtons = document.getElementsByClassName('cart-remove');
    // console.log(removeCartButtons);
    // for (var i = 0; i < removeCartButtons.length; i++){
    //     var button = removeCartButtons[i];
    //     button.addEventListener('click', removeCartItem);
    // }

    // var quantityInputs = document.getElementsByClassName("cart-quantity");
    // for (var i = 0; i < quantityInputs.length; i++){
    //     var input = quantityInputs[i];
    //     input.addEventListener("change", quantityChanged);
    // }

    // Add to Cart
    var addCart = document.getElementsByClassName('add-cart');
    for (var i = 0; i < addCart.length; i++){
        var button = addCart[i];
        button.addEventListener("click", addCartClicked);
    }
}
function checkout() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            if (response == "success") {
                console.log(response);
                alert("Checkout successful!");
                location.reload();
            } else {
                alert("Error!");
                location.reload();
                console.log(response);
            }
        }
    };
    xhttp.open("POST", "payment.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}


function updateMenu(sortOption) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "product.php?sortOption=" + sortOption, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById("menu").innerHTML = response.menu;
            document.getElementById("sort").value = sortOption;
        }
    };
    xhr.send();
}

document.getElementById("sort").addEventListener("change", function() {
    var selectBox = document.getElementById("sort");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    console.log("Selected Sort Option: " + selectedValue);
    updateMenu(selectedValue);
});

//Add to Cart
function addCartClicked() {
    var productNameElement = document.querySelector('.idpro');
    if (productNameElement !== null) {
        var productName = productNameElement.innerText;
        console.log(productName);
    } else {
        console.log(productName);
    }
}
function updateCart() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = JSON.parse(this.responseText);
            var cartItems = response.cartItems;
            var totalPrice = response.totalPrice;

            var cartContent = document.querySelector('.cart-content');
            cartContent.innerHTML = '';
            cartItems.forEach(function(item) {
                var cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <div class="item-id">${item.PName}</div>
                    <img src="/assets/images/${item.image}" style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="item-id">Quantity: ${item.number}</div>
                    <div class="item-price">Price: ${item.totalprice}VND</div>
                    <i class="fas fa-trash cart-remove"></i>
                    </br>
                `;
                cartContent.appendChild(cartItem);
            });

            var totalPriceElement = document.getElementById('total-price');
            totalPriceElement.textContent = totalPrice;

            updateCart();
        }
    };
    xhttp.open("GET", "update_cart.php", true);
    xhttp.send();
}

updateCart();

document.querySelector('.btn-buy').addEventListener('click', function() {
    checkout();
});



function addLive(productadd) {
    $.ajax({
        url: "/php/plus.php",
        method: "POST",
        data: { productadd: productadd }, 
        success: function(response) {   
            console.log(productadd)
            console.log(response)
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

}
$('.plus').click(function(e) {
    e.preventDefault(); 
    var productadd = $(this).data('product-add'); 
    addLive(productadd);
});
function minusLive(productadd) {
    $.ajax({
        url: "/php/minus.php",
        method: "POST",
        data: { productadd: productadd }, 
        success: function(response) {
            console.log(productadd)
            console.log(response)
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

}
$('.minus').click(function(e) {
    e.preventDefault(); 
    var productadd = $(this).data('product-add'); 
    minusLive(productadd);
});
document.addEventListener("DOMContentLoaded", function() {
    var plusButtons = document.querySelectorAll('.plus');
    var minusButtons = document.querySelectorAll('.minus');
    var inputFields = document.querySelectorAll('.numberss');

    plusButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var inputField = this.previousElementSibling;
            var currentValue = parseInt(inputField.value);
            var newValue = currentValue + 1;
            inputField.value = newValue;
            console.log (inputField.value)
        });
    });


    minusButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var inputField = this.nextElementSibling;
            var currentValue = parseInt(inputField.value);
            var newValue = Math.max(currentValue - 1, 0);
            inputField.value = newValue;
            console.log (inputField.value)
            if(inputField.value == 0){
                location.reload();
            }
            
        });
    });
});
function viewLive(productId) {
    $.ajax({
        url: "/php/detail.php",
        method: "POST",
        data: { productId: productId }, 
        success: function(response) {
            console.log(productId)
            $("#detailz").html(response).css("display", "block");
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });

}
$('.btn.views').click(function(e) {
    e.preventDefault(); 
    var productId = $(this).data('product-id'); 
    viewLive(productId);
});




function hidePopup() {
    var popupScreen = document.querySelector(".popup-screen");
    popupScreen.classList.toggle("active");

}
let popupWindow;

function openPopup() {
    document.documentElement.style.overflow = 'hidden';
    window.addEventListener('beforeunload', closePopupHandler);
}
function closePopupHandler() {
    document.documentElement.style.overflow = '';
    window.removeEventListener('beforeunload', closePopupHandler);
}
const numberssElements = document.querySelectorAll('.numberss');
const viewsElements = document.querySelectorAll('.btn.views');
for (let i = 0; i < numberssElements.length; i++) {
    const item = numberssElements[i];
    const element = viewsElements[i];
    if (parseInt(item.value) <= 0) {
        item.previousElementSibling.style.display = 'none';
        item.nextElementSibling.style.display = 'none';
        item.style.display = 'none';
        element.style.display = '';
    } else {
        item.previousElementSibling.style.display = '';
        item.nextElementSibling.style.display = '';
        item.style.display = '';
        element.style.display = 'none';
    }
}