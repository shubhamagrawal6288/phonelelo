<?php
session_start();

if (isset($_SESSION['loggedin']) == true) {
  // User is logged in, so you can access their username
  $username = $_SESSION['name'];
  $mail = $_SESSION['mail'];

} else {
  // User is not logged in
  //header("location: login.html");
  echo "do it again ";
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phone Reselling Website</title>
  <link rel="stylesheet" href="style.css">
  <style>
    

    body {
    font-family: Arial, sans-serif;
    margin: 0;
    }

    .slideshow-container {
    position: relative;
    max-width: 1500px;
    margin: auto;
    overflow: hidden;
    height: 600px;
    }

    .slide {
    display: none;
    }

    .slide img {
    width: 100%;
    }

    .prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    }

    .prev {
    left: 0;
    border-radius: 3px 0 0 3px;
    color: black;
    }

    .next {
    right: 0;
    border-radius: 3px 3px 0 0;
    color: black ;
    }

    .prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
    }

    .fade {
    animation: fade 1.5s;
    }

    @keyframes fade {
    from {opacity: 0.4}
    to {opacity: 1}
    }

    </style>
</head>

<body>

  <div class="logo">
    Phone lelo.com
    <br>
    <span id="element"></span>
  </div>
  <header>
    <div class="container">

      <nav>
        <ul>
          <li><a href="profile.php">Home</a></li>
          <li><a href="buy.php">Buy </a></li>
          <li><a href="sell.php">Sell</a></li>
          <li><a href="Contact.php">Contact</a></li>
          <li>
            <div class="profile">
              <button id="profile-btn"><img src="profile.png" height="20px"
                  width="20px"><span><?php echo $username ?></span></button>
              <div class="profile-dropdown">
                <a href="my.php">My Profile </a>
                <a href="logout.php">Logout</a>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <div class="slideshow-container">
    <div class="slide fade">
      <img src="ban1.jpg" alt="Image 1" >
    </div>
    <div class="slide fade">
      <img src="ban2.jpg" alt="Image 2" >
    </div>
    <div class="slide fade">
      <img src="ban3.jpg" alt="Image 3" >
    </div>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
    <a class="next" onclick="changeSlide(1)">&#10095;</a>
  </div>


  <section class="hero">
    <div class="container">
      <h2>Find Your Perfect Phone</h2>
      <p>Discover the latest smartphones at great prices</p>
      <a href="#" class="btn">Shop Now</a>
    </div>

  <footer>
    
  </footer>

  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script>
    var typed = new Typed('#element', {
      strings: ['<i>Sell A Phone </i>', 'Buy A Phone '],
      typeSpeed: 80,
      cursorClass: 'typed-cursor',
      loop: true
    });

    let slideIndex = 1;
    showSlides(slideIndex);

    function changeSlide(n) {
      showSlides(slideIndex += n);
    }

    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("slide");
      if (n > slides.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";  
      }
      slides[slideIndex-1].style.display = "block";  
    }

    // Automatic slideshow
    setInterval(() => {
      showSlides(slideIndex += 1);
    }, 2000); // Change image every 2 seconds
  </script>

</body>

</html>