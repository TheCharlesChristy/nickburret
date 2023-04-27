<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DJ Nick Burret!</title>
        <style>
            html {
                height : 100%;
                width : 100%;
                padding: 0px;
                margin: 0px;
                overflow: hidden;
                background: linear-gradient(rgba(11, 39, 92, 1), rgba(16, 17, 51, 1)), linear-gradient(to right, rgba(4, 20, 47, 0), rgba(30, 65, 150, 0), rgba(30, 65, 150, 0), rgba(4, 20, 47, 0));
            }
            body{
                position: absolute;
                left: 50%;
                overflow: hidden;
                padding: 0px;
                margin: 0px;
                transform: translate(-50%, 0%);
                height: 100%;
                width: 420px;
                background-image: url("Assets/Homebg.png"), linear-gradient(rgba(10, 58, 129, 1), rgba(4, 20, 47, 1));
                background-position-x: center;
                background-repeat: no-repeat;
                background-size: 100% 100%;
                color: aliceblue;
            }
            h1 {
              position: absolute;
              width: 245px;
              height: 0px;
              left: 50%;
              transform: translate(-50%, 0%);
              top: 15px;
              font-family: 'Lexend';
              font-style: normal;
              font-weight: 600;
              font-size: 30px;
              line-height: 36px;
              text-align: center;

              color: #FFFFFF;
            }
            .icon{
              position: absolute;
              width: 270px;
              height: 330px;
              left: 50%;
              transform: translate(-50%, 0%);
              top: 125px;
            }
            ::placeholder {
              color: aliceblue;
              opacity: 1; /* Firefox */
            }

            :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: aliceblue;
            }

            ::-ms-input-placeholder { /* Microsoft Edge */
            color: aliceblue;
            }
            form {
              position: absolute;
              left: 50%;
              top: 520px;
              transform: translate(-50%, 0%);
              height: 140px;
              width: 400px;
            }
            .email {
              position: absolute;
              left: 50%;
              transform: translate(-50%, 0%);
              border-radius: 4px;
              border-width: 2px;
              border-color: rgba(16, 17, 51, 1);
              font-size: large;
              color: aliceblue;
              background: transparent;
              height:60px;
              width:380px;
              background-image: url("Assets/email.png");
              background-position-x: calc(100% - 10px);
              background-position-y: center;
              background-repeat: no-repeat;
            }
            button {
              position: absolute;
              width: 380px;
              height: 60px;
              left: 50%;
              bottom: 0px;
              color: black;
              border-color: #FFAF15;
              transform: translate(-50%, 0%);
              background: #FFAF15;
              border-radius: 60px;
            }
        </style>
</head>
<body>
  <h1>Register / Login</h1>
  <img src="Assets/Icon.png" class = "icon">
  <form method="post" action="sendEmail.php">
    <input type="email" id="email" name="email" required placeholder="Enter email" class = "email">
    <button type="submit" name="submit">Send Email</button>
  </form>
</body>
</html>
