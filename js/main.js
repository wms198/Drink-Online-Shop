function toggleMenu() {
  let container = document.getElementById("menu-container");
  container.style.height = "100vh";
  container.classList.toggle("active");
  document.getElementById("burger").classList.toggle("active");
  if (!container.classList.contains("active")) {
    window.setTimeout(() => {
      container.style.height = 0;
    }, 1800);
  }
  
}

function increase_item() {
  let i = document.getElementById("amount");
  i.value = parseInt(i.value) + 1;
}

function decrease_item() {
  let i = document.getElementById("amount");
  i.value = Math.max(parseInt(i.value) - 1, 1);
}

// https://stackoverflow.com/a/24468752
function send(data, success_callback) {
  let xhr = new XMLHttpRequest();
  let url = "api.php";
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/json");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      let json = JSON.parse(xhr.responseText);
      success_callback(json);
    }
  };
  //JSON.stringify() to convert it into a string.
  data = JSON.stringify(data);

  //send data(is a string) to api.php. Because of line 14 in same page
  //Because javascript objects are different (language) then php …
  //...but both javascript and php understand json strings
  xhr.send(data);
}

function update_basket(basket) {
  let amount = basket.total_items;
  console.log(basket);
  document.getElementById("totalAmount").innerHTML = amount;
  let tp = document.getElementById("totalPrice");
  if (tp) {
    tp.innerHTML = basket.total_price.toFixed(2);
    basket.items.forEach((item) => {
      document.getElementById("amount_product_total_" + item.id).innerHTML = item.totalPrice;
    });
  }
}

function add_to_cart() {
  let a = parseInt(document.getElementById("amount").value);
  let id = parseInt(document.getElementById("productId").value);
  send(
    {
      operation: "addToCart",
      id: id,
      amount: a,
      is_total: false,
    },
    update_basket
  );
}

function get_basket() {
  send(
    {
      operation: "getBasket",
    },
    update_basket
  );
}
get_basket();

function update_amount(productId) {
  let amount = parseInt(document.getElementById("amount_product_" + productId).value);
  send(
    {
      operation: "addToCart",
      id: productId,
      amount: amount,
      is_total: true,
    },
    update_basket
  );
}
function remove_item(productId) {
  send(
    {
      operation: "addToCart",
      id: productId,
      amount: 0,
      is_total: true,
    },
    (data) => {
      document.getElementById("product_" + productId).remove();
      update_basket(data);
    }
  );
}

/*function new_address() {
  let firstName = document.getElementById("addressFirstNameNew").value;
  let lastName = document.getElementById("addressLastNameNew").value;
  let company = document.getElementById("addressCompanyNew").value;
  let street = document.getElementById("addressAddress1New").value;
  let city = document.getElementById("addressCityNew").value;
  let country = document.getElementById("addressCountryNew").value;
  let postcode = document.getElementById("addressZipNew").value;
  let phone = document.getElementById("addressPhoneNew").value;
  send({
    operation: "newAddress",
    firstName: firstName,
    lastName: lastName,
    street: street,
    company: company,
    postcode: postcode,
    city: city,
    country: country,
    telefone: phone,
  });
}*/
