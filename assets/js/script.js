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
    cartItem.classList.remove('active');
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
    //Remove Items from Cart
    var removeCartButtons = document.getElementsByClassName('cart-remove');
    console.log(removeCartButtons);
    for (var i = 0; i < removeCartButtons.length; i++){
        var button = removeCartButtons[i];
        button.addEventListener('click', removeCartItem);
    }

    // When quantity changes
    var quantityInputs = document.getElementsByClassName("cart-quantity");
    for (var i = 0; i < quantityInputs.length; i++){
        var input = quantityInputs[i];
        input.addEventListener("change", quantityChanged);
    }

    // Add to Cart
    var addCart = document.getElementsByClassName('add-cart');
    for (var i = 0; i < addCart.length; i++){
        var button = addCart[i];
        button.addEventListener("click", addCartClicked);
    }

    // Buy Button Works
    document.getElementsByClassName("btn-buy")[0].addEventListener("click", buyButtonClicked);
}

// Function for "Buy Button Works"
function buyButtonClicked() {
    alert('Your order is placed! Thank you for buying and enjoy your coffee!');
    var cartContent = document.getElementsByClassName("cart-content")[0];
    var cartBoxes = cartContent.getElementsByClassName("cart-box");
    var orderDetails = [];
    var invoiceNumber = generateInvoiceNumber();
    for (var i = 0; i < cartBoxes.length; i++) {
        var cartBox = cartBoxes[i];
        var title = cartBox.getElementsByClassName("cart-product-title")[0].innerText;
        var price = cartBox.getElementsByClassName("cart-price")[0].innerText;
        var quantity = cartBox.getElementsByClassName("cart-quantity")[0].value;
        var priceValue = parseFloat(price.replace('VND', '').replace(',', ''));
        var subtotalAmount = priceValue * quantity;
        orderDetails.push({ title: title, price: priceValue, quantity: quantity, subtotal_amount: subtotalAmount, invoice_number: invoiceNumber });    
    }

    //Send data to server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_database.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    xhr.send(JSON.stringify(orderDetails));
    cartItem.classList.remove('active');

    // Clear cart after sending data to server
    while (cartContent.hasChildNodes()) {
        cartContent.removeChild(cartContent.firstChild);
    }
    updateTotal();
}

// Function to generate invoice number
function generateInvoiceNumber() {
    // Implement your logic to generate an invoice number here
    return "INV-" + Math.floor(Math.random() * 1000000);
}

// Function for "Remove Items from Cart"
function removeCartItem(event) {
    var buttonClicked = event.target;
    buttonClicked.parentElement.remove();
    updateTotal();
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


// Function for "When quantity changes"
function quantityChanged(event) {
    var input = event.target;
    if (isNaN(input.value) || input.value <= 0) {
        input.value = 1;
    }
    updateTotal();
}

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

function addProductToCart(title, price, productImg) {
    var cartShopBox = document.createElement("div");
    cartShopBox.classList.add("cart-box");
    var cartItems = document.getElementsByClassName("cart-content")[0];
    var cartItemsNames = cartItems.getElementsByClassName("cart-product-title");
    for (var i = 0; i < cartItemsNames.length; i++) {
        if (cartItemsNames[i].innerText == title) {
            alert("You have already added this item to cart!")
            return;
        }
    }
    var cartBoxContent = `
                    <img src="${productImg}" alt="" class="cart-img">
                    <div class="detail-box">
                        <div class="cart-product-title">${title}</div>
                        <div class="cart-price">${price}</div>
                        <input type="number" value="1" min="1" class="cart-quantity">
                    </div>
                    <!-- REMOVE BUTTON -->
                    <i class="fas fa-trash cart-remove"></i>`;
    cartShopBox.innerHTML = cartBoxContent;
    cartItems.append(cartShopBox);
    cartShopBox
        .getElementsByClassName("cart-remove")[0]
        .addEventListener('click', removeCartItem);
    cartShopBox
        .getElementsByClassName("cart-quantity")[0]
        .addEventListener('change', quantityChanged);

}

// Update Total
function updateTotal() {
    var cartContent = document.getElementsByClassName("cart-content")[0];
    var cartBoxes = cartContent.getElementsByClassName("cart-box");
    var total = 0;
    for (var i = 0; i < cartBoxes.length; i++) {
        var cartBox = cartBoxes[i];
        var priceElement = cartBox.getElementsByClassName("cart-price")[0];
        var quantityElement = cartBox.getElementsByClassName("cart-quantity")[0];
        var price = parseFloat(priceElement.innerText.replace("VND", ""));
        var quantity = quantityElement.value;
        total = total + (price * quantity);
    }
        total = Math.round(total * 100) / 100;
        
        document.getElementsByClassName("total-price")[0].innerText = total+"VND";
}

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