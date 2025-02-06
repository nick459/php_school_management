<?php
include('db.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Navbar</title>
        <style>
           * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Navbar Container */
        .navbar {
            display: flex;                /* Align items horizontally */
            justify-content: space-between; /* Space between logo and menu */
            align-items: center;          /* Center items vertically */
            background-color: brown;    /* Navbar background color */
            padding: 15px 30px;           /* Spacing inside navbar */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
            position: fixed;
            width: 100%;
        }

        /* Welcome Heading */
        .navbar h3 {
            color: yellow;
            font-size: 20px;
            line-height: 1.4;             /* Line spacing for stacked text */
            letter-spacing: 1px;          /* Spacing between letters */
            text-align: center;
        }

        /* Navigation List */
        .navbar ul {
            list-style: none;             /* Remove bullet points */
            display: flex;                /* Display items in a row */
        }

        /* List Items */
        .navbar li {
            margin: 0 15px;               /* Space between menu items */
        }

        /* Navigation Links */
        .navbar a {
            text-decoration: none;        /* Remove underline */
            color: rgb(9, 116, 237);                 /* Link text color */
            font-size: 22px;
            padding: 2px 10px;            /* Add padding around text */
            transition: background 0.3s, color 0.3s; /* Smooth hover effect */
            font-weight: bold;
        }

        /* Hover Effect */
        .navbar a:hover {
            background-color: black;      /* Background changes on hover */
            color: white;               /* Text color changes on hover */
            border-radius: 8px;           /* Rounded corners */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;   /* Stack items vertically on small screens */
                align-items: flex-start;  /* Align items to the left */
            }

            .navbar ul {
                flex-direction: column;   /* Stack menu items vertically */
                width: 100%;
            }

            .navbar li {
                margin: 10px 0;           /* Space between vertical items */
            }

            .navbar a {
                width: 100%;              /* Full-width clickable links */
                text-align: center;       /* Center the text */
            }
        }
        h2{
            text-align: center;
            background-color: aqua;
            color: yellow;
            font-size: 35px;
            position: fixed;
            width: 100%;
        }
        h1{
            text-align: center;
            color: yellowgreen;
            font-size: 30px;
            font-style: italic;
        }
        </style>
        <link rel="stylesheet" href="footer.css">
    </head>
    <body>
        <header>
            <div class="navbar">
                <h3>WELCOME<br>TO<BR>E.S.A<br></h3>
                
                <ul>
                    <li><a href="schooldash.php">Home</a></li>
                    <li><a href="stud_login.php">Student</a></li>
                    <li><a href="teach_login.php">Teacher</a></li>

                    <li><a href="#bottom">Contact</a></li>
                    <li><a href="">About Us</a></li>
                    <li><a href="admin_dash.php">ADMIN</a></li>
                </ul>
            </div>
        </header>
        <br><br><br><br><br><br><br><br>
        <h1>WELCOME TO</h1>
        <br><br><br><br>
        <h2>ELGIBOR SABOTI PRIMARY & JUNIOR SECONDARY SCHOOL<BR>BOARDING & DAY SCHOOL</h2>
            <footer>
            <footer>
                <div class="container">
                    <div class="footer-content">
                        <h3>Contact Us</h3>
                        <p>Phone: 0740261565</p>
                        <p>Email: elgiboracad@gmail.com</p>
                        <p>Address: 1276, Kitale</p>
                        
                    </div>
                    <div class="footer-content">
                        <h3>Services</h3>
                        <p>We offer Quality and reliable education</p>
                        <p>CBC Compliant School</p>
                        <p>Primary Section</p>
                        <li>Playgroup,PP1 & PP2</li>
                        <li>GRADE 1 - GRADE 6</li>
                        <p>Junior Secondary School(JSS)</p>
                        <li>GRADE 7 - GRADE 9</li>
                    </div>
                    <div class="footer-content">
                        <h3>Follow Us</h3>
                        <li>Facebook</li>
                    </div>
                </div>
                <div class="bottom-bar">
                    <p>&copy;2024 elgiborschool.A11 Rights are Reserved</p>
                </div>
            
                </div>
            </footer>
            </footer>
    </body>
</html>