function updatePage() {
  var num1 = document.getElementById("num1-box").value;
  var num2 = document.getElementById("num2-box").value;
  displayFactors(num1, 1);
  displayFactors(num2, 2);
  if (isAmicable(num1, num2)) {
    document.getElementById("amicable-info").innerHTML =
      num1 + " and " + num2 + " are amicable!";
  } else {
    document.getElementById("amicable-info").innerHTML =
      num1 + " and " + num2 + " are not amicable!";
  }
}

function isAmicable(num1, num2) {
  const factors1 = getFactors(num1);
  const factors2 = getFactors(num2);
  return arrSum(factors1) == num2 && arrSum(factors2) == num1;
}

function getFactors(num) {
  const factors = [];
  for (let index = 0; index < num; index++) {
    if (num % index == 0) {
      factors.push(index);
    }
  }
  return factors;
}

function displayFactors(num, pos) {
  document.getElementById("number-" + pos).innerHTML =
    "Factors of " + num + ": ";
  for (let index = 0; index < num; index++) {
    if (num % index == 0) {
      document.getElementById("factors-" + pos).innerHTML += index + " ";
    }
  }
}

function arrSum(arr) {
  var sum = 0;
  for (let index = 0; index < arr.length; index++) {
    sum += arr[index];
  }
  return sum;
}

console.log(isAmicable(220, 284));
