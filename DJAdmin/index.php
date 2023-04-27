<?php
session_start();
if (isset($_GET['user'])) {
  global $useremail;
  $useremail =  $_GET['user'];
  $_SESSION['useremail'] = strtolower($_GET['user']);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Get Heroku ClearDB connection information
  $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $cleardb_server = $cleardb_url["host"];
  $cleardb_username = $cleardb_url["user"];
  $cleardb_password = $cleardb_url["pass"];
  $cleardb_db = substr($cleardb_url["path"],1);
  $active_group = 'default';
  $query_builder = TRUE;
  // Connect to DB
  $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $useremail = $_SESSION['useremail'];
    $name = $_POST['your_name'];
    $artist = $_POST['song_artist'];
    $title = $_POST['song_title'];
    $message = $_POST['message'];

    // Insert data into the database
    $sql = "INSERT INTO queue (Requestee, RequesteeName, Artist, Songname, Message)
            VALUES ('$useremail', '$name' , '$artist', '$title', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web Page</title>
    <style>
      html {
        height : 100%;
        width : 100%;
        padding: 0px;
        margin: 0px;
        overflow: hidden;
        background: linear-gradient(191.9deg, #0A3A81 1.43%, #04142F 87.32%);
      }
      /* Set the background image */
      body {
        background: linear-gradient(191.9deg, #0A3A81 1.43%, #04142F 87.32%);
        padding: 0;
        margin: 0;
        height: 100%;
        width: 100%;
        overflow: hidden;
      }
      /* Style the buttons */
      button {
        display: flex;
        padding-left: 7%;
        padding-right: 7%;
        margin: 2%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 94%;
        height: 21.25%;
        border-radius: 15px;
        color:aliceblue;
        text-align: right;
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 700;
        font-size: 24px;
        justify-content: space-between;
        flex-direction: row;
        align-items: center;
      }
      .button1{
        background: rgba(155, 89, 182, 1);
      }
      .button2{
        background: rgba(231, 76, 60, 1);
      }
      .button3{
        background: rgba(26, 188, 156, 1);
      }
      .button4{
        background: rgba(243, 156, 18, 1);
      }
      .button5{
        background: rgba(243, 156, 18, 1);
        color: black;
        padding: 1%;
        height: 7%;
        width: 82%;
        margin: 5%;
        margin-top: 5%;
        margin-bottom: 0;
        justify-content:center
      }
      .button6{
        background: rgba(243, 156, 18, 0);
        padding: 1%;
        height: 7%;
        width: 80%;
        margin: 5%;
        margin-top: 5%;
        margin-bottom: 0;
        justify-content:center
      }
      .button7{
        background: rgba(155, 89, 182, 1);
      }
      img{
        width: 40px;
        height: 40px;
        padding: 2px;
        background-color: rgba(10, 10, 10, 0.3);
        border-radius: 50%;
      }
      .Main{
        position: relative;
        height: 85%;
        width: 85%;
        left:50%;
        top:50%;
        margin: 0;
        padding: 0;
        transform: translate(-50%, -50%);
        overflow-y: scroll;
      }
      #RequestSong, #AddSong {
        display: none;
        top:55%;
        left:50%;
        transform: translate(-50%, -50%);
      }
      #SongTable{
        display: none;
        top:60%;
        left:50%;
        transform: translate(-50%, -50%);
      }
      #Adminqueue{
        display: none;
        top:50%;
        left:50%;
        width: 100%;
        transform: translate(-50%, -50%);
      }
      textarea {
        display: flex;
        width: 80%;
        background: rgba(0, 0, 0, 0.22);
        margin: 5%;
        padding: 1%;
        margin-bottom: 0%;
        height: 8%;
        border:rgba(16, 68, 146, 1);
        border-radius: 5px;
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 22px;
        color: rgba(240, 248, 255, 1);
        text-align: left;
        vertical-align: top;
      }
      ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: rgb(240, 248, 255);
        opacity: 0.7; /* Firefox */
      }

      :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: rgba(240, 248, 255, 0.7);
      }

      ::-ms-input-placeholder { /* Microsoft Edge */
        color: rgba(240, 248, 255, 0.7);
      }
      #Message{
        height: 25%;
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        padding: 5px;
        text-align: left;
        border: 1px solid #ccc;
      }
      #Back{
        display: none;
        cursor: pointer;
        margin: 0;
        padding: 0;
        width: 40px;
        height: 40px;
        background: transparent;
      }
      #Backimg{
        cursor: pointer;
        background: transparent;
        width: 40px;
        height: 40px;
      }
      #Header{
        color: aliceblue;
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 30px;
        line-height: 36px;
        padding: 0;
        padding-left: 5%;
        margin: 0;
      }
      .Top{
        position: absolute;
        top: 0;
        left: 0;
        padding: 5%;
        padding-bottom: 0%;
        display: flex;
        width: 100%;
        flex-direction: column;
      }
      tr{
        border: none;
        padding-left: 7.5%;
        border-bottom: solid rgba(15, 37, 122);
        width: max-content;
      }
      td{
        border: none;
        width: max-content;
        padding-left: 7.5%;
      }
      .Queue{
        border: none;
      }
      .inline1{
        display: flex;
        position: relative;
        flex-direction: row;
        justify-content: flex-start;
        align-items: flex-start;
        height: 20px;
        margin: 10px;
        margin-left: 0;
      }
      .inline2{
        display: flex;
        position: relative;
        flex-direction: row;
        justify-content: flex-start;
        align-items: flex-start;
        height: 20px;
        margin-bottom: 30px;
        margin-left: 0;
      }
      .text1 {
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        color: aliceblue;
        margin-right: 5px;
        overflow: hidden;
        white-space: nowrap;
      }

      .text2 {
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        color: #3D7EDE;
        margin-right: 5px;
        overflow: hidden;
        white-space: nowrap;
      }
      .text3 {
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 15px;
        color: aliceblue;
        margin-right: 5px;
        overflow: hidden;
        white-space: nowrap;
      }

      .text4 {
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 15px;
        color: #FFAF15;
        margin-right: 5px;
        overflow: hidden;
        white-space: nowrap;
      }
      .text5{
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 300;
        font-size: 14px;
        color: aliceblue;
      }
      .buttons{
        display: flex;
      }
      .Playing{
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border-style: solid;
        border-width: 2px;
        border-color: rgba(155, 89, 182, 1);
        background-color: transparent;
        background-image: url("Assets/Playing.png");
        background-position: center;
        margin-right: 5px;
      }
      .Played{
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border-style: solid;
        border-width: 2px;
        border-color: rgba(46, 204, 113, 1);
        background-color: transparent;
        background-image: url("Assets/Played.png");
        background-position: center;
        margin-left: 5px;
      }
      .Queue td {
        position: relative;
      }
      .Queue .buttons {
        position: relative;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-evenly;
        margin-top: 100%;
      }
      .SongNames{
        display: flex;
        flex-direction: column;
      }
      .text6{
        margin: 0;
        margin-left: 1%;
        color: aliceblue;
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
      }
      .text7{
        margin: 0;
        margin-left: 1%;
        color: rgba(61, 126, 222, 1);
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 600;
        font-size: 10px;
      }
      .SongButton{
        width: 100%;
        height: 100%;
        background-color: red;
        background-image: url("Assets/Artist.png");
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 50%;
        margin-right: 0;
      }
      .AddSongstdbutton{
        padding: 5px;
        margin: 0;
        width: 70px;
        height: 60px;
      }
      .AddSongstdsong{
        padding-left: 1%;
      }
      #Taptext{
        display: none;
        margin: 0;
        color: aliceblue;
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 700;
        font-size: 18px;
      }
      #extratext{
        display: none;
        margin: 0;
        margin-left: 7px;
        color: rgba(255, 175, 21, 1);
        font-family: 'Lexend';
        font-style: normal;
        font-weight: 700;
        font-size: 18px;
      }
      .topinfo{
        display: flex;
        margin-left: 1%;
      }
      .Toptitle{
        display: flex;
        flex-direction: row;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <div id="Main" class = "Main">
      <button class = "button1">
        <img src = "Assets/Request.png">
        Request Song
      </button>
      <button class = "button2">
        <img src = "Assets/Artist.png">
        Songs by Artist
      </button>
      <button class = "button3">
        <img src = "Assets/Title.png">
        Songs by Title
      </button>
      <button class = "button4">
        <img src = "Assets/Queue.png">
        View Queue
      </button>
      <button class = "button7">
        <img src = "Assets/Add.png">
        Add Song to Database
      </button>
    </div>
    <div id="RequestSong" class="Main">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="useremail" value="<?php echo $useremail; ?>">
        <textarea name="your_name" placeholder="Your Name"></textarea>
        <textarea name="song_artist" placeholder="Song Artist"></textarea>
        <textarea name="song_title" placeholder="Song Title"></textarea>
        <textarea id="Message" name="message" placeholder="Message (Optional)"></textarea>
        <button type="submit" class="button5">Submit</button>
        <button type="button" class="button6">Cancel</button>
      </form>
    </div>
    <div id="SongTable" class = "Main">
      <table></table>
    </div>
    <div id="Adminqueue" class = "Main">
      <table></table>
    </div>
    <div id="AddSong" class="Main">
      <form method="post" action="add_song.php">
        <textarea name="song_artist" placeholder="Song Artist"></textarea>
        <textarea name="song_name" placeholder="Song Name"></textarea>
        <button type="submit" class="button5">Submit</button>
        <button type="button" class="button6">Cancel</button>
      </form>
    </div>
    <div class = "Top">
      <div class = "Toptitle">
        <button id="Back"><img id = "Backimg" src="Assets/Back.png"></button>
        <p id="Header" display = "none"></p>
      </div>
      <div class = "topinfo">
        <p id="Taptext">Tap</p>
        <p id="extratext">the icon to select to request a song</p>
      </div>
    </div>
    <script>
      const Backbutton = document.getElementById("Back")
      const Headertext = document.getElementById("Header")
      const taptext = document.getElementById("Taptext")
      const extratext = document.getElementById("extratext")
      function showInputContainer() {
        Backbutton.style.display = "block"
        Headertext.style.display = "block"
        Headertext.innerHTML = "Request a Song"
        document.getElementById('Main').style.display = 'none';
        document.getElementById('RequestSong').style.display = 'block';
      }

      async function showTableContainerName() {
        taptext.style.display = "block"
        extratext.style.display = "block"
        Backbutton.style.display = "block"
        Headertext.style.display = "block"
        Headertext.innerHTML = "Song by Title"
        document.getElementById('Main').style.display = 'none';
        document.getElementById('SongTable').style.display = 'block';

        // Fetch data from the server and populate the table
        const sort_by = 'Songname'; // You can change this to any valid column name in your database
        const response = await fetch(`get_songs.php?sort_by=${sort_by}`);
        const data = await response.json();
        const table = document.querySelector("#SongTable table");
        table.innerHTML = "";
        table.classList = "SongsByArtist";
        // Populate table rows
        data.forEach((row) => {
          const tr = table.insertRow();
          td1 = tr.insertCell();
          td1.classList = "AddSongstdbutton"
          td1.innerHTML = `
          <button id="${row.Songname}" class = "SongButton"></button>
          `
          let button = document.getElementById(row.Songname)
          button.dataset.songname = row.Songname
          button.dataset.artist = row.Artist
          const td2 = tr.insertCell();
          td2.classList = "AddSongstdsong"
          td2.innerHTML = `
          <div class = "SongNames">
            <p class = "text6">${row.Songname}</p>
            <p class = "text7">${row.Artist}</p>
          </div>
          `;
        });
        let btns = document.querySelectorAll(".SongButton")
        btns.forEach((btn) => {
          btn.addEventListener("click", function(){
            console.log(btn.id, btn.value)
            goBack()
            document.querySelector('textarea[name="song_artist"]').value = btn.dataset.artist
            document.querySelector('textarea[name="song_title"]').value = btn.dataset.songname
            showInputContainer()
          })
        })
      }
      async function showTableContainerArtist() {
        taptext.style.display = "block"
        extratext.style.display = "block"
        Backbutton.style.display = "block";
        Headertext.style.display = "block";
        Headertext.innerHTML = "Song by Artist";
        document.getElementById('Main').style.display = 'none';
        document.getElementById('SongTable').style.display = 'block';

        // Fetch data from the server and populate the table
        const sort_by = 'Artist'; // You can change this to any valid column name in your database
        const response = await fetch(`get_songs.php?sort_by=${sort_by}`);
        const data = await response.json();
        const table = document.querySelector("#SongTable table");
        table.innerHTML = "";
        table.classList = "SongsByArtist";
        // Populate table rows
        data.forEach((row) => {
          const tr = table.insertRow();
          td1 = tr.insertCell();
          td1.classList = "AddSongstdbutton"
          td1.innerHTML = `
          <button id="${row.Songname}" class = "SongButton"></button>
          `
          let button = document.getElementById(row.Songname)
          button.dataset.songname = row.Songname
          button.dataset.artist = row.Artist

          const td2 = tr.insertCell();
          td2.classList = "AddSongstdsong"
          td2.innerHTML = `
          <div class = "SongNames">
            <p class = "text6">${row.Artist}</p>
            <p class = "text7">${row.Songname}</p>
          </div>
          `;
        });
        let btns = document.querySelectorAll(".SongButton")
        btns.forEach((btn) => {
          btn.addEventListener("click", function(){
            console.log(btn.id, btn.value)
            goBack()
            document.querySelector('textarea[name="song_artist"]').value = btn.dataset.artist
            document.querySelector('textarea[name="song_title"]').value = btn.dataset.songname
            showInputContainer()
          })
        })
      }

      async function showAdminQueueContainer() {
        Backbutton.style.display = "block";
        Headertext.style.display = "block";
        Headertext.innerHTML = "Admin Song Queue";
        document.getElementById('Main').style.display = 'none';
        document.getElementById('Adminqueue').style.display = 'block';

        // Fetch data from the server and populate the table
        const response = await fetch("get_queue.php");
        const data = await response.json();
        const table = document.querySelector("#Adminqueue table");
        table.innerHTML = "";
        table.classList = "Queue"

        // Populate table rows
        data.forEach((row) => {
          const tr = table.insertRow();
          tr.id = "tr"+row.Requestee;
          // First column: Requestee, RequesteeName, Artist, SongTitle, Message
          const td1 = tr.insertCell();
          td1.innerHTML = `
            <div class = "inline1">
              <p class = "text1">${row.Artist} -  </p>
              <p class = "text2"> ${row.SongName}</p>
            </div>
            <div class = "inline2">
              <p class = "text3">${row.RequesteeName} </p>
              <p class = "text4"> ${row.Requestee}</p>
            </div>
            <p class = "text5">${row.Message}</p>
          `;

          // Second column: Checkbox
          const td2 = tr.insertCell();
          td2.classList = "buttons";
          td2.innerHTML = `
            <button class="Playing" id = "${row.Playing}"></button>
            <button class="Played" id = "${row.Requestee}"></button>
          `;
        });
        let Playings = document.querySelectorAll(".Playing").forEach((btn, index) => {
          if(btn.id=="1"){
            btn.style.backgroundColor = "rgb(155, 89, 182)"
          }else{
            btn.style.backgroundColor = "transparent"
          }
          btn.addEventListener("click", async function () {
            if (btn.style.backgroundColor == "transparent") {
              btn.style.backgroundColor = "rgb(155, 89, 182)";
              playing = 1;
            } else if (btn.style.backgroundColor == "rgb(155, 89, 182)") {
              btn.style.backgroundColor = "transparent";
              playing = 0;
            } else {
              btn.style.backgroundColor = "rgb(155, 89, 182, 1)";
              playing = 1;
            }
            // Get the requestee from the row data
            const requestee = data[index].Requestee;

            // Make an AJAX request to update_playing.php to update the Playing column
            await fetch(`update_playing.php?requestee=${requestee}&playing=${playing}`);
          });
        });
        let Playeds = document.querySelectorAll(".Played").forEach((btn)=>{
          btn.addEventListener("click", function(){
            if(btn.style.backgroundColor=="transparent"){
              btn.style.backgroundColor = "rgb(46, 204, 113)"
            }else if(btn.style.backgroundColor == "rgb(46, 204, 113)"){
              btn.style.backgroundColor = "transparent"
            }
            else{
              btn.style.backgroundColor = "rgb(46, 204, 113)"
            }
            const songId = btn.id
            console.log(songId)
            deleteSong(songId);
          })
        })
      }
      function showAddsong() {
        Backbutton.style.display = "block"
        Headertext.style.display = "block"
        Headertext.innerHTML = "Admin Add Song"
        document.getElementById('Main').style.display = 'none';
        document.getElementById('AddSong').style.display = 'block';
      }
      function goBack(){
        taptext.style.display = "none"
        extratext.style.display = "none"
        document.getElementById('Main').style.display = 'block';
        document.getElementById('Adminqueue').style.display = 'none';
        document.getElementById('SongTable').style.display = 'none';
        document.getElementById('RequestSong').style.display = 'none';
        document.getElementById('AddSong').style.display = 'none';
        Backbutton.style.display = "none"
        Headertext.style.display = "none"
        let table = document.getElementById('SongTable')
      }
      function DoPlayed(event){
        console.log(event)
      }
      function DoPlaying(event){
        console.log(event)
      }
      async function deleteSong(songId) {
        const response = await fetch('delete_song.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `song_id=${songId}`
        });

        const result = await response.json();

        if (result.status === 'success') {
          let rowid = "tr"+songId
          console.log(rowid)
          let row = document.getElementById(rowid)
          console.log(row)
          row.remove();
        } else {
          console.error(result.message);
        }
      }
      Backbutton.addEventListener("click", goBack)
      document.querySelector('.button7').addEventListener("click", showAddsong)
      document.querySelector('.button1').addEventListener('click', showInputContainer);
      document.querySelector('.button2').addEventListener('click', showTableContainerArtist);
      document.querySelector('.button3').addEventListener('click', showTableContainerName);
      document.querySelector('.button4').addEventListener('click', showAdminQueueContainer);
    </script>
  </body>
</html>