# Dinosaur Park (PHPUnit)

## About the project

The project is built on top of the Symfony 6 with phpunit, prophecy and other useful bundles. Followed by the tutorial of
[PHPUnit: Testing with a Bite](https://symfonycasts.com/screencast/phpunit) 🦖. This project made with latest at this 
time Symfony framework and language, because this course used Symfony 3 and PHPUnit 6.  

### Build with

![PHP8](https://img.shields.io/static/v1?style=flat&message=PHP%208&color=777BB4&logoColor=white&logo=php&label=)
![Symfony](https://img.shields.io/static/v1?style=flat&message=Symfony%206&color=000000&logo=Symfony&logoColor=FFFFFF&label=)

![CircleCI](https://img.shields.io/circleci/build/github/bmykyta/phpunit/main?style=flat)
[![codecov](https://codecov.io/gh/bmykyta/phpunit/branch/main/graph/badge.svg?token=ASLA1WM2AM)](https://codecov.io/gh/bmykyta/phpunit)

![GitHub top language](https://img.shields.io/github/languages/top/bmykyta/phpunit?style=flat)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/bmykyta/phpunit?style=flat)
![GitHub repo size](https://img.shields.io/github/repo-size/bmykyta/phpunit?style=flat)

## Getting Started

### Prerequisites

- PHP 8
- Composer

### Installation

1. Clone the repo:
```bash
git clone https://github.com/bmykyta/phpunit.git
```
2. Copy the .env file and adjust to your needs
3. Run composer install, create DB, run migrations and also create a schema for tests
```bash
composer intall
php bin/console d:d:c 
php bin/console d:m:m -n
php bin/console d:s:c --env=test
```

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create.
Any contributions you make are **greatly appreciated**. 👏

If you have a suggestion that would make this better, please fork the repo and create a pull request.
You can also simply open an issue with the tag "_enhancement_".
Don't forget to give the project a star ⭐! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request