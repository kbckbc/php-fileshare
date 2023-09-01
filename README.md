# 2022 Fall, CSE330, Module 2 Group project
* Byeongchan Gwak, 501026, kbckbc
* No partner. This was done by only me.


## What is it about? PHP File Server
* Implement a basic File sharing site using PHP

## Used technique
* Frontend - HTML, CSS, Javascript
* Backend - PHP
* Web server - Apache on Amazon EC2 server
* OS - Linux

## File Sharing Site (40 Points)
* I added 3 users(chan, lee, gwak).
* You can login by typing user's name.
* And I also uploaded some files already.
* [**Go to php File Server**](http://ec2-18-216-66-127.us-east-2.compute.amazonaws.com/~bcgwak/m2g/login.php)

![This is an image](https://github.com/cse330-fall-2022/module2-group-module2-501026/blob/master/fss_screen.png)

## Creative Portion (15 Points)

* The site can support 'Sign up' function. Anyone can join the site for free!
* The site also support 'Delete account' function. If you want to leave, just delete your account.

## A note about creative portion
* I thought that without 'Sign up', the site I've made is kind of imperfect to use
* So, I decided to add the function and I programmed it with two additional php files(signup.php and signout.php)
* When 'Sign up', user.txt file is added with a new username and create folder for the user.
  - Check 'Sign up' user is already a member or not.
  - If it's not, add username to a user.txt file
  - Create a user folder as well.
* When 'Sign out'
  - Remove the user from user.txt file 
  - Delete all the files in the user folder and including user folder itself.
  
  ## Feedback
  -1 Some file name does not work (?filename=ss-6%20(1)%205.pdf) might be interesting to look into.
  
  +1 Very visually appealing, extra credit!
  
  Great work, Keep it up :)

