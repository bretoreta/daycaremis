## About DaycareMIS

Daycare Management Information Syatem is an open source web application built using the Laravel Framework for managing a daycare facility and its daily activities. The UI is simple, colorful, user friendly and easy to use. Currently it can do the bare minimum but as updates keep getting released it will support more features. It currently has the following features:

- Simple, fast tasks proccessing.
- Expressive, intuitive and elegant User Interface.
- Robust Cookie-based User Management.
- Simple attendance management
- Simple actions recording
- Simple database notification system


I would like to mention that I have pretty many exciting updates in line for this application, so constantly I will be updating it as I finish up the features I would like to add to it.

## Using The Application

For you to use the application you'll need to download it to your computer. This can be done in to ways. If you gave **GIT** installed then you can follow the next step. If you don't have it installed please skip the following step.

- Open the folder you wish the project to be located and open a new command prompt (WindowsOS) or Terminal(Linux/MacOS) there.
- Type in the following command.

<code>$~ git clone https://github.com/bremmurd/daycaremis.git</code>

- After successfull completeion the project will be in the opened folder in a sub-folder called daycaremis.

If however you do not have **GIT** installed you can just download the project directly from here by clicking the code button and then click download zip file.

Once you have the project you'll need to install the dependencies. Both **NPM** and **COMPOSER** need to be installed for this to work. If you haven't please do so. After installing both applicatons now run the following commands in order.

<code>$~ composer install</code>
<code>$~ npm install</code>
<code>$~ npm run dev</code>

After a successful completion of the three, the application is ready to be served. To serve the application please run the following command in your terminal or command prompt.

<code>$~ php artisan serve</code>

Copy the address shown and open it in your browser, and there you go! The app should be now working! Please remember however to create a database named daycare in your database provider. You can change database related settings on the **.env** file.

## DaycareMIS Sponsors

I sadly do not have any sponsors at the momment however if you like my work and would like to sponsor me you can reach me through my personal email via [bremmurd08@gmail.com](mailto:bremmurd08@gmail.com)

## Contributing

The application is open for any contributors and I highly welcome any new ideas for the system

## Security Vulnerabilities

If you discover a security vulnerability within DaycareMIS, please send an e-mail to Bret Oreta via [bretoreta@gmail.com](mailto:bretoreta@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The DaycareMIS application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
