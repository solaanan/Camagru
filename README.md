# Camagru
This project is a small Instagram-like site allowing users to make and share photo-montages, implemented in PHP, with bare hands (no frameworks), alongside with the basic functionalities encountered on the majority of sites with a user base.
Made @ [1337](https://www.1337.ma/) (One of the [42](https://www.42.fr/) Network Schools).

![screenshot](/screenshots/s1.png?raw=true)

## Main features
* <b>Access gallery</b><br>
You can enter the gallery where you will find the posts of the users without being registered or logged in.

<p align="center">
<img align="center" width="100%" src="/screenshots/s2.gif">
</p>

* <b>Create a new account:</b><br>
You can create a new account, you will be asked to fill in a username that should be unique in our database, a valid email address which you will be asked to verify later on, a strong password that should have at least: 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character

![screenshot](/screenshots/s3.png?raw=true)

then you will be asked to verify your email address, you will find a link to do so in your email's inbox.

* <b>Login to your account:</b><br>
Once verified, you can login to your account.

![screenshot](/screenshots/s4.png?raw=true)

* <b>Add a new post</b><br>
Once logged in, there is two ways to add a new post in Camagru: by taking a new picture with your camera, or uploading a new image from your device.
1. Through your camera:<br>
At the gallery page you will notice there's two buttons have been added, <b>Take a photo</b> and <b>Upload a photo</b>, you click on the first and you will be taken the camera page.

![screenshot](/screenshots/s5.png?raw=true)

Now smile at the camera! make a pose or whatever and click <b>Snap</b>, a text field should appear to add some text your post if you want. Once you hit <b>Save</b> the post should be saved and added to the recent posts field on the right.

![screenshot](/screenshots/s6.png?raw=true)

2. Upload from your device:<br>
If you don't want to use you camera to add a post, you can surely upload an existing image on your device. On the gallery page click <b>Upload a photo</b>, it should redirect you to the page where you can upload a new image.

![screenshot](/screenshots/s7.png?raw=true)

<p align="center">
<img align="center" width="100%" src="/screenshots/s8.gif">
</p>

* <b>Delete a post</b><br>

* <b>Like and comment a post</b><br>

* <b>Visit someone's profile and see their posts</b><br>

* <b>Edit your own profile</b><br>
  You can change your username, email address, password, and your profile picture, you should verify the new email address after changing it.

## Built with:

* Back-end: Vanilla PHP (No MVC).
* Front-end: Vanilla Javascript.
* Database: MySQL. (used PDO interface)
* Styling: CSS, Bootstrap


## Authors

* **Souhaib LAANANI** - *Initial work* - [Imgox](https://github.com/Imgox)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Open for testing:

If you care to test my Camagru, you can visit it through [here](https://slaanani.ml/camagru) and use this test account for login:

| Username | Password |
| --- | --- |
| test | Test@2020 |
