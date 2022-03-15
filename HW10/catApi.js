function fetchCatFact() {
  fetch("https://catfact.ninja/fact/?max_length=80")
    .then((res) => res.json())
    .then((data) => {
      document.getElementById("cat-fact").innerHTML = data.fact;
    });
}

function ajaxCatCall() {
  request = new XMLHttpRequest();
  request.open("GET", "https://catfact.ninja/fact/?max_length=80", true);
  request.onreadystatechange = () => {
    if (request.readyState == 4 && request.status == 200) {
      var data = JSON.parse(request.responseText);
      document.getElementById("cat-fact").innerHTML = data.fact;
    } else if (request.readyState == 4 && request.status != 200) {
      document.getElementById("cat-fact").innerHTML = "Could not get cat fact";
    } else if (request.readyState == 3) {
      document.getElementById("cat-fact").innerHTML = "Loading cat fact";
    }
  };
  request.send();
}
