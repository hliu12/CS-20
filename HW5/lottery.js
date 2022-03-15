winningNums = [12, 15, 24, 35, 48, 3];

function runLottery() {
  arr = randNums();
  updateBalls(arr);
  calculateWinnings(arr);
}

function randNums() {
  arr = [];
  while (arr.length < 5) {
    var r = Math.floor(Math.random() * 48) + 1;
    if (arr.indexOf(r) === -1) arr.push(r);
  }
  arr.push(Math.floor(Math.random() * 18) + 1);
  return arr;
}

function updateBalls(arr) {
  // arr = sortArrExceptLast(arr);
  for (let i = 0; i < 5; i++) {
    document.getElementById("picked" + (i + 1)).innerHTML = arr[i];
  }
  document.getElementById("picked-lucky").innerHTML = arr[5];
}

function sortBalls() {
  arr = sortArrExceptLast(arr);
  updateBalls(arr);
}

function calculateWinnings(arr) {
  var matches = numMatches(arr, winningNums);
  var luckyBall = arr[5] == 3;
  var winnings;
  switch (matches) {
    case 0:
      luckyBall ? (winnings = 4) : (winnings = 0);
      break;
    case 1:
      luckyBall ? (winnings = 6) : (winnings = 0);
      break;
    case 2:
      luckyBall ? (winnings = 25) : (winnings = 3);
      break;
    case 3:
      luckyBall ? (winnings = 150) : (winnings = 20);
      break;
    case 4:
      luckyBall ? (winnings = 5000) : (winnings = 200);
      break;
    case 5:
      luckyBall ? (winnings = 7000) : (winnings = 25000);
      break;
  }

  document.getElementById("sort-div").style.display = "flex";
  document.getElementById("num-matches").innerHTML =
    "Number of matches: " + matches;
  if (luckyBall) {
    document.getElementById("lucky-info").innerHTML = "Lucky ball matched!";
  } else {
    document.getElementById("lucky-info").innerHTML = "Lucky ball not matched";
  }
  document.getElementById("winnings").innerHTML = "You won $" + winnings + "!";
  if (winnings > 0) {
    document.getElementById("winnings").style.color = "darkgreen";
  } else {
    document.getElementById("winnings").style.color = "black";
  }
}

function numMatches(arr1, arr2) {
  arr1 = sortArrExceptLast(arr1);
  arr2 = sortArrExceptLast(arr2);
  var i1 = 0;
  var i2 = 0;
  var matches = 0;
  while (i1 < 5 && i2 < 5) {
    if (arr1[i1] > arr2[i2]) {
      i2++;
    } else if (arr1[i1] < arr2[i2]) {
      i1++;
    } else {
      matches++;
      i1++;
      i2++;
    }
  }
  return matches;
}

function sortArrExceptLast(arr) {
  var balls = arr.splice(0, 5);
  balls.sort((a, b) => a - b);
  arr.splice(0, 0, ...balls);
  return arr;
}

// updateBalls();
