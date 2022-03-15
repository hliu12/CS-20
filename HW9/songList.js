// Displays songs and raw Json
function displayAllSongs() {
  // Gets songs by using fetch, displays songs in promise
  fetch("./songList.json")
    .then((response) => response.json())
    .then((data) => {
      displaySongs(data);
      displayJsonString(data);
    });
}

// Displays songs in DOM
function displaySongs(songData) {
  console.log(songData);
  songData.forEach((song) => {
    if (song) {
      var songDiv = makeSongDiv(song);
      document.getElementById("song-container").appendChild(songDiv);
    }
  });
}

// Displays raw string json
function displayJsonString(data) {
  var jsonDiv = document.getElementById("raw-json");
  jsonDiv.innerHTML = JSON.stringify(data);
}

// Filters songs in songList by genre
function filter() {
  // Gets genre from select menu
  var select = document.getElementById("genreSelect");
  var genre = select.options[select.selectedIndex].value;

  // Filters songList based on genre, displays modified list
  fetch("./songList.json")
    .then((response) => response.json())
    .then((data) => {
      // Clears previous songs
      document.getElementById("song-container").innerHTML = "";
      // Filters and displays new songs
      var filteredJson = filterSongs(data, genre);
      displaySongs(filteredJson);
      displayJsonString(filteredJson);
    })
    .catch((error) => console.log(error));
}

// Filters JSON based off genre, returns filtered JSON
function filterSongs(songData, genre) {
  if (genre == "All Songs") {
    displayAllSongs();
    return;
  }
  var filteredSongs = songData;
  for (let index = 0; index < filteredSongs.length; index++) {
    const song = filteredSongs[index];
    if (!song.genre.includes(genre)) {
      delete filteredSongs[index];
    }
  }
  return filteredSongs;
}

// Creates div holding each song
function makeSongDiv(song) {
  var songDiv = makeDiv("song", "");

  var titleDiv = makeDiv("title", song.title);
  songDiv.appendChild(titleDiv);

  var artistDiv = makeDiv("artist", "Artist: " + song.artist);
  songDiv.appendChild(artistDiv);

  var genreString = "";
  song.genre.forEach((genre) => {
    genreString += genre + " ";
  });

  var genreDiv = makeDiv("genre", "Genre: " + genreString);
  songDiv.appendChild(genreDiv);

  var yearDiv = makeDiv("year", "Year: " + song.year);
  songDiv.appendChild(yearDiv);

  return songDiv;
}

// Makes a div with class className and innerHTML value
function makeDiv(className, value) {
  var div = document.createElement("div");
  div.setAttribute("class", className);
  div.innerHTML = value;
  return div;
}

displayAllSongs();
