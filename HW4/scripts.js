function promptUser() {
  var numHotDogs = prompt("How many hot dogs?");
  var numFries = prompt("How many fries?");
  var numDrinks = prompt("How many drinks?");
  const order = {
    numHotDogs: Number(numHotDogs),
    numFries: Number(numFries),
    numDrinks: Number(numDrinks),
  };
  return order;
}

function calculateOrder(order) {
  var formatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  });
  var hotDogVal = order.numHotDogs * 3.75;
  var friesVal = order.numFries * 2;
  var drinksVal = order.numDrinks * 1.8;
  var subTotal = hotDogVal + friesVal + drinksVal;

  var total,
    tax,
    pretax = subTotal,
    discount = 0;
  if (subTotal >= 20) {
    pretax = subTotal * 0.9;
    discount = "-" + subTotal * 0.1;
  }

  tax = pretax * 0.0625;
  total = pretax + tax;

  hotDogVal = formatter.format(hotDogVal);
  friesVal = formatter.format(friesVal);
  drinksVal = formatter.format(drinksVal);
  subTotal = formatter.format(subTotal);
  total = formatter.format(total);
  discount = formatter.format(discount);
  tax = formatter.format(tax);

  document.getElementById("num-hot-dogs").innerHTML = order.numHotDogs;
  document.getElementById("price-hot-dogs").innerHTML = hotDogVal;
  document.getElementById("num-fries").innerHTML = order.numFries;
  document.getElementById("price-fries").innerHTML = friesVal;
  document.getElementById("num-drinks").innerHTML = order.numDrinks;
  document.getElementById("price-drinks").innerHTML = drinksVal;
  document.getElementById("subtotal").innerHTML = subTotal;
  document.getElementById("discount").innerHTML = discount;
  document.getElementById("tax").innerHTML = tax;
  document.getElementById("total").innerHTML = total;
}

calculateOrder(promptUser());
