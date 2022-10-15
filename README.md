[//]: # (<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>)

[//]: # ()
[//]: # (<p align="center">)

[//]: # (<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>)

[//]: # (</p>)

[//]: # ()
[//]: # (## About Laravel)

[//]: # ()
[//]: # (Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:)

[//]: # ()
[//]: # (- [Simple, fast routing engine]&#40;https://laravel.com/docs/routing&#41;.)

[//]: # (- [Powerful dependency injection container]&#40;https://laravel.com/docs/container&#41;.)

[//]: # (- Multiple back-ends for [session]&#40;https://laravel.com/docs/session&#41; and [cache]&#40;https://laravel.com/docs/cache&#41; storage.)

[//]: # (- Expressive, intuitive [database ORM]&#40;https://laravel.com/docs/eloquent&#41;.)

[//]: # (- Database agnostic [schema migrations]&#40;https://laravel.com/docs/migrations&#41;.)

[//]: # (- [Robust background job processing]&#40;https://laravel.com/docs/queues&#41;.)

[//]: # (- [Real-time event broadcasting]&#40;https://laravel.com/docs/broadcasting&#41;.)

[//]: # ()
[//]: # (Laravel is accessible, powerful, and provides tools required for large, robust applications.)

[//]: # ()
[//]: # (## Learning Laravel)

[//]: # ()
[//]: # (Laravel has the most extensive and thorough [documentation]&#40;https://laravel.com/docs&#41; and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.)

[//]: # ()
[//]: # (If you don't feel like reading, [Laracasts]&#40;https://laracasts.com&#41; can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.)

[//]: # ()
[//]: # (## Laravel Sponsors)

[//]: # ()
[//]: # (We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page]&#40;https://patreon.com/taylorotwell&#41;.)

[//]: # ()
[//]: # (### Premium Partners)

[//]: # ()
[//]: # (- **[Vehikl]&#40;https://vehikl.com/&#41;**)

[//]: # (- **[Tighten Co.]&#40;https://tighten.co&#41;**)

[//]: # (- **[Kirschbaum Development Group]&#40;https://kirschbaumdevelopment.com&#41;**)

[//]: # (- **[64 Robots]&#40;https://64robots.com&#41;**)

[//]: # (- **[Cubet Techno Labs]&#40;https://cubettech.com&#41;**)

[//]: # (- **[Cyber-Duck]&#40;https://cyber-duck.co.uk&#41;**)

[//]: # (- **[Many]&#40;https://www.many.co.uk&#41;**)

[//]: # (- **[Webdock, Fast VPS Hosting]&#40;https://www.webdock.io/en&#41;**)

[//]: # (- **[DevSquad]&#40;https://devsquad.com&#41;**)

[//]: # (- **[Curotec]&#40;https://www.curotec.com/services/technologies/laravel/&#41;**)

[//]: # (- **[OP.GG]&#40;https://op.gg&#41;**)

[//]: # (- **[WebReinvent]&#40;https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors&#41;**)

[//]: # (- **[Lendio]&#40;https://lendio.com&#41;**)

[//]: # ()
[//]: # (## Contributing)

[//]: # ()
[//]: # (Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation]&#40;https://laravel.com/docs/contributions&#41;.)

[//]: # ()
[//]: # (## Code of Conduct)

[//]: # ()
[//]: # (In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct]&#40;https://laravel.com/docs/contributions#code-of-conduct&#41;.)

[//]: # ()
[//]: # (## Security Vulnerabilities)

[//]: # ()
[//]: # (If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com]&#40;mailto:taylor@laravel.com&#41;. All security vulnerabilities will be promptly addressed.)

[//]: # ()
[//]: # (## License)

[//]: # ()
[//]: # (The Laravel framework is open-sourced software licensed under the [MIT license]&#40;https://opensource.org/licenses/MIT&#41;.)

## About the Project
Wieder API, is an interface that provides necessary elements to both its React Front End Application.

## Getting Started
After setting up the .env file and generate its application key.

Copy the folders located in 'backup-img' and paste them in 'img' folder, they are both in the same public path.

After that initial step, run these commands:

    1 - php artisan migrate:fresh
The above command will create a fresh installation of mysql database based on the .env file and migrations in '/database/migrations'.
    
    2 - php artisan db:seed
This will populate the migrated database with predefined records that was created in '/database/seeders'.

You're done, hope you have a good time reviewing the project!
